<?php

namespace App\Http\Controllers;

use App\model\Inventory;
use App\model\InventoryContractStatus;
use App\model\InventoryContractItems;
use App\model\InventoryContract;
use App\model\InventoryContractType;
use App\Helpers\Utility;
use App\User;
use Auth;
use View;
use Validator;
use Input;
use Hash;
use DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class InventoryContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $mainData = InventoryContract::paginateAllData();
        $contractType = InventoryContractType::getAllData();
        $contractStatus = InventoryContractStatus::getAllData();
        $currSymbol = session('currency')['symbol'];

        if ($request->ajax()) {
            return \Response::json(view::make('inventory_contract.reload',array('mainData' => $mainData,
                'contractType' => $contractType,'contractStatus' => $contractStatus,
                'currSymbol' => $currSymbol))->render());

        }else{
            if(Utility::detectSelected('inventory_access',Auth::user()->id))
                return view::make('inventory_contract.main_view')->with('mainData',$mainData)->with('contractType',$contractType)
                    ->with('contractStatus',$contractStatus)->with('currSymbol',$currSymbol);
            else
                return view::make('errors.403');
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),InventoryContract::$mainRules);
        if($validator->passes()){

            $currId = session('currency')['id'];
            $countData = InventoryContract::countData('name',$request->input('name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                $files = $request->file('attachment');
                $attachment = [];

                if($files != ''){
                    foreach($files as $file){

                        $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalName() . $file->getClientOriginalExtension();

                        $file->move(
                            Utility::FILE_URL(), $file_name
                        );
                        //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A TEXT TYPE MYSQL COLUMN
                        $attachment[] =  $file_name;

                    }
                }

                $uid = Utility::generateUID('inventory_contract');

                $dbDATA = [
                    'uid' => $uid,
                    'name' => ucfirst($request->input('title')),
                    'customer_id' => $request->input('customer'),
                    'total_amount' => $request->input('total_bill'),
                    'contract_status' => $request->input('contract_status'),
                    'recurring_cost' => $request->input('recurring_bill'),
                    'invoice_id' => $request->input('invoice_no'),
                    'recurring_interval' => $request->input('recurring_interval'),
                    'invoice_date' => Utility::standardDate($request->input('invoice_date')),
                    'start_date' => Utility::standardDate($request->input('start_date')),
                    'end_date' => Utility::standardDate($request->input('end_date')),
                    'contract_type' => $request->input('contract_type'),
                    'docs' => json_encode($attachment),
                    'created_by' => Auth::user()->id,
                    'active_status' => Utility::STATUS_ACTIVE,
                    'status' => Utility::STATUS_ACTIVE
                ];


                if($request->input('bom') == 'checked'){

                    $itemId= json_decode($request->input('item_id'));
                    $bomQty = json_decode($request->input('bom_qty'));
                    $bomAmt = json_decode($request->input('bom_amt'));
                    $servicingInterval = json_decode($request->input('servicing_interval'));

                    if (count($itemId) == count($bomQty) && count($itemId) == count($bomAmt)) {
                        $create = InventoryContract::create($dbDATA);

                        for ($i = 0; $i < count($itemId); $i++) {

                            $dbDATA2 = [
                                'item_id' => Utility::checkEmptyArrayItem($itemId,$i,0),
                                'quantity' => Utility::checkEmptyArrayItem($bomQty,$i,0),
                                'contract_id' => $create->id,
                                'extended_amount' => Utility::checkEmptyArrayItem($bomAmt,$i,0),
                                'servicing_interval' => Utility::checkEmptyArrayItem($servicingInterval,$i,0),
                                'next_reminder' =>Utility::addDaysToDate(Utility::checkEmptyArrayItem($servicingInterval,$i,0)),
                                'created_by' => Auth::user()->id,
                                'status' => Utility::STATUS_ACTIVE
                            ];

                            InventoryContractItems::create($dbDATA2);
                        }

                        return response()->json([
                            'message' => 'good',
                            'message2' => 'saved'
                        ]);

                    }

                }else{
                    $create = InventoryContract::create($dbDATA);
                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);

                }



            }
        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    //FETCH AMOUNT WHEN QUANTITY IS ENTERED IN THE FRONTEND
    public function extendedAmount(Request $request)
    {
        //
        $inv = Inventory::firstRow('id',$request->input('invId'));
        $extAmount = $request->input('qty') * $inv->unit_cost;
        return $extAmount;

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

        $inventoryContract = InventoryContract::firstRow('id',$request->input('dataId'));
        $contractType = InventoryContractType::getAllData();
        $contractStatus = InventoryContractStatus::getAllData();
        $currSymbol = session('currency')['symbol'];
        return view::make('inventory_contract.edit_form')->with('edit',$inventoryContract)->with('contractType',$contractType)
            ->with('contractStatus',$contractStatus)->with('currSymbol',$currSymbol);
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

        $validator = Validator::make($request->all(),InventoryContract::$mainRules);
        if($validator->passes()) {

            /*return response()->json([
                'message' => 'good',
                'message2' => $request->input('bom')
            ]); exit();*/
            $editId = $request->input('edit_id');
            $currId = session('currency')['id'];
            $countBom = intval($request->input('count_bom'));


            $dbDATA = [
                'name' => ucfirst($request->input('title')),
                'customer_id' => $request->input('customer'),
                'total_amount' => $request->input('total_bill'),
                'contract_status' => $request->input('contract_status'),
                'recurring_cost' => $request->input('recurring_bill'),
                'invoice_id' => $request->input('invoice_no'),
                'recurring_interval' => $request->input('recurring_interval'),
                'invoice_date' => Utility::standardDate($request->input('invoice_date')),
                'start_date' => Utility::standardDate($request->input('start_date')),
                'end_date' => Utility::standardDate($request->input('end_date')),
                'contract_type' => $request->input('contract_type'),
                'updated_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];


            $rowData = InventoryContract::specialColumns('name', $request->input('name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                        $itemId= json_decode($request->input('item_id'));
                        $bomQty = json_decode($request->input('bom_qty'));
                        $bomAmt = json_decode($request->input('bom_amt'));
                        $servicingInterval = json_decode($request->input('servicing_interval'));

                        //CHECK IF THERE ARE NEW BOM ITEMS ADDED TO THE EXISTING ONES
                        if(count($itemId) > 0) {

                            if (count($itemId) == count($bomQty) && count($itemId) == count($bomAmt)) {
                                $update = InventoryContract::defaultUpdate('id', $editId, $dbDATA);

                                if ($countBom > 0) {


                                        for ($i = 1; $i <= $countBom; $i++) {
                                            if (!empty($request->input('item_id_edit' . $i))) {
                                            $dbDATA2 = [
                                                'item_id' => $request->input('item_id_edit' . $i),
                                                'quantity' => $request->input('bom_qty_edit' . $i),
                                                'extended_amount' => $request->input('bom_amount_edit' . $i),
                                                'servicing_interval' => $request->input('bom_servicing_edit' . $i),
                                                'next_reminder' => Utility::addDaysToDate($request->input('bom_servicing_edit' . $i)),
                                                'updated_by' => Auth::user()->id,
                                            ];

                                            InventoryContract::defaultUpdate('id', $request->input('bom_id' . $i), $dbDATA2);
                                        }   //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA
                                    }

                                }


                                for ($i = 0; $i < count($itemId); $i++) {

                                    $dbDATA2 = [
                                        'item_id' => Utility::checkEmptyArrayItem($itemId,$i,0),
                                        'quantity' => Utility::checkEmptyArrayItem($bomQty,$i,0),
                                        'contract_id' => $editId,
                                        'extended_amount' => Utility::checkEmptyArrayItem($bomAmt,$i,0),
                                        'servicing_interval' => Utility::checkEmptyArrayItem($servicingInterval,$i,0),
                                        'next_reminder' =>Utility::addDaysToDate(Utility::checkEmptyArrayItem($servicingInterval,$i,0)),
                                        'created_by' => Auth::user()->id,
                                        'status' => Utility::STATUS_ACTIVE
                                    ];

                                    InventoryContractItems::create($dbDATA2);
                                }

                                return response()->json([
                                    'message' => 'good',
                                    'message2' => 'saved'
                                ]);

                            }

                        }else{
                            $update = InventoryContract::defaultUpdate('id',$editId,$dbDATA);
                            for ($i = 1; $i <= $countBom; $i++) {
                                if (!empty($request->input('item_id_edit' . $i))) {
                                    $dbDATA2 = [
                                        'item_id' => $request->input('item_id_edit' . $i),
                                        'quantity' => $request->input('bom_qty_edit' . $i),
                                        'extended_amount' => $request->input('bom_amount_edit' . $i),
                                        'servicing_interval' => $request->input('bom_servicing_edit' . $i),
                                        'next_reminder' => Utility::addDaysToDate($request->input('bom_servicing_edit' . $i)),
                                        'updated_by' => Auth::user()->id,
                                    ];

                                    InventoryContractItems::defaultUpdate('id', $request->input('bom_id' . $i), $dbDATA2);
                                }   //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

                            }

                            return response()->json([
                                'message' => 'good',
                                'message2' => 'saved'
                            ]);

                        }


                } else {
                    return response()->json([
                        'message' => 'good',
                        'message2' => 'Entry already exist, please try another entry'
                    ]);

                }

            } else{

                    $itemId= json_decode($request->input('item_id'));
                    $bomQty = json_decode($request->input('bom_qty'));
                    $bomAmt = json_decode($request->input('bom_amt'));
                    $servicingInterval = json_decode($request->input('servicing_interval'));

                    //CHECK IF THERE ARE NEW BOM ITEMS ADDED TO THE EXISTING ONES
                    if(count($itemId) > 0) {
                        if (count($itemId) == count($bomQty) && count($itemId) == count($bomAmt)) {
                            $update = InventoryContract::defaultUpdate('id',$editId,$dbDATA);

                            for ($i = 0; $i < $countBom; $i++) {
                                if (!empty($request->input('item_id_edit' . $i))) {
                                    $dbDATA2 = [
                                        'item_id' => $request->input('item_id_edit' . $i),
                                        'quantity' => $request->input('quantity_edit' . $i),
                                        'extended_amount' => $request->input('bom_amount_edit' . $i),
                                        'servicing_interval' => $request->input('bom_servicing_edit' . $i),
                                        'next_reminder' => Utility::addDaysToDate($request->input('bom_servicing_edit' . $i)),
                                        'updated_by' => Auth::user()->id,
                                    ];

                                    InventoryContractItems::defaultUpdate('id', $request->input('bom_id' . $i), $dbDATA2);
                                }   //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

                            }

                            for ($i = 0; $i < count($itemId); $i++) {

                                $dbDATA2 = [
                                    'item_id' => Utility::checkEmptyArrayItem($itemId,$i,0),
                                    'quantity' => Utility::checkEmptyArrayItem($bomQty,$i,0),
                                    'contract_id' => $editId,
                                    'extended_amount' => Utility::checkEmptyArrayItem($bomAmt,$i,0),
                                    'servicing_interval' => Utility::checkEmptyArrayItem($servicingInterval,$i,0),
                                    'next_reminder' =>Utility::addDaysToDate(Utility::checkEmptyArrayItem($servicingInterval,$i,0)),
                                    'created_by' => Auth::user()->id,
                                    'status' => Utility::STATUS_ACTIVE
                                ];

                                InventoryContractItems::create($dbDATA2);
                            }

                            return response()->json([
                                'message' => 'good',
                                'message2' => 'saved'
                            ]);

                        }

                    }else{
                        $update = InventoryContract::defaultUpdate('id',$editId,$dbDATA);
                        for ($i = 1; $i <= $countBom; $i++) {
                            if (!empty($request->input('item_id_edit' . $i))) {
                                $dbDATA2 = [
                                    'item_id' => $request->input('item_id_edit' . $i),
                                    'quantity' => $request->input('bom_qty_edit' . $i),
                                    'extended_amount' => $request->input('bom_amount_edit' . $i),
                                    'servicing_interval' => $request->input('bom_servicing_edit' . $i),
                                    'next_reminder' => Utility::addDaysToDate($request->input('bom_servicing_edit' . $i)),
                                    'updated_by' => Auth::user()->id,
                                ];

                                InventoryContractItems::defaultUpdate('id', $request->input('bom_id' . $i), $dbDATA2);
                            }   //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

                        }

                        return response()->json([
                            'message' => 'good',
                            'message2' => 'saved'
                        ]);

                    }


            }
        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    public function attachmentForm(Request $request)
    {
        //
        $request = InventoryContract::firstRow('id',$request->input('dataId'));
        return view::make('inventory_contract.attach_form')->with('edit',$request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function editAttachment(Request $request){
        $files = $request->file('attachment');

        $attachment = [];
        $editId = $request->input('edit_id');
        $oldData = InventoryContract::firstRow('id',$editId);
        $oldAttachment = json_decode($oldData->docs);

        if($files != ''){
            foreach($files as $file){
                //return$file;
                $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                $file->move(
                    Utility::FILE_URL(), $file_name
                );
                //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                array_push($oldAttachment,$file_name);

            }
        }

        $attachJson = json_encode($oldAttachment);
        $dbData = [
            'docs' => $attachJson
        ];
        $save = InventoryContract::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message' => 'good',
            'message2' => 'saved'
        ]);

    }

    public function removeAttachment(Request $request){
        $file_name = $request->input('attachment');
        //return $files;
        $attachment = [];
        $editId = $request->input('edit_id');
        $oldData = InventoryContract::firstRow('id',$editId);
        $oldAttachment = json_decode($oldData->docs,true);


        //REMOVE FILES FROM AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
        if (($key = array_search($file_name, $oldAttachment)) !== false) {
            $fileUrl = Utility::FILE_URL($file_name);
            unset($oldAttachment[$key]);
            unlink($fileUrl);
        }


        $attachJson = json_encode($oldAttachment);
        $dbData = [
            'docs' => $attachJson
        ];
        $save = InventoryContract::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message' => 'good',
            'message2' => 'File have been removed'
        ]);

    }

    public function downloadAttachment(){
        $file = $_GET['file'];
        $download = Utility::FILE_URL($file);
        return response()->download($download);
        //return $file;
    }

    public function searchInventory(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = InventoryContract::searchContract($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->uid;
        }

        //print_r($search); exit();
        $contract = array_unique($obtain_array);
        $mainData =  InventoryContract::massData('uid', $contract);
        //print_r($contract); die();
        if (count($contract) > 0) {

            return view::make('inventory_contract.inventory_search')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
        }

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

        $delete = InventoryContract::massUpdate('id', $idArray, $dbData);

        return response()->json([
            'message' => 'deleted',
            'message2' => 'Data deleted successfully'
        ]);

        //END FOR VEHICLE Service LOG DELETE

    }

    public function permDelete(Request $request)
    {
        //
        $id = $request->input('dataId');

        $delete = InventoryContractItems::deleteItem($id);

        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
        ]);

    }

    public function changeStatus(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $status = $request->input('status');
        $dbData = [
            'active_status' => $status
        ];
        $delete = InventoryContract::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
        ]);

    }


}
