<?php

namespace App\Http\Controllers;

use App\model\Warehouse;
use App\model\Zone;
use App\model\WarehouseZone;
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

class WarehouseZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $mainData = WarehouseZone::specialColumns('warehouse_id',$request->input('dataId'));
        $warehouseId = $request->input('dataId');

        if ($request->ajax()) {
            return \Response::json(view::make('warehouse.zones.reload',array('mainData' => $mainData,
                'warehouseId' => $warehouseId))->render());

        }else{
            return view::make('warehouse.zones.reload')->with('mainData',$mainData)->with('warehouseId',$warehouseId);
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
        $validator = Validator::make($request->all(),WarehouseZone::$mainRules);
        if($validator->passes()){
            $inputValues = json_decode($request->input('input_class'));

            for($i=0;$i<count($inputValues);$i++){
                $dbDATA = [
                    'warehouse_id' => $request->input('edit_id'),
                    'zone_id' => $inputValues[$i],
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];


                WarehouseZone::create($dbDATA);

            }

            return response()->json([
                'message' => 'good',
                'message2' => 'saved'
            ]);

        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addForm(Request $request)
    {
        //
        $warehouse = Warehouse::firstRow('id',$request->input('dataId'));
        $zone = Zone::getAllData();
        return view::make('warehouse.zones.add_form')->with('edit',$warehouse)->with('zone',$zone);

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
        $delete = WarehouseZone::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);


    }

}

