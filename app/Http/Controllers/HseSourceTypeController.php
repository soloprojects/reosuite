<?php

namespace App\Http\Controllers;

use App\model\HseSourceType;
use App\model\Department;
use App\Helpers\Utility;
use App\model\HseReports;
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

class HseSourceTypeController extends Controller
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
        $mainData = HseSourceType::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('hse_source_type.reload',array('mainData' => $mainData,))->render());

        }else{
            return view::make('hse_source_type.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),HseSourceType::$mainRules);
        if($validator->passes()){

            $countData = HseSourceType::countData('source_name',$request->input('source_name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'source_name' => ucfirst($request->input('source_name')),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                HseSourceType::create($dbDATA);

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
        $request = HseSourceType::firstRow('id',$request->input('dataId'));
        return view::make('hse_source_type.edit_form')->with('edit',$request);

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
        $validator = Validator::make($request->all(),HseSourceType::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'request_name' => ucfirst($request->input('source_name')),
                'updated_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            $rowData = HseSourceType::specialColumns('source_name', $request->input('source_name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    HseSourceType::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                HseSourceType::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
            $request = HseReports::firstRow('source_id',$var);
            if(empty($request)){
                $inactiveCat[] = $var;
            }else{
                $activeCat[] = $var;
            }
        }

        $message = (count($inactiveCat) < 1) ? ' and '.count($activeCat).
            ' has been used for a HSE report and  and cannot be deleted' : '';
        if(count($inactiveCat) > 0){


            $delete = HseSourceType::massUpdate('id',$inactiveCat,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($inactiveCat).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($activeCat).' has been used for a HSE report and  and cannot be deleted',
                'message' => 'warning'
            ]);

        }


    }

}
