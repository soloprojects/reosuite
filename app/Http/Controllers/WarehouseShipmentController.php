<?php

namespace App\Http\Controllers;

use App\model\WarehouseZone;
use App\model\WhsePickPutAway;
use App\model\Warehouse;
use App\model\Inventory;
use App\model\SalesOrder;
use App\model\SalesExtension;
use Illuminate\Http\Request;
use App\model\WarehouseShipment;
use App\model\Stock;
use App\model\WarehouseEmployee;
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

class WarehouseShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $mainData = WarehouseShipment::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('warehouse_shipment.reload',array('mainData' => $mainData,))->render());

        }else{
            return view::make('warehouse_shipment.main_view')->with('mainData',$mainData);

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
        $mainData = WarehouseShipment::firstRow('id',$request->input('dataId'));
        $salesItems = WarehouseShipment::specialColumns('sales_ext_id',$mainData->sales_ext_id);
        $warehouse = Warehouse::getAllData();
        $zones = WarehouseZone::specialColumns('warehouse_id',$mainData->whse_id);
        return view::make('warehouse_shipment.edit_form')->with('edit',$mainData)->with('warehouse',$warehouse)
            ->with('salesItems',$salesItems)->with('zones',$zones);

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

        $validator = Validator::make($request->all(),WarehouseShipment::$mainRulesEdit);
        if($validator->passes()) {

            $holdEmpty = [];
            for($i=1; $i<= $request->input('count_po'); $i++) {
                if( $request->input('qty_to_ship' . $i) == '' ){
                    $holdEmpty[] = $i;
                }
            }

            if(count($holdEmpty) >0){
                return response()->json([
                    'message' => 'warning',
                    'message2' =>  'please ensure that all the items have quantity to ship'  //json_encode($request->all())  //json_encode($arr)
                ]);
            }

            for($i=1; $i<= $request->input('count_po'); $i++) {
                $dbDATA = [
                    'assigned_user' => $request->input('user'),
                    'assigned_date' => Utility::standardDate($request->input('assigned_date')),
                    'whse_id' => $request->input('warehouse'),
                    'zone_id' => $request->input('zone'),
                    'bin_id' => $request->input('bin'),
                    'customer_ship_no' => $request->input('customer_ship_no'),
                    'shipment_no' => $request->input('shipment_no'),
                    'post_date' => Utility::standardDate($request->input('posting_date')),
                    'qty' => $request->input('qty' . $i),
                    'qty_to_ship' => $request->input('qty_to_ship' . $i),
                    'qty_to_cross_dock' => $request->input('qty_to_cross_dock' . $i),
                    'qty_shipped' => $request->input('qty_shipped' . $i),
                    'qty_outstanding' => $request->input('qty_outstanding' . $i),
                    'due_date' => Utility::standardDate($request->input('due_date' . $i)),
                    'updated_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                WarehouseShipment::defaultUpdate('id', $request->input('edit_id'.$i), $dbDATA);

            }
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

    public function searchWarehouseShipment(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = WarehouseShipment::searchWarehouseShipment($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->sales_id;
        }
        /*for($i=0;$i<count($search);$i++){
            $obtain_array[] = $search[$i]->id;
        }*/
        //print_r($search); exit();
        $shipment_ids = array_unique($obtain_array);
        $mainData =  WarehouseShipment::massDataPaginate('sales_id',$shipment_ids);
        //print_r($obtain_array); die();
        if (count($shipment_ids) > 0) {

            return view::make('warehouse_shipment.shipment_search')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
        }

    }

    //THIS METHOD IS USED IN THE WAREHOUSE SHIPMENT USER INTERFACE
    public function postShipment(Request $request)
    {
        //
        $all_id = json_decode($request->input('all_data'));
        $status = $request->input('status');


        $all = WarehouseShipment::massData('id',$all_id);
        $allArray = [];
        foreach($all as $a){
            $allArray[] = $a->sales_id;
        }
        $updateData = [
            'ship_status' => $status
        ];
        $checkStock = [];
        $noWhse = [];
        $whseMan = [];
        $whseEmp = [];
        if(!empty($all)) {
            $createPost = SalesOrder::massData('id',$allArray);
            foreach ($createPost as $data) {

                $salesQty = ($data->shipped_quantity == '') ? $data->qty : $data->shipped_quantity;
                $checkSales = WarehouseShipment::firstRow('sales_id',$data->id); //CHECK IF ITEM EXIST IN WAREHOUSE SHIPMENT


                //PROCESS IF USER IS POSTING SHIPMENT
                if ($status == Utility::POST_SHIPMENT) {
                    //PROCESS IF ITEM IS IN A WAREHOUSE
                    if ($data->inventory->whse_status == 1) {
                        $shipmentBin = Warehouse::where('id',$data->ship_to_whse)->where('status',Utility::STATUS_ACTIVE)->first(['ship_bin_code']);

                        $realWhse = (empty($checkSales)) ? $data->ship_to_whse : $checkSales->whse_id;
                        $realZone = (empty($checkSales)) ? '0' : $checkSales->zone_id;
                        $realBin = (empty($checkSales)) ? $shipmentBin->ship_bin_code : $checkSales->bin_id;
                        $assignedTo = (empty($checkSales)) ? '0' : $checkSales->assigned_user;
                        $assignedDate = (empty($checkSales)) ? '0000-00-00' : $checkSales->assigned_date;
                        $dueDate = (empty($checkSales)) ? '0000-00-00' : $checkSales->due_date;

                        $qty = (empty($checkSales)) ? $salesQty : $checkSales->qty_to_ship;

                        $dbData = [
                            'item_id' => $data->item_id,
                            'sales_id' => $data->id,
                            'sales_ext_id' => $data->sales_id,
                            'assigned_user' => $assignedTo,
                            'assigned_date' => $assignedDate,
                            'due_date' => $dueDate,
                            'pick_put_type' => Utility::PICK,
                            'to_whse' => $realWhse,
                            'to_zone' => $realZone,
                            'to_bin' => $realBin,
                            'qty' => $qty,
                            'qty_to_handle' => $qty,
                            'pick_put_status' => Utility::ZERO,
                            'status' => Utility::STATUS_ACTIVE,
                            'created_by' => Auth::user()->id
                        ];

                        $checkData = WhsePickPutAway::firstRow('sales_id',$data->id);

                        //WarehouseShipment::defaultUpdate('sales_id',$data->id,$dbDataWhseShipment);
                        WarehouseShipment::deleteItemData('sales_id',$data->id);

                        if(empty($checkData) ){
                            if($data->ship_to_whse != '' && $data->ship_to_whse != 0){
                                WhsePickPutAway::create($dbData);
                                $whseEmp[] = $data->ship_to_whse;


                            }else{
                                $noWhse[] = $data->inventory->item_name;
                            }

                        }

                    }

                }   //END OF POST SHIPMENT


            }


            // BEGINING OF SENDING MAIL TO WAREHOUSE EMPLOYEE
            if(count($whseEmp) >0){
                $uniqueEmp = array_unique($whseEmp);

                foreach($uniqueEmp as $emp){

                    $whseEmployee = WarehouseEmployee::specialColumns('warehouse_id',$emp);


                    $emailContent1 = [];
                    $emailContent1['subject'] = 'Warehouse Pick';

                    if(!empty($whseEmployee)){
                        foreach($whseEmployee as $user){
                            $toMail = $user->access_user->email;
                            $name = $user->access_user->firstname.' '.$user->access_user->lastname;
                            $messageBody = "Hello $name, a new warehouse shipment was posted a while ago and are ready for pick";
                            $emailContent1['message'] = $messageBody;
                            $emailContent1['to_mail'] = $toMail;

                            Notify::warehouseMail('mail.warehouse', $emailContent1,$toMail,'', $emailContent1['subject']);


                        }
                    }

                }

            }
            //END OF SENDING MAIL TO WHAREHOUSE WORKERS

        }


        $displayMessage2 = (count($noWhse) >0) ? ', also '.implode(',',$noWhse).
            ' items have not been assigned to a warehouse,zone and bin and therefore shipment cannot be posted' : '';

        return response()->json([
            'message' => 'deleted',
            'message2' => 'shipment has been posted for the selected items'.$displayMessage2
        ]);



    }


    // THIS METHOD IS USED IN SALES ORDER USER INTERFACE
    public function postCreateShipment(Request $request)
    {
        //
        $all_id = json_decode($request->input('all_data'));
        $status = $request->input('status');

        $createPost = SalesOrder::massData('id',$all_id);
        $updateData = [
            'ship_status' => $status
        ];
        $checkStock = [];
        $noWhse = [];
        $whseMan = [];
        $whseEmp = [];
        if(!empty($createPost)) {
            foreach ($createPost as $data) {

                $salesQty = ($data->shipped_quantity == '') ? $data->quantity : $data->shipped_quantity;
                $checkSales = WarehouseShipment::firstRow('sales_id',$data->id); //CHECK IF ITEM EXIST IN WAREHOUSE SHIPMENT


                //PROCESS IF USER IS POSTING SHIPMENT
                if ($status == Utility::POST_SHIPMENT) {
                    //PROCESS IF ITEM IS IN A WAREHOUSE
                    if ($data->inventory->whse_status == 1) {
                        $checkData = WhsePickPutAway::firstRow('sales_id', $data->id);

                        if (empty($checkData) && empty($checkSales)) {
                            if ($data->ship_to_whse != '' && $data->ship_to_whse != 0) {
                            $shipmentBin = Warehouse::where('id', $data->ship_to_whse)->where('status', Utility::STATUS_ACTIVE)->first(['ship_bin_code']);

                            $realWhse = $data->ship_to_whse;
                            $realBin = $shipmentBin->ship_bin_code;

                            $dbData = [
                                'item_id' => $data->item_id,
                                'sales_id' => $data->id,
                                'sales_ext_id' => $data->sales_id,
                                'pick_put_type' => Utility::PICK,
                                'to_whse' => $realWhse,
                                'to_bin' => $realBin,
                                'qty' => $salesQty,
                                'qty_to_handle' => $salesQty,
                                'pick_put_status' => Utility::ZERO,
                                'status' => Utility::STATUS_ACTIVE,
                                'created_by' => Auth::user()->id
                            ];

                            $dbDataWhseShipment = [
                                'status' => Utility::STATUS_DELETED
                            ];



                                    WhsePickPutAway::create($dbData);
                                    SalesOrder::defaultUpdate('id', $data->id, $updateData);
                                    $whseEmp[] = $data->ship_to_whse;


                                } else {
                                    $noWhse[] = $data->inventory->item_name;
                                }

                            }


                    }
                    //PROCESS IF ITEM IS NOT IN A WAREHOUSE ITEM BUT A STOCK ITEM
                    if ($data->inventory->whse_status == 0) {
                        $invData = Inventory::firstRow('id',$data->item_id);
                        $currQty = $invData->qty;
                        $qtyRemain = $currQty - $data->quantity;
                        $dbData3 = [
                            'item_id' => $data->item_id,
                            'sales_id' => $data->id,
                            'qty' => $data->quantity,
                            'qty_remain' => $qtyRemain,
                            'sales_date' => $data->salesItem->post_date,
                            'status' => Utility::STATUS_ACTIVE,
                            'created_by' => Auth::user()->id
                        ];
                        $checkData = Stock::where('sales_id',$data->id)->where('status',Utility::STATUS_ACTIVE)->first();
                        if(empty($checkData)){
                            Stock::create($dbData3);
                            SalesOrder::defaultUpdate('id',$data->id,$updateData);
                            //UPDATE QUANTITY OF INVENTORY
                            $itemQty = Inventory::where('id',$data->item_id)->where('status',Utility::STATUS_ACTIVE)->first(['qty']);
                            $newQty = $itemQty->qty - $data->quantity;
                            $changeQty = ['qty' => $newQty];
                            Inventory::defaultUpdate('id',$data->item_id,$changeQty);
                        }

                    }

                    // BEGINING OF SENDING MAIL TO WAREHOUSE EMPLOYEE
                    if(count($whseEmp) >0){
                        $uniqueEmp = array_unique($whseEmp);

                        foreach($uniqueEmp as $emp){

                            $whseEmployee = WarehouseEmployee::specialColumns('warehouse_id',$emp);


                            $emailContent1 = [];
                            $emailContent1['subject'] = 'Warehouse Pick';

                            if(!empty($whseEmployee)){
                                foreach($whseEmployee as $user){
                                    $toMail = $user->access_user->email;
                                    $name = $user->access_user->firstname.' '.$user->access_user->lastname;
                                    $messageBody = "Hello $name, a new warehouse shipment was posted a while ago and are ready for pick";
                                    $emailContent1['message'] = $messageBody;
                                    $emailContent1['to_mail'] = $toMail;

                                    Notify::warehouseMail('mail.warehouse', $emailContent1,$toMail,'', $emailContent1['subject']);


                                }
                            }

                        }

                    }
                    //END OF SENDING MAIL TO WHAREHOUSE WORKERS

                }   //END OF POST SHIPMENT

                if($status == Utility::CREATE_SHIPMENT){

                    $dbData2 = [
                        'item_id' => $data->item_id ,
                        'whse_id' => $data->ship_to_whse,
                        'sales_id' => $data->id,
                        'sales_ext_id' => $data->sales_id,
                        'qty' => $salesQty ,
                        'qty_shipped' => $salesQty,
                        'qty_outstanding' => $salesQty,
                        'work_status' => Utility::STATUS_ACTIVE,
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];

                    if($data->inventory->whse_status == '1'){
                        $checkPick = WhsePickPutAway::firstRow('sales_id',$data->id);
                        $checkShipment = WarehouseShipment::firstRow('sales_id',$data->id);
                        if(empty($checkPick) && empty($checkShipment)){
                            WarehouseShipment::create($dbData2);
                            SalesOrder::defaultUpdate('id',$data->id,$updateData);

                            $whseMngr = Warehouse::firstRow('id',$data->ship_to_whse);
                            if($data->ship_to_whse != '' || $data->ship_to_whse != '0'){
                                $whseMan[] = $whseMngr->whseManager->id;
                            }
                        }

                    }

                    //CHECK WHETHER ITEM IS A WHSE ITEM
                    if($data->inventory->whse_status == '0'){
                        $checkStock[] = $data->inventory->item_name;
                    }

                    //SEND MAIL TO WAREHOUSE MANAGER
                    if(count($whseMan)>0){

                        $uniqueMan = array_unique($whseMan);
                        $emailContent1 = [];
                        $emailContent1['subject'] = 'Warehouse Pick';

                        if(!empty($whseMngr)){
                            $manDetails = User::massData('id',$uniqueMan);
                            foreach($manDetails as $user){
                                $toMail = $user->email;
                                $name = $user->firstname.' '.$user->lastname;
                                $messageBody = "Hello $name, a new warehouse shipment was created a while ago, please action request";
                                $emailContent1['message'] = $messageBody;
                                $emailContent1['to_mail'] = $toMail;

                                Notify::warehouseMail('mail.warehouse', $emailContent1,$toMail,'', $emailContent1['subject']);


                            }
                        }

                    }
                    //END OF SEND MAIL TO WAREHOUSE MANAGER

                } //END OF CREATE WAREHOUSE SHIPMENT

            }   //END OF FOREACH POST OR CREATE SHIPMENT


        }

        $displayMessage1 = (count($checkStock) >0) ? ' and '.implode(',',$checkStock).
            ' items were stock items and cannot be created for warehouse shipment' : '';

        $displayMessage2 = (count($noWhse) >0) ? ' also '.implode(',',$noWhse).
            ' items have not been assigned to a warehouse,zone and bin and therefore shipment cannot be posted' : '';

        return response()->json([
            'message' => 'deleted',
            'message2' => 'shipment has been processed for the selected items'.$displayMessage1.$displayMessage2
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
        $delete = WarehouseShipment::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message' => 'deleted',
            'message2' => 'Data deleted successfully'
        ]);
    }
}
