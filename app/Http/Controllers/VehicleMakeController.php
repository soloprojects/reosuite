<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\Vehicle;
use App\model\VehicleMake;
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

class VehicleMakeController extends Controller
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
        $mainData = VehicleMake::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('vehicle_make.reload',array('mainData' => $mainData,))->render());

        }else{
            return view::make('vehicle_make.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),VehicleMake::$mainRules);
        if($validator->passes()){

            $countData = VehicleMake::countData('make_name',$request->input('name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'make_name' => ucfirst($request->input('name')),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                VehicleMake::create($dbDATA);

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
        $request = VehicleMake::firstRow('id',$request->input('dataId'));
        return view::make('vehicle_make.edit_form')->with('edit',$request);

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
        $validator = Validator::make($request->all(),VehicleMake::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'make_name' => ucfirst($request->input('name')),
                'updated_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            $rowData = VehicleMake::specialColumns('make_name', $request->input('name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    VehicleMake::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                VehicleMake::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
            $request = Vehicle::firstRow('make_id',$var);
            if(empty($request)){
                $inactiveCat[] = $var;
            }else{
                $activeCat[] = $var;
            }
        }

        $message = (count($inactiveCat) < 1) ? ' and '.count($activeCat).
            ' make(s) has been used in creating a vehicle and cannot be deleted' : '';
        if(count($inactiveCat) > 0){


            $delete = VehicleMake::massUpdate('id',$inactiveCat,$dbData);

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
