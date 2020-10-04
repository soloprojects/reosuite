<?php

namespace App\Http\Controllers;

use App\model\AccountChart;
use App\model\PutAwayTemplate;
use App\model\AccountJournal;
use App\model\InventoryCategory;
use App\model\InventoryBom;
use App\model\Inventory;
use App\model\UnitMeasure;
use App\model\InventoryType;
use App\model\PhysicalInvCount;
use App\Helpers\Utility;
use App\model\TransferOrder;
use App\model\Stock;
use App\model\WarehouseInventory;
use App\model\WhsePickPutAway;
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

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $mainData = Inventory::paginateAllData();
        $inventoryType = InventoryType::getAllData();
        $itemCategory = InventoryCategory::getAllData();
        $unitMeasure = UnitMeasure::getAllData();
        $invCount = PhysicalInvCount::getAllData();
        $accountChart = AccountChart::getAllData();
        $putAwayTemp = PutAwayTemplate::getAllData();
        $currSymbol = session('currency')['symbol'];

        if ($request->ajax()) {
            return \Response::json(view::make('inventory.reload',array('mainData' => $mainData,
                '$putAwayTemp' => $putAwayTemp,'inventoryType' => $inventoryType,'itemCategory' => $itemCategory,
                'unitMeasure' => $unitMeasure,'invCount' => $invCount, 'accountChart' =>$accountChart,
            'currSymbol' => $currSymbol))->render());

        }else{
            if(Utility::detectSelected('inventory_access',Auth::user()->id))
            return view::make('inventory.main_view')->with('mainData',$mainData)->with('inventoryType',$inventoryType)
                ->with('putAwayTemp',$putAwayTemp)->with('itemCategory',$itemCategory)->with('unitMeasure',$unitMeasure)
                ->with('invCount',$invCount)->with('accountChart',$accountChart)->with('currSymbol',$currSymbol);
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
        $validator = Validator::make($request->all(),Inventory::$mainRules);
        if($validator->passes()){

            $currId = session('currency')['id'];
            $countData = Inventory::countData('item_name',$request->input('name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                $photo = 'default_image.png';
                if($request->hasFile('photo')){

                    $image = $request->file('photo');
                    $filename = date('Y-m-d-H-i-s')."_".$image->getClientOriginalName();
                    $path = Utility::IMG_URL().$filename;

                    Image::make($image->getRealPath())->resize(72,72)->save($path);
                    $photo = $filename;

                }

                $dbDATA = [
                    'item_no' => ucfirst($request->input('item_no')),
                    'item_name' => ucfirst($request->input('name')),
                    'as_of_date' => Utility::standardDate($request->input('date')),
                    'sales_desc' => ucfirst($request->input('sales_desc')),
                    'purchase_desc' => ucfirst($request->input('purchase_desc')),
                    'unit_measure' => ucfirst($request->input('unit_measure')),
                    'qty' => $request->input('quantity'),
                    'assemble_bom' => $request->input('bom'),
                    'shelf_no' => ucfirst($request->input('shelf_no')),
                    'category_id' => ucfirst($request->input('item_category')),
                    'inventory_type' => $request->input('inventory_type'),
                    'whse_status' => $request->input('storage_type'),
                    'search_key' => $request->input('search_keyword'),
                    'pref_vendor' => $request->input('pref_vendor'),
                    're_order_level' => $request->input('re_order_level'),
                    'sku' => $request->input('sku'),
                    'photo' => $photo,
                    'costing_method' => $request->input('costing_method'),
                    'unit_cost' => $request->input('unit_cost'),
                    'expense_account' => $request->input('expense_account'),
                    'unit_price' => $request->input('unit_price'),
                    'curr_id' => $currId,
                    'income_account' => $request->input('income_account'),
                    'inventory_account' => ucfirst($request->input('inventory_account')),
                    'special_equip' => ucfirst($request->input('special_equip')),
                    'put_away_template' => $request->input('put_away_temp'),
                    'invt_count_period' => $request->input('inv_count'),
                    'last_count_period' => $request->input('last_count'),
                    'next_count_start' => $request->input('next_count_start'),
                    'next_count_end' => $request->input('next_count_end'),
                    'cross_dock' => $request->input('cross_dock'),
                    'active_status' => Utility::STATUS_ACTIVE,
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];


                if($request->input('bom') == 'checked'){

                    $itemId= json_decode($request->input('item_id'));
                    $bomQty = json_decode($request->input('bom_qty'));
                    $bomAmt = json_decode($request->input('bom_amt'));

                    if (count($itemId) == count($bomQty) && count($itemId) == count($bomAmt)) {
                        $create = Inventory::create($dbDATA);

                        for ($i = 0; $i < count($itemId); $i++) {

                            $dbDATA2 = [
                                'item_id' => $itemId[$i],
                                'quantity' => htmlentities($bomQty[$i]),
                                'inventory_id' => $create->id,
                                'extended_amount' => htmlentities($bomAmt[$i]),
                                'created_by' => Auth::user()->id,
                                'status' => Utility::STATUS_ACTIVE
                            ];

                            InventoryBom::create($dbDATA2);
                        }

                        return response()->json([
                            'message' => 'good',
                            'message2' => 'saved'
                        ]);

                    }

                }else{
                    $create = Inventory::create($dbDATA);
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

    public function stockInventory(Request $request)
    {
        //
        $stock = Stock::specialColumnsPage('item_id',$request->input('dataId'));
        return view::make('inventory.stock.items')->with('mainData',$stock)->with('itemId',$request->input('dataId'));

    }

    public function warehouseInventory(Request $request)
    {
        //
        $warehouse = WarehouseInventory::specialColumns('item_id',$request->input('dataId'));
        return view::make('inventory.warehouse.items')->with('mainData',$warehouse)->with('itemId',$request->input('dataId'));

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

        $inventory = Inventory::firstRow('id',$request->input('dataId'));
        $inventoryType = InventoryType::getAllData();
        $itemCategory = InventoryCategory::getAllData();
        $unitMeasure = UnitMeasure::getAllData();
        $invCount = PhysicalInvCount::getAllData();
        $accountChart = AccountChart::getAllData();
        $putAwayTemp = PutAwayTemplate::getAllData();
        $currSymbol = session('currency')['symbol'];
        return view::make('Inventory.edit_form')->with('edit',$inventory)->with('putAwayTemp',$putAwayTemp)
            ->with('inventoryType',$inventoryType)->with('unitMeasure',$unitMeasure)->with('invCount',$invCount)
            ->with('accountChart',$accountChart)->with('itemCategory',$itemCategory)->with('currSymbol',$currSymbol);

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

        $validator = Validator::make($request->all(),Inventory::$mainRulesEdit);
        if($validator->passes()) {

            /*return response()->json([
                'message' => 'good',
                'message2' => $request->input('bom')
            ]); exit();*/
            $editId = $request->input('edit_id');
            $currId = session('currency')['id'];
            $countBom = intval($request->input('count_bom'));
            $photo = $request->input('prev_photo');
            if($request->hasFile('photo')){

                $image = $request->file('photo');
                $filename = date('Y-m-d-H-i-s')."_".$image->getClientOriginalName();
                $path = Utility::IMG_URL().$filename;

                Image::make($image->getRealPath())->resize(72,72)->save($path);
                $photo = $filename;

            }

            $dbDATA = [
                'item_no' => ucfirst($request->input('item_no')),
                'item_name' => ucfirst($request->input('name')),
                'as_of_date' => Utility::standardDate($request->input('date')),
                'sales_desc' => ucfirst($request->input('sales_desc')),
                'purchase_desc' => ucfirst($request->input('purchase_desc')),
                'unit_measure' => ucfirst($request->input('unit_measure')),
                'qty' => $request->input('quantity'),
                'assemble_bom' => $request->input('bom'),
                'shelf_no' => $request->input('shelf_no'),
                'category_id' => $request->input('item_category'),
                'inventory_type' => $request->input('inventory_type'),
                'whse_status' => $request->input('storage_type'),
                'search_key' => $request->input('search_keyword'),
                'pref_vendor' => $request->input('pref_vendor'),
                're_order_level' => $request->input('re_order_level'),
                'sku' => $request->input('sku'),
                'photo' => $photo,
                'costing_method' => $request->input('costing_method'),
                'unit_cost' => $request->input('unit_cost'),
                'expense_account' => $request->input('expense_account'),
                'unit_price' => $request->input('unit_price'),
                'curr_id' => $currId,
                'income_account' => $request->input('income_account'),
                'inventory_account' => ucfirst($request->input('inventory_account')),
                'special_equip' => ucfirst($request->input('special_equip')),
                'put_away_template' => $request->input('put_away_temp'),
                'invt_count_period' => $request->input('inv_count'),
                'last_count_period' => $request->input('last_count'),
                'next_count_start' => $request->input('next_count_start'),
                'next_count_end' => $request->input('next_count_end'),
                'cross_dock' => $request->input('cross_dock'),
                'active_status' => Utility::STATUS_ACTIVE,
                'updated_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];


            $rowData = Inventory::specialColumns('item_no', $request->input('item_no'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    if($request->input('bom') == 'checked'){

                        $itemId= json_decode($request->input('item_id'));
                        $bomQty = json_decode($request->input('bom_qty'));
                        $bomAmt = json_decode($request->input('bom_amt'));

                        //CHECK IF THERE ARE NEW BOM ITEMS ADDED TO THE EXISTING ONES
                        if(count($itemId) > 0) {

                            if (count($itemId) == count($bomQty) && count($itemId) == count($bomAmt)) {
                                $update = Inventory::defaultUpdate('id', $editId, $dbDATA);

                                if ($countBom > 0) {

                                    for ($i = 1; $i <= $countBom; $i++) {
                                        if (!empty($request->input('item_id_edit' . $i))) {
                                            $dbDATA2 = [
                                                'item_id' => $request->input('item_id_edit' . $i),
                                                'quantity' => $request->input('bom_qty_edit' . $i),
                                                'extended_amount' => $request->input('bom_amount_edit' . $i),
                                                'updated_by' => Auth::user()->id,
                                            ];

                                            InventoryBom::defaultUpdate('id', $request->input('bom_id' . $i), $dbDATA2);
                                        }   //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA
                                    }

                                }

                                for ($i = 0; $i < count($itemId); $i++) {

                                    $dbDATA2 = [
                                        'item_id' => $itemId[$i],
                                        'quantity' => htmlentities($bomQty[$i]),
                                        'inventory_id' => $editId,
                                        'extended_amount' => htmlentities($bomAmt[$i]),
                                        'created_by' => Auth::user()->id,
                                        'status' => Utility::STATUS_ACTIVE
                                    ];

                                    InventoryBom::create($dbDATA2);
                                }

                                return response()->json([
                                    'message' => 'good',
                                    'message2' => 'saved'
                                ]);

                            }

                        }else{
                            $update = Inventory::defaultUpdate('id',$editId,$dbDATA);
                            for ($i = 1; $i <= $countBom; $i++) {
                                if (!empty($request->input('item_id_edit' . $i))) {
                                    $dbDATA2 = [
                                        'item_id' => $request->input('item_id_edit' . $i),
                                        'quantity' => $request->input('bom_qty_edit' . $i),
                                        'extended_amount' => $request->input('bom_amount_edit' . $i),
                                        'updated_by' => Auth::user()->id,
                                    ];

                                    InventoryBom::defaultUpdate('id', $request->input('bom_id' . $i), $dbDATA2);
                                }   //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

                            }

                            return response()->json([
                                'message' => 'good',
                                'message2' => 'saved'
                            ]);

                        }

                    }else{
                        $update = Inventory::defaultUpdate('id',$editId,$dbDATA);
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

                if($request->input('bom') == 'checked'){

                    $itemId= json_decode($request->input('item_id'));
                    $bomQty = json_decode($request->input('bom_qty'));
                    $bomAmt = json_decode($request->input('bom_amt'));

                    //CHECK IF THERE ARE NEW BOM ITEMS ADDED TO THE EXISTING ONES
                    if(count($itemId) > 0) {
                        if (count($itemId) == count($bomQty) && count($itemId) == count($bomAmt)) {
                            $update = Inventory::defaultUpdate('id',$editId,$dbDATA);

                            for ($i = 0; $i < $countBom; $i++) {

                                if (!empty($request->input('item_id_edit' . $i))) {
                                    $dbDATA2 = [
                                        'item_id' => $request->input('item_id_edit' . $i),
                                        'quantity' => $request->input('quantity_edit' . $i),
                                        'extended_amount' => $request->input('bom_amount_edit' . $i),
                                        'updated_by' => Auth::user()->id,
                                    ];

                                    InventoryBom::defaultUpdate('id', $request->input('bom_id' . $i), $dbDATA2);
                                }   //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

                            }

                            for ($i = 0; $i < count($itemId); $i++) {

                                $dbDATA2 = [
                                    'item_id' => $itemId[$i],
                                    'quantity' => htmlentities($bomQty[$i]),
                                    'inventory_id' => $editId,
                                    'extended_amount' => htmlentities($bomAmt[$i]),
                                    'created_by' => Auth::user()->id,
                                    'status' => Utility::STATUS_ACTIVE
                                ];

                                InventoryBom::create($dbDATA2);
                            }

                            return response()->json([
                                'message' => 'good',
                                'message2' => 'saved'
                            ]);

                        }

                    }

                }else{
                    $update = Inventory::defaultUpdate('id',$editId,$dbDATA);
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

    public function searchInventory(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = Inventory::searchInventory($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->id;
        }
        /*for($i=0;$i<count($search);$i++){
            $obtain_array[] = $search[$i]->id;
        }*/
        //print_r($search); exit();
        $user_ids = array_unique($obtain_array);
        $mainData =  Inventory::massDataPaginate('id', $user_ids);
        //print_r($obtain_array); die();
        if (count($user_ids) > 0) {

            return view::make('inventory.inventory_search')->with('mainData',$mainData);
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
        $all_id = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];

        $in_use = [];
        $unused = [];
        for($i=0;$i<count($all_id);$i++){
            $rowDataSalary = AccountJournal::specialColumns('item_id', $all_id[$i]);
            if(count($rowDataSalary)>0){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }
        $message = (count($unused) > 0) ? ' and '.count($unused).
            ' contact has been used in another module and cannot be deleted' : '';
        if(count($in_use) > 0){
            $delete = Inventory::massUpdate('id',$in_use,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($in_use).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($unused).' contact has been used in another module and cannot be deleted',
                'message' => 'warning'
            ]);

        }


    }

    public function changeStatus(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $status = $request->input('status');
        $dbData = [
            'active_status' => $status
        ];
        $delete = Inventory::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
        ]);

    }

    public function permDelete(Request $request)
    {
        //
        $id = $request->input('dataId');

        $delete = InventoryBom::deleteItem($id);

        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
        ]);

    }


}
