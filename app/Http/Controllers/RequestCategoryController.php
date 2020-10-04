<?php

namespace App\Http\Controllers;

use App\model\RequestCategory;
use App\model\AccountCategory;
use App\model\Department;
use App\Helpers\Utility;
use App\model\Requisition;
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

class RequestCategoryController extends Controller
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
        $mainData = RequestCategory::paginateAllData();
        $dept = Department::getAllData();
        $acctCat = AccountCategory::getAllData();
        $hod = Utility::detectHOD(Auth::user()->id);

        if ($request->ajax()) {
            return \Response::json(view::make('request_category.reload',array('mainData' => $mainData,
                'dept' => $dept,'acct_cat' => $acctCat, 'hod' => $hod))->render());

        }else{
            return view::make('request_category.main_view')->with('mainData',$mainData)->with('dept',$dept)
                ->with('acct_cat',$acctCat)->with('hod',$hod);
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
        $validator = Validator::make($request->all(),RequestCategory::$mainRules);
        if($validator->passes()){

            $general = ($request->input('general') == '1') ? 1 : 0;
            $countData = RequestCategory::countData('request_name',$request->input('request_name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'request_name' => ucfirst($request->input('request_name')),
                    'acct_id' => ucfirst($request->input('account_type')),
                    'dept_id' => ucfirst($request->input('department')),
                    'general' => $general,
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                RequestCategory::create($dbDATA);

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
        $request = RequestCategory::firstRow('id',$request->input('dataId'));
        $dept = Department::getAllData();
        $acct_cat = AccountCategory::getAllData();
        return view::make('request_category.edit_form')->with('edit',$request)->with('dept',$dept)->with('acct_cat',$acct_cat);

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
        $validator = Validator::make($request->all(),RequestCategory::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'request_name' => ucfirst($request->input('request_name')),
                'acct_id' => ucfirst($request->input('account_type')),
                'dept_id' => ucfirst($request->input('department')),
                'updated_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            $rowData = RequestCategory::specialColumns('request_name', $request->input('request_name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    RequestCategory::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                RequestCategory::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

        $in_use = [];
        $unused = [];
        $inactiveCat = [];
        $activeCat = [];
        for($i=0;$i<count($all_id);$i++){
            if(in_array($all_id[$i],Utility::DEFAULT_REQUEST_CATEGORIES)){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }

        foreach($in_use as $var){
            $request = Requisition::firstRow('req_cat',$var);
            if(empty($request)){
                $inactiveCat[] = $var;
            }else{
                $activeCat[] = $var;
            }
        }

        $message = (count($inactiveCat) < 1) ? ' and '.count($activeCat).
            ' category(ies) has been used in another module and cannot be deleted' : '';
        if(count($inactiveCat) > 0){


            $delete = RequestCategory::massUpdate('id',$inactiveCat,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($in_use).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($activeCat).' category(ies) has been used in another module and cannot be deleted',
                'message' => 'warning'
            ]);

        }


    }

}
