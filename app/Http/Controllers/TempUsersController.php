<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\model\TempRoles;
use App\model\TempUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
use App\Http\Requests;
use App\model\SalaryStructure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class TempUsersController extends Controller
{

    //
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $roles = TempRoles::getAllData();        
        $salary = SalaryStructure::getAllData();
        $mainData =  (in_array(Auth::user()->role,Utility::HR_MANAGEMENT)) ? TempUsers::paginateAllData() : TempUsers::specialColumnsPage('dept_id',Auth::user()->dept_id);
        $department = Department::getAllData();


        if ($request->ajax()) {
            return \Response::json(view::make('temp_users.reload',array('mainData' => $mainData,'department' => $department,
            'salary' => $salary,'roles' => $roles))->render());

        }else{
            return view::make('temp_users.main_view')->with('mainData',$mainData)->with('department',$department)
                ->with('roles',$roles)->with('salary',$salary);
        }

    }

    public function externalSignup(Request $request)
    {
        //
        //$req = new Request();

        $department = Department::getAllData();

            return view::make('temp_users.external_signup')->with('department',$department);

    }

    public function externalCandidate(Request $request)
    {
        //
        //$req = new Request();

        $department = Department::getAllData();

        return view::make('temp_users.external_candidate')->with('department',$department);

    }

    public function clientSignup(Request $request)
    {
        //
        //$req = new Request();

        $department = Department::getAllData();

        return view::make('temp_users.client_signup')->with('department',$department);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),TempUsers::$mainRules);
        if($validator->passes()){

            $countData = TempUsers::countData('email',$request->input('email'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                $photo = 'user.png';
                $cv = '';
                if($request->hasFile('photo')){

                    $image = $request->file('photo');
                    $filename = date('Y-m-d-H-i-s')."_".$image->getClientOriginalName();
                    $path = Utility::IMG_URL().$filename;

                    Image::make($image->getRealPath())->resize(72,72)->save($path);
                    $photo = $filename;

                }
                if($request->hasFile('cv')){

                    $image = $request->file('cv');
                    $filename = date('Y-m-d-H-i-s')."_".$image->getClientOriginalName();
                    $path = Utility::FILE_URL().$filename;

                    Image::make($image->getRealPath())->resize(65,50)->save($path);
                    $cv = $filename;

                }

                $uid = Utility::generateUID('temp_users');

                $dbDATA = [
                    'uid' => $uid,
                    'email' => ucfirst($request->input('email')),
                    'password' => Hash::make($request->input('lastname')),
                    'role' => ucfirst($request->input('role')),
                    'firstname' => ucfirst($request->input('firstname')),
                    'lastname' => ucfirst($request->input('lastname')),
                    'othername' => ucfirst($request->input('othername')),
                    'sex' => ucfirst($request->input('gender')),
                    'dob' => ucfirst($request->input('birthdate')),
                    'phone' => ucfirst($request->input('phone')),
                    'discipline' => ucfirst($request->input('discipline')),
                    'experience' => ucfirst($request->input('experience')),
                    'address' => ucfirst($request->input('home_address')),
                    'rate_type' => ucfirst($request->input('rate_type')),
                    'rate' => $request->input('rate'),
                    'dept_id' => $request->input('department'),
                    'salary_id' => $request->input('salary'),
                    'cv' => $cv,
                    'nationality' => ucfirst($request->input('nationality')),
                    'qualification' => ucfirst($request->input('marital_status')),
                    'cert' => ucfirst($request->input('cert')),
                    'cert_expiry_date' => Utility::standardDate($request->input('cert_expiry_date')),
                    'cert_issue_date' => Utility::standardDate($request->input('cert_issue_date')),
                    'photo' => $photo,
                    'title' => ucfirst($request->input('title')),
                    'bupa_hmo_expiry_date' => Utility::standardDate($request->input('bupa_hmo_expiry_date')),
                    'green_card_expiry_date' => Utility::standardDate($request->input('green_card_expiry_date')),
                    'created_by' => Auth::user()->firstname.' '.Auth::user()->lastname,
                    'remember_token' => $request->input('_token'),
                    'active_status' => Utility::STATUS_ACTIVE,
                    'status' => Utility::STATUS_ACTIVE
                ];
                TempUsers::create($dbDATA);

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

    public function createExternalSignup(Request $request)
    {
        //


        $rules = ($request->input('external_type') == 'client') ? TempUsers::$clientRules : TempUsers::$signupRules;

        $firstname =  ucfirst($request->input('firstname'));
        $lastname =   ucfirst($request->input('lastname'));
        if($request->input('external_type') == 'client'){
            $firstname =  ucfirst($request->input('company_name'));
            $lastname =   ucfirst($request->input('country'));
        }

        $validator = Validator::make($request->all(),$rules);
        if($validator->passes()){
            Utility::validatePinCode($request->input('pin_code'));
            $countData = TempUsers::countData('email',$request->input('email'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry/Email already exist, please try another entry'
                ]);

            }else{


                $uid = Utility::generateUID('temp_users');

                $dbDATA = [
                    'uid' => $uid,
                    'email' => ucfirst($request->input('email')),
                    'password' => Hash::make($request->input('password')),
                    'role' => ucfirst($request->input('role')),
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'dept_id' => $request->input('unit'),
                    'remember_token' => $request->input('_token'),
                    'active_status' => Utility::STATUS_ACTIVE,
                    'status' => Utility::STATUS_ACTIVE
                ];
                TempUsers::create($dbDATA);

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
        $roles = TempRoles::getAllData();    
        $salary = SalaryStructure::getAllData();
        $department = Department::getAllData();
        $user = TempUsers::firstRow('id',$request->input('dataId'));
        return view::make('temp_users.edit_form')->with('edit',$user)->with('department',$department)
        ->with('roles',$roles)->with('salary',$salary);

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
        $validator = Validator::make($request->all(),TempUsers::$mainRulesEdit);
        if($validator->passes()) {

            $photo = $request->get('prev_photo');
            $cv = $request->get('prev_sign');

            $new_password = Hash::make($request->input('password'));
            if($request->get('password') == ""){
                $new_password =  $request->input('prev_password');
            }
            if($request->hasFile('photo')){

                $image = $request->file('photo');
                $filename = date('Y-m-d-H-i-s')."_".$image->getClientOriginalName();
                $path = Utility::IMG_URL().$filename;

                Image::make($image->getRealPath())->resize(72,72)->save($path);
                $photo = $filename;
                if($request->get('prev_photo') != 'user.png'){
                    if(file_exists(Utility::IMG_URL().$request->get('prev_photo')))
                        unlink(Utility::IMG_URL().$request->get('prev_photo'));
                }

            }
            if($request->hasFile('cv')){

                $image = $request->file('cv');
                $filename = date('Y-m-d-H-i-s')."_".$image->getClientOriginalName();
                $path = Utility::IMG_URL().$filename;

                Image::make($image->getRealPath())->resize(65,65)->save($path);
                $cv = $filename;
                if($request->get('prev_sign') != ''){
                    unlink($request->get('prev_sign'));
                }

            }

            $dbDATA = [
                'email' => ucfirst($request->input('email')),
                'password' => $new_password,
                'role' => $request->input('role'),
                'firstname' => ucfirst($request->input('firstname')),
                'lastname' => ucfirst($request->input('lastname')),
                'othername' => ucfirst($request->input('othername')),
                'sex' => ucfirst($request->input('gender')),
                'dob' => ucfirst($request->input('birthdate')),
                'phone' => ucfirst($request->input('phone')),
                'discipline' => ucfirst($request->input('discipline')),
                'experience' => ucfirst($request->input('experience')),
                'address' => ucfirst($request->input('home_address')),
                'rate_type' => ucfirst($request->input('rate_type')),
                'rate' => $request->input('rate'),
                'dept_id' => $request->input('department'),
                'salary_id' => $request->input('salary'),
                'cv' => $cv,
                'nationality' => ucfirst($request->input('nationality')),
                'qualification' => ucfirst($request->input('marital_status')),
                'cert' => ucfirst($request->input('cert')),
                'cert_expiry_date' => Utility::standardDate($request->input('cert_expiry_date')),
                'cert_issue_date' => Utility::standardDate($request->input('cert_issue_date')),
                'photo' => $photo,
                'title' => ucfirst($request->input('title')),
                'bupa_hmo_expiry_date' => Utility::standardDate($request->input('bupa_hmo_expiry_date')),
                'green_card_expiry_date' => Utility::standardDate($request->input('green_card_expiry_date')),
                'updated_by' => Auth::user()->firstname.' '.Auth::user()->lastname,
                'active_status' => Utility::STATUS_ACTIVE,
                'status' => Utility::STATUS_ACTIVE
            ];
            $rowData = TempUsers::specialColumns('email', $request->input('email'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    TempUsers::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                TempUsers::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
        $roles = TempRoles::getAllData();
        $department = Department::getAllData();
        $user = TempUsers::firstRow('uid',$uid);
        return view::make('temp_users.single_user')->with('edit',$user)->with('department',$department)->with('roles',$roles);


    }

    public function searchUser(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = (in_array(Auth::user()->role,Utility::HR_MANAGEMENT)) ?  TempUsers::searchUser($_GET['searchVar']) : TempUsers::searchUserDept($_GET['searchVar']) ;
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->uid;
        }
        /*for($i=0;$i<count($search);$i++){
            $obtain_array[] = $search[$i]->id;
        }*/

        $user_ids = array_unique($obtain_array);
        $mainData =  TempUsers::massDataPaginate('uid', $user_ids);
        //print_r($obtain_array); die();
        if (count($user_ids) > 0) {

            return view::make('temp_users.user_search')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
        }

    }

    public function birthday(Request $request){

        $mainData =  TempUsers::birthday();

        return view::make('temp_users.birthday')->with('mainData',$mainData);

    }

    public function downloadAttachment(){
        $file = $_GET['file'];
        $download = Utility::FILE_URL($file);
        return response()->download($download);
        //return $file;
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
        $delete = TempUsers::massUpdate('id',$idArray,$dbData);

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
        $delete = TempUsers::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
        ]);

    }

}
