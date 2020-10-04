<?php

namespace App\Http\Controllers;

use App\model\WarehouseInventory;
use App\model\WarehouseZone;
use App\model\WhsePickPutAway;
use App\model\Warehouse;
use App\model\Inventory;
use App\model\SalesOrder;
use App\model\SalesExtension;
use Illuminate\Http\Request;
use App\model\WarehouseShipment;
use App\model\Zone;
use App\Helpers\Utility;
use App\Helpers\Notify;
use App\User;
use Auth;
use View;
use Validator;
use Input;
use Hash;
use DB;
use Intervention\Image\Facades\Image;
use App\Http\Requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class WhsePickController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $mainData = WhsePickPutAway::specialColumnsPage2('pick_put_status',Utility::ZERO,'pick_put_type',Utility::PICK);

        if ($request->ajax()) {
            return \Response::json(view::make('warehouse_pick.reload',array('mainData' => $mainData,))->render());

        }else{
            return view::make('warehouse_pick.main_view')->with('mainData',$mainData);

        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editForm(Request $request)
    {
        //
        $mainData = WhsePickPutAway::firstRow('id',$request->input('dataId'));
        $salesItems = WhsePickPutAway::specialColumns('sales_ext_id',$mainData->sales_ext_id);
        $zone = WarehouseZone::specialColumns('warehouse_id',$mainData->to_whse);
        return view::make('warehouse_pick.edit_form')->with('edit',$mainData)->with('zone',$zone)
            ->with('salesItems',$salesItems);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $mainRules = [];

        $validator = Validator::make($request->all(),$mainRules);
        if($validator->passes()) {

            $warehouseId = $request->input('warehouse');
            $holdEmpty = [];
            for($i=1; $i<= $request->input('count_po'); $i++) {
                if($request->input('zone'.$i) == '' || $request->input('bin'.$i) == '' ){
                    $holdEmpty[] = $i;
                }
            }

            if(count($holdEmpty) >0){
                return response()->json([
                    'message' => 'warning',
                    'message2' =>  'please ensure that all the items to pick have a selected zone and bin'  //json_encode($request->all())  //json_encode($arr)
                ]);
            }

            for($i=1; $i<= $request->input('count_po'); $i++) {
                $itemId = $request->input('item_id'.$i);
                $quantity = $request->input('qty' . $i);
                $dbDATA = [
                    'assigned_user' => $request->input('user'),
                    'assigned_date' => Utility::standardDate($request->input('assigned_date')),
                    'to_whse' => $request->input('warehouse'),
                    'to_zone' => $request->input('zone'.$i),
                    'to_bin' => $request->input('bin'.$i),
                    'qty' => $request->input('qty' . $i),
                    'qty_to_handle' => $request->input('qty_to_handle' . $i),
                    'qty_handled' => $request->input('qty_handled' . $i),
                    'qty_outstanding' => $request->input('qty_outstanding' . $i),
                    'due_date' => Utility::standardDate($request->input('due_date' . $i)),
                    'pick_put_status' => Utility::STATUS_ACTIVE,
                    'updated_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                WhsePickPutAway::defaultUpdate('id', $request->input('edit_id'.$i), $dbDATA);
                //UPDATE QUANTITY OF INVENTORY
                $itemQty = Inventory::where('id',$itemId)->where('status',Utility::STATUS_ACTIVE)->first(['qty']);
                $newQty = $itemQty->qty - $quantity;
                $changeQty = ['qty' => $newQty];
                Inventory::defaultUpdate('id',$itemId,$changeQty);

                //UPDATE OR CREATE WAREHOUSE INVENTORY FOR TRACKING PURPOSES IN WAREHOUSE INVENTORY TABLE
                $whseInvData = [
                    'qty' => $newQty
                ];

                $whseInvDataCreate = [
                    'item_id' => $itemId,
                    'qty' => $newQty,
                    'warehouse_id' => $request->input('warehouse'),
                    'zone_id' => $request->input('zone'.$i),
                    'bin_id' => $request->input('bin'.$i),
                    'status' => Utility::STATUS_ACTIVE
                ];

                $checkDbData = WarehouseInventory::firstRow4('item_id',$itemId,'warehouse_id',$request->input('warehouse'),
                    'zone_id',$request->input('zone'.$i),'bin_id',$request->input('bin'.$i));
                if(!empty($checkDbData) > 0){
                    WarehouseInventory::defaultUpdate4('item_id',$itemId,'warehouse_id',$request->input('warehouse'),
                        'zone_id',$request->input('zone'.$i),'bin_id',$request->input('bin'.$i),$whseInvData);
                }else{
                    WarehouseInventory::create($whseInvDataCreate);
                }




            }

            //SEND OUT MAIL TO WAREHOUSE MANAGER IF WAREHOUSE IS NOT EMPTY
            $whseData = Warehouse::firstRow('id',$warehouseId);
            $whseMan = $whseData->whseManager->firstname.' '.$whseData->whseManager->lastname;
            $toMail = $whseData->whseManager->email;

            $messageBody = "Hello $whseMan, some Pick(s) were registered a while ago";

            $emailContent = [];
            $emailContent['subject'] = 'Warehouse Pick(s)';
            $emailContent['message'] = $messageBody;
            $emailContent['to_mail'] = $toMail;
            Notify::warehouseMail('mail.warehouse', $emailContent,$toMail,'', $emailContent['subject']);


            return response()->json([
                'message' => 'good',
                'message2' =>  'saved'  //json_encode($request->all())  //json_encode($arr)
            ]);


        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    public function searchWhsePickPutAway(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = WhsePickPutAway::searchWhsePick($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->sales_id;
        }

        //print_r($search); exit();
        $shipment_ids = array_unique($obtain_array);
        $mainData =  WhsePickPutAway::massDataPaginate('sales_id', $shipment_ids);
        //print_r($obtain_array); die();
        if (count($shipment_ids) > 0) {

            return view::make('warehouse_pick.receipt_search')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pick(Request $request)
    {
        //
        $all_id = json_decode($request->input('all_data'));
        $status = $request->input('status');

        $allData = WhsePickPutAway::massData('id',$all_id);
        $updateData = [
            'pick_put_status' => Utility::STATUS_ACTIVE
        ];
        $whseId = [];

        foreach($allData as $data){
            WhsePickPutAway::defaultUpdate('id',$data->id,$updateData);
            $whseId[] = $data->to_whse;
        }

        $whse = array_unique($whseId);
        foreach($whse as $man){

            //SEND OUT MAIL TO WAREHOUSE MANAGER IF WAREHOUSE IS NOT EMPTY
            $whseData = Warehouse::firstRow('id',$man);
            $whseManager = $whseData->whseManager->firstname.' '.$whseData->whseManager->lastname;
            $toMail = $whseData->email;

            $messageBody = "Hello $whseManager, some Pick(s) were registered a while ago";

            $emailContent = [];
            $emailContent['subject'] = 'Warehouse Shipment';
            $emailContent['message'] = $messageBody;
            $emailContent['to_mail'] = $toMail;
            Notify::warehouseMail('mail.warehouse', $emailContent,$toMail,'', $emailContent['subject']);

        }

        return response()->json([
            'message' => 'deleted',
            'message2' => count($all_id).' Put-Away(s) has been processed for the selected items'
        ]);



    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];
        $delete = WhsePickPutAway::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message' => 'deleted',
            'message2' => 'Data deleted successfully'
        ]);
    }
}

