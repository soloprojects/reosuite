<?php

namespace App\Http\Controllers;

use App\model\ZoneBin;
use App\model\Zone;
use App\model\Bin;
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

class ZoneBinController extends Controller
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
        $warehouseId = $request->input('type');
        $mainData = ZoneBin::specialColumns2('warehouse_id',$warehouseId,'zone_id',$request->input('dataId'));
        $zoneId = $request->input('dataId');

        if ($request->ajax()) {
            return \Response::json(view::make('warehouse.bins.reload',array('mainData' => $mainData,
                'zoneId' => $zoneId,'warehouseId' => $warehouseId))->render());

        }else{
            return view::make('warehouse.bins.reload')->with('mainData',$mainData)->with('zoneId',$zoneId)
                ->with('warehouseId',$warehouseId);
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
        $validator = Validator::make($request->all(),ZoneBin::$mainRules);
        if($validator->passes()){
            $inputValues = json_decode($request->input('input_class'));

            for($i=0;$i<count($inputValues);$i++){
                $dbDATA = [
                    'zone_id' => $request->input('edit_id'),
                    'warehouse_id' => $request->input('warehouse'),
                    'bin_id' => $inputValues[$i],
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];


                ZoneBin::create($dbDATA);

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
        $warehouseId = $request->input('type');
        $zone = Zone::firstRow('id',$request->input('dataId'));
        $bin = Bin::getAllData();
        //return $zone; exit();
        return view::make('warehouse.bins.add_form')->with('edit',$zone)->with('bin',$bin)->with('warehouseId',$warehouseId);

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
        $delete = ZoneBin::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);


    }

}
