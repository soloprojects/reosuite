<?php

namespace App\Http\Controllers;

use App\model\CrmActivity;
use App\model\CrmActivityType;
use App\model\Department;
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
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class CrmActivityTypeController extends Controller
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
        $mainData = CrmActivityType::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('crm_activity_type.reload',array('mainData' => $mainData,))->render());

        }else{
            return view::make('crm_activity_type.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),CrmActivityType::$mainRules);
        if($validator->passes()){

            $countData = CrmActivityType::countData('name',$request->input('name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'name' => ucfirst($request->input('name')),
                    'summary' => $request->input('detail'),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                CrmActivityType::create($dbDATA);

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
        $request = CrmActivityType::firstRow('id',$request->input('dataId'));
        return view::make('crm_activity_type.edit_form')->with('edit',$request);

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
        $validator = Validator::make($request->all(),CrmActivityType::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'name' => ucfirst($request->input('name')),
                'summary' => $request->input('detail'),
                'updated_by' => Auth::user()->id,
            ];
            $rowData = CrmActivityType::specialColumns('name', $request->input('name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    CrmActivityType::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                CrmActivityType::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

        $inactiveType = [];
        $activeType = [];

        foreach($all_id as $var){
            $activityTypeRequest = CrmActivityType::firstRow('id',$var);
            if($activityTypeRequest->created_by == Auth::user()->id || in_array(Auth::user()->id,Utility::TOP_USERS)){
                $inactiveType[] = $var;
            }else{
                $activeType[] = $var;
            }
        }

        $message = (count($inactiveType) < 1) ? ' and '.count($activeType).
            ' activity type was not created by you and cannot be deleted' : '';
        if(count($inactiveType) > 0){


            $delete = CrmActivityType::massUpdate('id',$inactiveType,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($inactiveType).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($activeType).' was not created by you and cannot be deleted',
                'message' => 'warning'
            ]);

        }


    }

}
