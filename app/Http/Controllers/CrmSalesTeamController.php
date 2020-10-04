<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\SalesTeam;
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

class CrmSalesTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $mainData = SalesTeam::paginateAllData();
        $this->processData($mainData);

        if ($request->ajax()) {
            return \Response::json(view::make('crm_sales_team.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('crm_sales_team.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),SalesTeam::$mainRules);
        if($validator->passes()){

            $users = $request->input('users');

            $countData = SalesTeam::countData('name',$request->input('name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                $dbDATA = [
                    'name' => ucfirst($request->input('name')),
                    'users' => $users,
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                SalesTeam::create($dbDATA);

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
        $mainData = SalesTeam::firstRow('id',$request->input('dataId'));
        $this->processItemData($mainData);
        return view::make('crm_sales_team.edit_form')->with('edit',$mainData);

    }

    public function removeUser(Request $request){

        $editId = $request->input('dataId');
        $userId = $request->input('param');
        $oldData = SalesTeam::firstRow('id',$editId);
        $oldUsers = json_decode($oldData->users,true);


        //REMOVE USER FROM AN ARRAY
        if (($key = array_search($userId, $oldUsers)) != false) {
            unset($oldUsers[$key]);
        }

        $usersArrayToJson = json_encode($oldUsers);
        $dbData = [
            'users' => $usersArrayToJson,
        ];
        $save = SalesTeam::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message' => 'good',
            'message2' => 'User have been removed'
        ]);

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
        $validator = Validator::make($request->all(),SalesTeam::$mainRulesEdit);
        if($validator->passes()) {
            $users = $request->input('users');

            $dbDATA = [
                'name' => ucfirst($request->input('name')),
                'users' => $users,
                'updated_by' => Auth::user()->id,
            ];
            $rowData = SalesTeam::specialColumns('name', $request->input('name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    SalesTeam::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                SalesTeam::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

    public function searchData(Request $request)
    {

        $searchValue = $request->input('searchVar');
        //PROCESS SEARCH REQUEST
        $mainData = SalesTeam::searchData('name',$searchValue);
        $this->processData($mainData);
            return view::make('crm_sales_team.search')->with('mainData',$mainData);

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

        $inactiveSalesTeam = [];
        $activeSalesTeam = [];

        foreach($all_id as $var){
            $salesTeamRequest = SalesTeam::firstRow('id',$var);
            if($salesTeamRequest->created_by == Auth::user()->id || in_array(Auth::user()->id,Utility::TOP_USERS)){
                $inactiveSalesTeam[] = $var;
            }else{
                $activeSalesTeam[] = $var;
            }
        }

        $message = (count($inactiveSalesTeam) < 1) ? ' and '.count($activeSalesTeam).
            ' sales team was not created by you and cannot be deleted' : '';
        if(count($inactiveSalesTeam) > 0){


            $delete = SalesTeam::massUpdate('id',$inactiveSalesTeam,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($inactiveSalesTeam).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($activeSalesTeam).' was not created by you and cannot be deleted',
                'message' => 'warning'
            ]);

        }

    }

    public function processData($data){
        foreach($data as $val){
            $users = json_decode($val->users,true);

            if(!empty($users)){
                $fetchUsers = User::massData('id',$users);
                $val->userAccess = $fetchUsers;
                $val->userArray = $users;
            }else{
                $val->userAccess = '';
            }

        }
    }

    public function processItemData($val){
        $users = json_decode($val->users,true);

        if(!empty($users)){
            $fetchUsers = User::massData('id',$users);
            $val->userAccess = $fetchUsers;
        }else{
            $val->userAccess = '';
        }

    }

}
