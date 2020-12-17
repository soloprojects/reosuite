<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\model\Position;
use App\model\Department;
use App\model\SalaryStructure;
use App\Helpers\Utility;
use App\User;
use App\model\Roles;
use Auth;
use View;
use Validator;
use Input;
use Hash;
use DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\model\TempUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;

class UsersApiController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        $mainData =  User::paginateAllData();

            return view::make('users_api.reload')->with('mainData',$mainData);
    }

  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userProfile($uid,Request $request)
    {
        //
        $roles = Roles::getAllData();
        $position = Position::getAllData();
        $salary = SalaryStructure::getAllData();
        $department = Department::getAllData();
        $user = User::firstRow('uid',$uid);
        return view::make('users.single_user')->with('edit',$user)->with('salary',$salary)->with('position',$position)
            ->with('department',$department)->with('roles',$roles);


    }

    public function searchUser(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = User::searchUser($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->uid;
        }
        /*for($i=0;$i<count($search);$i++){
            $obtain_array[] = $search[$i]->id;
        }*/

        $user_ids = array_unique($obtain_array);
        $mainData =  User::massDataPaginate('uid', $user_ids);
        //print_r($obtain_array); die();
        if (count($user_ids) > 0) {

            return view::make('users_api.user_search')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
        }

    }

    public function birthday(Request $request){

        $mainData =  User::birthday();

            return view::make('users.birthday')->with('mainData',$mainData);

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
        $delete = User::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

    public function changeStatus(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $status = $request->input('status');
        $dbData = [
            'active_status' => $status
        ];
        $delete = user::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
        ]);

    }

    public function getUserCount(Request $request)
    {
        //
       
        $userData = User::countData('dormant_status',Utility::STATUS_ACTIVE);
        
        return $userData;

    }

    public function changeUserDormantStatus(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $status = $request->input('status');
        $dbData = [
            'dormant_status' => $status
        ];
        $delete = user::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
        ]);

    }

}
