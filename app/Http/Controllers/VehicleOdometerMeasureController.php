<?php

namespace App\Http\Controllers;

use App\model\AccountJournal;
use App\model\BudgetSummary;
use App\model\Inventory;
use App\Helpers\Utility;
use App\model\VehicleOdometerLog;
use App\model\VehicleOdometerMeasure;
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

class VehicleOdometerMeasureController extends Controller
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
        $mainData = VehicleOdometerMeasure::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('vehicle_odometer_measure.reload',array('mainData' => $mainData))->render());

        }
        return view::make('vehicle_odometer_measure.main_view')->with('mainData',$mainData);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),VehicleOdometerMeasure::$mainRules);
        if($validator->passes()){

            $countData = VehicleOdometerMeasure::specialColumns('name',$request->input('name'));
            if($countData->count() > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'name' => $request->input('name'),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                $pro = VehicleOdometerMeasure::create($dbDATA);

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


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editForm(Request $request)
    {
        //
        $dept = VehicleOdometerMeasure::firstRow('id',$request->input('dataId'));
        return view::make('vehicle_odometer_measure.edit_form')->with('edit',$dept);

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
        $validator = Validator::make($request->all(),VehicleOdometerMeasure::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'name' => $request->input('name'),
                'updated_by' => Auth::user()->id
            ];
            $rowData = VehicleOdometerMeasure::specialColumns('name',$request->input('name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    VehicleOdometerMeasure::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);

                } else {
                    return response()->json([
                        'message' => 'good',
                        'message2' => 'Entry already exist, please try another entry'
                    ]);

                }

            } else{
                VehicleOdometerMeasure::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function odometerMeasureStatus(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $id = $idArray[0];
        $check = VehicleOdometerMeasure::countData2('id', $id, 'active_status', '0');
        if ($check > 0) {
            $activeYear = VehicleOdometerMeasure::firstRow('active_status','1');
            $dbData1 = [
                'active_status' => '0'
            ];
            $dbData = [
                'active_status' => Utility::STATUS_ACTIVE,
            ];
            if(!empty($activeYear)){
                $cancelActive = VehicleOdometerMeasure::defaultUpdate('id', $activeYear->id, $dbData1);
            }
            $update = VehicleOdometerMeasure::defaultUpdate('id', $idArray, $dbData);


            return response()->json([
                'message2' => 'changed successfully',
                'message' => 'Status change'
            ]);
        }else{
            return response()->json([
                'message2' => 'rejected',
                'message' => 'Odometer already active'
            ]);
        }

    }

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

            $rowDataActiveMeasure = VehicleOdometerMeasure::specialColumns2('id', $all_id[$i],'active_status',Utility::STATUS_ACTIVE);
            if(count($rowDataActiveMeasure)>0){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }
        $message = (count($unused) > 0) ? ' and '.count($unused).
            ' bin type has been used in another module and cannot be deleted' : '';
        if(count($in_use) > 0){
            $delete = VehicleOdometerMeasure::massUpdate('id',$in_use,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($in_use).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => count($unused).' financial year has been used in recording transactions and cannot be deleted',
                'message' => 'warning'
            ]);

        }

    }

}
