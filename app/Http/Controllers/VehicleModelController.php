<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\Vehicle;
use App\model\VehicleMake;
use App\model\VehicleModel;
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

class VehicleModelController extends Controller
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
        $mainData = VehicleModel::paginateAllData();
        $vehicleMake = VehicleMake::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('vehicle_model.reload',array('mainData' => $mainData,
                'vehicleMake' => $vehicleMake,))->render());

        }else{
            return view::make('vehicle_model.main_view')->with('mainData',$mainData)
                ->with('vehicleMake',$vehicleMake);
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
        $validator = Validator::make($request->all(),VehicleModel::$mainRules);
        if($validator->passes()){

            $countData = VehicleModel::countData('model_name',$request->input('name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'model_name' => ucfirst($request->input('name')),
                    'make_id' => ucfirst($request->input('make')),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                VehicleModel::create($dbDATA);

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
        $request = VehicleModel::firstRow('id',$request->input('dataId'));
        $vehicleMake = VehicleMake::getAllData();
        return view::make('vehicle_model.edit_form')->with('edit',$request)
            ->with('vehicleMake',$vehicleMake);

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
        $validator = Validator::make($request->all(),VehicleModel::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'model_name' => ucfirst($request->input('name')),
                'make_id' => ucfirst($request->input('make')),
                'updated_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            $rowData = VehicleModel::specialColumns('model_name', $request->input('name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    VehicleModel::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                VehicleModel::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

        $inactiveCat = [];
        $activeCat = [];

        foreach($all_id as $var){
            $request = Vehicle::firstRow('model_id',$var);
            if(empty($request)){
                $inactiveCat[] = $var;
            }else{
                $activeCat[] = $var;
            }
        }

        $message = (count($inactiveCat) < 1) ? ' and '.count($activeCat).
            ' model(s) has been used in creating a vehicle and cannot be deleted' : '';
        if(count($inactiveCat) > 0){


            $delete = VehicleModel::massUpdate('id',$inactiveCat,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($inactiveCat).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($activeCat).$message,
                'message' => 'warning'
            ]);

        }


    }

}
