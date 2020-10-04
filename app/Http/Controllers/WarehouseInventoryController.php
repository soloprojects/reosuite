<?php

namespace App\Http\Controllers;


use App\Helpers\Notify;
use App\Helpers\Utility;
use App\model\Inventory;
use App\model\TransferOrder;
use App\model\Warehouse;
use App\model\WarehouseInventory;
use App\model\WarehouseZone;
use App\model\WhsePickPutAway;
use App\model\ZoneBin;
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

class WarehouseInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $warehouse = Warehouse::getAllData();
        $mainData = Warehouse::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('warehouse_inventory.reload',array('mainData' => $mainData,
            'warehouse' => $warehouse))->render());

        }else{
                return view::make('warehouse_inventory.main_view')->with('mainData',$mainData)
                    ->with('warehouse',$warehouse);
        }


    }

    public function warehouseZone(Request $request)
    {
        //
        //$req = new Request();
        $mainData = WarehouseZone::specialColumns('warehouse_id',$request->input('dataId'));
        $warehouseId = $request->input('dataId');

        return view::make('warehouse_inventory.zones.reload')->with('mainData',$mainData)->with('warehouseId',$warehouseId);

    }

    public function warehouseZoneBin(Request $request)
    {
        //
        //$req = new Request();
        $warehouseId = $request->input('type');
        $mainData = ZoneBin::specialColumns2('warehouse_id',$warehouseId,'zone_id',$request->input('dataId'));
        $zoneId = $request->input('dataId');

        return view::make('warehouse_inventory.bins.reload')->with('mainData',$mainData)->with('zoneId',$zoneId)
            ->with('warehouseId',$warehouseId);


    }

    public function binContents(Request $request)
    {
        //
        $warehouseId = $request->input('type');
        $zoneId = $request->input('dataId2');
        $binId = $request->input('dataId');
        $mainData = WarehouseInventory::specialColumns3('warehouse_id',$warehouseId,'zone_id',$zoneId,'bin_id',$binId);

        return view::make('warehouse_inventory.bins.bin_content')->with('mainData',$mainData)->with('zoneId',$zoneId)
            ->with('warehouseId',$warehouseId);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),WarehouseInventory::$mainRules);
        if($validator->passes()){

            /*return response()->json([
                'message' => 'good',
                'message2' => $request->input('item_id').'zone'.$request->input('zone').$request->input('bin')
            ]);*/
            $itemId= json_decode($request->input('item_id'));
            $qty = json_decode($request->input('bom_qty'));
            $dbDATA = [];
            $itemsAndQty = [];
            $it = '';
            if (count($itemId) == count($qty)) {

                for ($i = 0; $i < count($itemId); $i++) {
                    $it = $request->input('warehouse').'zone'.$request->input('zone').$request->input('bin').Utility::checkEmptyArrayItem($itemId,$i,0);
                    $itemData = Inventory::firstRow('id',Utility::checkEmptyArrayItem($itemId,$i,0));
                    $itemQty = (!empty($itemData)) ? $itemData->qty : 0;
                    $itemWhseStatus = (!empty($itemData)) ? $itemData->whse_status : 0;
                    $itemName = (!empty($itemData)) ? $itemData->item_name.' ('.$itemData->item_no.')' : 0;
                    $newQty = $itemQty + Utility::checkEmptyArrayItem($qty,$i,'0');
                    if($itemWhseStatus == Utility::STATUS_ACTIVE) { //CONTINUE IF ITEM IS A WAREHOUSE ITEM
                        $itemsAndQty[] = $itemName.' has '.Utility::checkEmptyArrayItem($qty,$i,'0');
                        $dbDATA = [
                            'item_id' => Utility::checkEmptyArrayItem($itemId, $i, 0),
                            'qty' => $newQty,
                            'warehouse_id' => $request->input('warehouse'),
                            'zone_id' => $request->input('zone'),
                            'bin_id' => $request->input('bin'),
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];

                        $whseCheck = WarehouseInventory::firstRow4('item_id',Utility::checkEmptyArrayItem($itemId, $i, 0),'warehouse_id',$request->input('warehouse'),'zone_id',$request->input('zone'),'bin_id',$request->input('bin'));
                        if(empty($whseCheck)) {
                            WarehouseInventory::create($dbDATA);
                            Inventory::defaultUpdate('id', Utility::checkEmptyArrayItem($itemId, $i, 0), ['qty' => $newQty]);
                        }else{

                            $dbDataUpdate = ['qty' => $newQty];
                            WarehouseInventory::defaultUpdate4('item_id',Utility::checkEmptyArrayItem($itemId, $i, 0),'warehouse_id',$request->input('warehouse'),'zone_id',$request->input('zone'),'bin_id',$request->input('bin'),$dbDataUpdate);
                            //UPDATE QUANTITY IN THE INVENTORY
                            Inventory::defaultUpdate('id', Utility::checkEmptyArrayItem($itemId, $i, 0), ['qty' => $newQty]);

                        }

                    }

                }

                $whseData = Warehouse::firstRow('id',$request->input('warehouse'));
                //SEND MAIL TO WAREHOUSE MANAGER

                    $emailContent1 = [];
                    $emailContent1['subject'] = 'Warehouse Update';

                        $user = User::firstRow('id',$whseData->whse_manager);
                            $toMail = $user->email;
                            $name = $user->firstname.' '.$user->lastname;
                            $messageBody = "Hello $name, the following items was added to the warehouse : ".implode(',',$itemsAndQty);
                            $emailContent1['message'] = $messageBody;
                            $emailContent1['to_mail'] = $toMail;

                            Notify::warehouseMail('mail.warehouse', $emailContent1,$toMail,'', $emailContent1['subject']);

                //END OF SEND MAIL TO WAREHOUSE MANAGER


                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

            }

        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    public function removeWarehouseInventory(Request $request)
    {
        //
        $validator = Validator::make($request->all(),WarehouseInventory::$mainRules);
        if($validator->passes()){

            /*return response()->json([
                'message' => 'good',
                'message2' => $request->input('item_id').'zone'.$request->input('zone').$request->input('bin')
            ]);*/
            $itemId= json_decode($request->input('item_id'));
            $qty = json_decode($request->input('bom_qty'));
            $dbDATA = [];
            $itemsAndQty = [];
            $lowQty = [];
            $notInWarehouse = [];
            if (count($itemId) == count($qty)) {

                for ($i = 0; $i < count($itemId); $i++) {

                    $itemData = Inventory::firstRow('id',Utility::checkEmptyArrayItem($itemId,$i,0));
                    $itemQty = (!empty($itemData)) ? $itemData->qty : 0;
                    $itemWhseStatus = (!empty($itemData)) ? $itemData->whse_status : 0;
                    $itemName = (!empty($itemData)) ? $itemData->item_name.' ('.$itemData->item_no.')' : '';
                    $newQty = $itemQty - Utility::checkEmptyArrayItem($qty,$i,'0');

                    if($itemWhseStatus == Utility::STATUS_ACTIVE) { //CONTINUE IF ITEM IS A WAREHOUSE ITEM
                        $itemsAndQty[] = $itemName.' has '.Utility::checkEmptyArrayItem($qty,$i,'0');


                        $whseCheck = WarehouseInventory::firstRow4('item_id',Utility::checkEmptyArrayItem($itemId, $i, 0),'warehouse_id',$request->input('warehouse'),'zone_id',$request->input('zone'),'bin_id',$request->input('bin'));
                        if(empty($whseCheck)) { //CHECK IF ITEM EXISTS IN WAREHOUSE, ZONE AND BIN
                            $notInWarehouse[] = $itemName;
                        }else{

                            if($whseCheck->qty >= Utility::checkEmptyArrayItem($qty,$i,'0')) {  //CHECK IF QUANTITY IS AVAILABLE IN THE WAREHOUSE
                                $whseQty = $whseCheck->qty - Utility::checkEmptyArrayItem($qty,$i,'0');
                                $dbDataUpdate = ['qty' => $newQty]; $whseDbUpdate = ['qty' => $whseQty];
                                WarehouseInventory::defaultUpdate4('item_id', Utility::checkEmptyArrayItem($itemId, $i, 0), 'warehouse_id', $request->input('warehouse'), 'zone_id', $request->input('zone'), 'bin_id', $request->input('bin'), $whseDbUpdate);
                                //UPDATE QUANTITY IN THE INVENTORY
                                Inventory::defaultUpdate('id', Utility::checkEmptyArrayItem($itemId, $i, 0), ['qty' => $newQty]);
                            }else{
                                $lowQty[] = $itemsAndQty;
                            }

                        }

                    }

                }

                $lowQtyMessage = (count($lowQty) >0) ? implode(',',$lowQty).' items has lesser quantity in the warehouse than
                the quantity planned to be removed.' : '' ;
                $notInWarehouseMessage = (count($notInWarehouse) >0) ? implode(',',$notInWarehouse).' items does not exist
                in the warehouse.' : ''  ;

                $whseData = Warehouse::firstRow('id',$request->input('warehouse'));
                //SEND MAIL TO WAREHOUSE MANAGER

                $emailContent1 = [];
                $emailContent1['subject'] = 'Warehouse Update';

                $user = User::firstRow('id',$whseData->whse_manager);
                $toMail = $user->email;
                $name = $user->firstname.' '.$user->lastname;
                $messageBody = "Hello $name, the following items was removed from the warehouse : ".implode(',',$itemsAndQty);
                $emailContent1['message'] = $messageBody;
                $emailContent1['to_mail'] = $toMail;

                Notify::warehouseMail('mail.warehouse', $emailContent1,$toMail,'', $emailContent1['subject']);

                //END OF SEND MAIL TO WAREHOUSE MANAGER


                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'.$lowQtyMessage.$notInWarehouseMessage
                ]);

            }

        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    public function warehouseInventoryContents(Request $request)
    {
        //
        $warehouse = $request->input('type');
        $item = $request->input('dataId');
        $warehouse = WarehouseInventory::specialColumns3Qty('warehouse_id',$warehouse,'item_id',$item,'qty','1');
        return view::make('inventory.warehouse.items')->with('mainData',$warehouse)->with('itemId',$request->input('dataId'));

    }

    public function searchWarehouseInventoryItems(Request $request)
    {

        $item = $request->input('inventory_item');
        $warehouseIdArr = [];

        //PROCESS SEARCH REQUEST
            $mainData = WarehouseInventory::specialColumnsOneRow('item_id',$item,'warehouse_id');
        //print_r($mainData);
            if($mainData->count() > 0){
                foreach($mainData as $data){
                    $warehouseIdArr[] = $data->warehouse_id;
                }
            }
            $warehouse = Warehouse::massData('id',$warehouseIdArr);


        return view::make('warehouse_inventory.search_warehouse_inventory_items')->with('mainData',$warehouse)->with('itemId',$item);

    }

    public function searchWarehouseInventory(Request $request)
    {


        $warehouse = $request->input('warehouse');
        $zone = $request->input('zone');
        $bin = $request->input('bin');
        $mainData = [];

        //PROCESS SEARCH REQUEST
        if($warehouse != '') {

            if ($zone != '' && $bin != '') {
                $mainData = WarehouseInventory::specialColumns3('warehouse_id', $warehouse, 'zone_id', $zone, 'bin_id', $bin);
            }
            if ($zone != '' && $bin == '') {
                $mainData = WarehouseInventory::specialColumns2('warehouse_id', $warehouse, 'zone_id', $zone);
            }
            if ($zone == '' && $bin == '') {
                $mainData = WarehouseInventory::specialColumns('warehouse_id', $warehouse);
            }

            //print_r($sourceType.$reportType.$startDate.$endDate);
            return view::make('warehouse_inventory.search_warehouse_inventory')->with('mainData', $mainData);

        }

        return 'Please select a warehouse to continue search';

    }


}
