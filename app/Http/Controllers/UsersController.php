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
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class UsersController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $roles = Roles::getAllData();
        $mainData =  User::paginateAllData();
        $position = Position::getAllData();
        $salary = SalaryStructure::getAllData();
        $department = Department::getAllData();


        if ($request->ajax()) {
            return \Response::json(view::make('users.reload',array('mainData' => $mainData,'department' => $department,
            'salary' => $salary,'position' => $position,'roles' => $roles))->render());

        }else{
            return view::make('users.main_view')->with('mainData',$mainData)->with('position',$position)
                ->with('salary',$salary)->with('department',$department)->with('roles',$roles);
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
        $validator = Validator::make($request->all(),User::$mainRules);
        if($validator->passes()){

            $countData = User::countData('email',$request->input('email'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                $photo = 'user.png';
                $sign = '';
                if($request->hasFile('photo')){

                    $image = $request->file('photo');
                    $filename = date('Y-m-d-H-i-s')."_".$image->getClientOriginalName();
                      $path = Utility::IMG_URL().$filename;

                    Image::make($image->getRealPath())->resize(100,100)->save($path);
                    $photo = $filename;

                }
                if($request->hasFile('sign')){

                    $image = $request->file('sign');
                    $filename = date('Y-m-d-H-i-s')."_".$image->getClientOriginalName();
                    $path = Utility::IMG_URL().$filename;

                    Image::make($image->getRealPath())->resize(65,50)->save($path);
                    $sign = $filename;

                }

                $uid = Utility::generateUID('users');

                $dbDATA = [
                    'uid' => $uid,
                    'email' => ucfirst($request->input('email')),
                    'password' => Hash::make($request->input('lastname')),
                    'other_email' => ucfirst($request->input('other_email')),
                    'role' => ucfirst($request->input('role')),
                    'firstname' => ucfirst($request->input('firstname')),
                    'lastname' => ucfirst($request->input('lastname')),
                    'othername' => ucfirst($request->input('othername')),
                    'sex' => ucfirst($request->input('gender')),
                    'dob' => Utility::standardDate($request->input('birthdate')),
                    'phone' => ucfirst($request->input('phone')),
                    'job_role' => ucfirst($request->input('job_role')),
                    'address' => ucfirst($request->input('home_address')),
                    'employ_type' => ucfirst($request->input('employ_type')),
                    'position_id' => $request->input('position'),
                    'dept_id' => $request->input('department'),
                    'salary_id' => $request->input('salary'),
                    'religion' => $request->input('religion'),
                    'nationality' => ucfirst($request->input('nationality')),
                    'marital' => ucfirst($request->input('marital_status')),
                    'blood_group' => ucfirst($request->input('blood_group')),
                    'next_kin' => ucfirst($request->input('next_of_kin')),
                    'next_kin_phone' => ucfirst($request->input('next_of_kin_phone')),
                    'state' => ucfirst($request->input('state')),
                    'local_govt' => ucfirst($request->input('local_govt')),
                    'emergency_name' => ucfirst($request->input('emergency')),
                    'emergency_contact' => $request->input('emergency_contact'),
                    'emergency_phone' => ucfirst($request->input('emergency_phone')),
                    'photo' => $photo,
                    'sign' => $sign,
                    'title' => ucfirst($request->input('title')),
                    'qualification' => ucfirst($request->input('qualification')),
                    'employ_date' => ucfirst($request->input('employ_date')),
                    'created_by' => Auth::user()->firstname.' '.Auth::user()->lastname,
                    'remember_token' => $request->input('_token'),
                    'active_status' => Utility::STATUS_ACTIVE,
                    'status' => Utility::STATUS_ACTIVE
                ];
                User::create($dbDATA);

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
        $roles = Roles::getAllData();
        $position = Position::getAllData();
        $salary = SalaryStructure::getAllData();
        $department = Department::getAllData();
        $user = User::firstRow('id',$request->input('dataId'));
        return view::make('users.edit_form')->with('edit',$user)->with('salary',$salary)->with('position',$position)
            ->with('department',$department)->with('roles',$roles);

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
        $validator = Validator::make($request->all(),User::$mainRulesEdit);
        if($validator->passes()) {

            $photo = $request->get('prev_photo');
            $sign = $request->get('prev_sign');

            $new_password = Hash::make($request->input('password'));
            if($request->get('password') == ""){
                $new_password =  $request->input('prev_password');
            }
            if($request->hasFile('photo')){

                $image = $request->file('photo');
                $filename = date('Y-m-d-H-i-s')."_".$image->getClientOriginalName();
                $path = Utility::IMG_URL().$filename;

                Image::make($image->getRealPath())->resize(100,100)->save($path);
                $photo = $filename;
                if($request->get('prev_photo') != 'user.png'){
                    if(file_exists(Utility::IMG_URL().$request->get('prev_photo')))
                    unlink(Utility::IMG_URL().$request->get('prev_photo'));
                }

            }
            if($request->hasFile('sign')){

                $image = $request->file('sign');
                $filename = date('Y-m-d-H-i-s')."_".$image->getClientOriginalName();
                $path = Utility::IMG_URL().$filename;

                Image::make($image->getRealPath())->resize(65,65)->save($path);
                $sign = $filename;
                if($request->get('prev_sign') != ''){
                    unlink($request->get('prev_sign'));
                }

            }

            $dbDATA = [
                'email' => ucfirst($request->input('email')),
                'password' => $new_password,
                'other_email' => ucfirst($request->input('other_email')),
                'role' => ucfirst($request->input('role')),
                'firstname' => ucfirst($request->input('firstname')),
                'lastname' => ucfirst($request->input('lastname')),
                'othername' => ucfirst($request->input('othername')),
                'sex' => ucfirst($request->input('gender')),
                'dob' => Utility::standardDate($request->input('birthdate')),
                'phone' => ucfirst($request->input('phone')),
                'job_role' => ucfirst($request->input('job_role')),
                'address' => ucfirst($request->input('home_address')),
                'employ_type' => ucfirst($request->input('employ_type')),
                'position_id' => $request->input('position'),
                'dept_id' => $request->input('department'),
                'salary_id' => $request->input('salary'),
                'religion' => $request->input('religion'),
                'nationality' => ucfirst($request->input('nationality')),
                'marital' => ucfirst($request->input('marital_status')),
                'blood_group' => ucfirst($request->input('blood_group')),
                'next_kin' => ucfirst($request->input('next_of_kin')),
                'next_kin_phone' => ucfirst($request->input('next_of_kin_phone')),
                'state' => ucfirst($request->input('state')),
                'local_govt' => ucfirst($request->input('local_govt')),
                'emergency_name' => ucfirst($request->input('emergency')),
                'emergency_contact' => $request->input('emergency_contact'),
                'emergency_phone' => ucfirst($request->input('emergency_phone')),
                'photo' => $photo,
                'sign' => $sign,
                'title' => ucfirst($request->input('title')),
                'qualification' => ucfirst($request->input('qualification')),
                'employ_date' => ucfirst($request->input('employ_date')),
                'updated_by' => Auth::user()->firstname.' '.Auth::user()->lastname,
                'active_status' => Utility::STATUS_ACTIVE,
                'status' => Utility::STATUS_ACTIVE
            ];
            $rowData = User::specialColumns('email', $request->input('email'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    User::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                User::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

            return view::make('users.user_search')->with('mainData',$mainData);
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

}
