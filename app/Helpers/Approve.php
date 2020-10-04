<?php
/**
 * Created by PhpStorm.
 * User: snweze
 * Date: 3/12/2018
 * Time: 2:56 PM
 */

namespace App\Helpers;

use App\User;
use Illuminate\Http\Request;
use DB;
use Auth;
use view;
use mail;
use Illuminate\Support\Facades\Session;
use Psy\Exception\ErrorException;
use Illuminate\Support\Facades\Storage;

class Approve
{

    public static function sanitizeArray(&$data = []){
        $holdArray = [];
        foreach($data as $da){
            $holdArray[] = $da;
        }
        return $holdArray;
    }

    public static function getArrayValue($dkey,$data = []){
        $hold = '';
        foreach($data as $key => $val){
            if($key == $dkey){
                $hold = $val;
            }
        }
        return $hold;
    }

    public static function getArrayVal($arr=[]){
        $hold = '';
        foreach($arr as $key => $val){
            $hold = $val;
        }
        return $hold;
    }

    public static function processApproval(&$appArr,&$nAppLevels,&$nAppUsers,&$appUsers,&$appLevels,$newLevels,$newUsers,&$approvalUser){
        if(in_array(Auth::user()->id,$nAppUsers)){  //CHECK IF USER MAKING REQUISITION IS IN APPROVAL PROCESS

            $holdMyLevel = array_search(Auth::user()->id,$appArr);  //HOLD THE ID OF THE USER
            foreach($appArr as $key => $var){   //LOOP TO REMOVE USER AND ALL LEVEL OF APPROVALS FROM HIM DOWN BELOW
                if($holdMyLevel >= $key ){
                    unset($appArr[$key]);

                }else{
                    $newLevels[] = $key;    //NEW LEVELS IN THE APPROVAL FORMED
                    $newUsers[] = $var;     //NEW USERS IN THE APPROVAL FORMED
                }
            }
            $nAppLevelsNew = []; $nAppUsersNew = [];
            if(count($appArr) > 0) {    //IF USERS AND THEIR LEVELS IN APPROVAL AFTER REMOVAL/UNSETTING THE ARRAY IS ONE OR MORE
                foreach ($appArr as $key => $val) {
                    $nAppLevelsNew[] = $key;
                    $nAppUsersNew[] = $val;
                }
            }
            $nAppLevels = $nAppLevelsNew; $nAppUsers = $nAppUsersNew;


            $appUsers = json_encode($newUsers); $appLevels = json_encode($newLevels);   //JSON FORMAT OF THE NEW APPROVAL USERS AND LEVELS
        }
        if(count($appArr)>0) {  //FIND THE LEAST LEVEL FOR NEXT APPROVAL IF APPROVAL USERS AND LEVELS ARRAY IS NOT EMPTY
            $firstApprovalLevel = min($nAppLevels); 

            $approvalUser = $appArr[$firstApprovalLevel];
        }else{  //THERE IS NO NEXT APPROVAL USER OR LEVEL
            $approvalUser = '';
        }
        $appArr = json_encode($appArr); //CURRENT STATE OF LIST OF LEVELS AND USERS TO APPROVE AFTER ARRAY UNSET OF THIS ARRAY

    }

    public static function processChangedDeptApproval(&$appArr,&$nAppLevels,&$nAppUsers,&$appUsers,&$appLevels,$newLevels,$newUsers,&$approvalUser,$requestedBy){
        if(in_array($requestedBy,$nAppUsers)){  //CHECK IF USER MAKING REQUISITION IS IN APPROVAL PROCESS

            $holdMyLevel = array_search($requestedBy,$appArr);  //HOLD THE ID OF THE USER THAT MADE A REQUEST
            foreach($appArr as $key => $var){   //LOOP TO REMOVE USER AND ALL LEVEL OF APPROVALS FROM HIM DOWN BELOW
                if($holdMyLevel >= $key ){
                    unset($appArr[$key]);

                }else{
                    $newLevels[] = $key;    //NEW LEVELS IN THE APPROVAL FORMED
                    $newUsers[] = $var;     //NEW USERS IN THE APPROVAL FORMED
                }
            }
            $nAppLevelsNew = []; $nAppUsersNew = [];
            if(count($appArr) > 0) {    //IF USERS AND THEIR LEVELS IN APPROVAL AFTER REMOVAL/UNSETTING THE ARRAY IS ONE OR MORE
                foreach ($appArr as $key => $val) {
                    $nAppLevelsNew[] = $key;
                    $nAppUsersNew[] = $val;
                }
            }
            $nAppLevels = $nAppLevelsNew; $nAppUsers = $nAppUsersNew;


            $appUsers = json_encode($newUsers); $appLevels = json_encode($newLevels);   //JSON FORMAT OF THE NEW APPROVAL USERS AND LEVELS
        }
        if(count($appArr)>0) {  //FIND THE LEAST LEVEL FOR NEXT APPROVAL IF APPROVAL USERS AND LEVELS ARRAY IS NOT EMPTY
            $firstApprovalLevel = min($nAppLevels); 

            $approvalUser = $appArr[$firstApprovalLevel];
        }else{  //THERE IS NO NEXT APPROVAL USER OR LEVEL
            $approvalUser = '';
        }
        $appArr = json_encode($appArr); //CURRENT STATE OF LIST OF LEVELS AND USERS TO APPROVE AFTER ARRAY UNSET OF THIS ARRAY

    }

    public static function approvalCheck($curr_status,&$appUsers,&$appLevels,&$appJson,&$appStatus,&$compStatus,&$nextUser){

        $appLevelKey = array_search(Auth::user()->id,$appJson);
        $appUserKey = array_search(Auth::user()->id,$appUsers);
        $appLevelKey1 = array_search($appLevelKey,$appLevels);
        $appStatus = $curr_status;
        unset($appJson[$appLevelKey]);
        unset($appUsers[$appUserKey]);
        unset($appLevels[$appLevelKey1]);
        if(count($appLevels) > 0) {
            $leastLevel = min($appLevels);
            $nextUser = $appJson[$leastLevel];
        }
        json_encode($appJson);
        json_encode($appUsers);
        json_encode($appLevels);
        if(count($appLevels) <1 && count($appUsers) <1 && count($appJson) <1) {
            $appStatus = Utility::APPROVED;
        }
        $compStatus = (count($appUsers) <1) ? 1 : 0;

    }

    public static function approveAccess($dbData){
        $appButton = 0;
        foreach($dbData as $app){
            $users = json_decode($app->users,TRUE);
            foreach($users as $var){
                if($var == Auth::user()->id){
                    $appButton = 1;
                }
            }
        }
        return $appButton;
    }

    //HANDLES CHANGES MADE TO AN APPROVAL SYSTEM (CHANGES TO STAGES AND USERS)
    public static function actionOnModifyingApprovalSys($approvalTable,$requestTable,$approvalId,$userArr,$stageArr,$userJson,$stageJson,$levelToUserPairJson){
        $approvalSys = DB::table($approvalTable)
            ->where('status', Utility::STATUS_ACTIVE)->where('id', $approvalId)->first();   //FETCH EXISTING APPROVAL TO BE MODIFIED FROM DB

        $currentUserArr = json_decode($approvalSys->users,true);    //CONVERT TO ARRAY
        $currentStageArr = json_decode($approvalSys->levels,true);  //CONVERT TO ARRAY
        sort($userArr); sort($stageArr); sort($currentUserArr); sort($currentStageArr); //SORT TO ALLOW MATCHING OF THE ARRAY
        if($userArr == $currentUserArr && $stageArr == $currentStageArr){

        }else{ //UPDATE ALL APPROVAL SYS IN THE REQUISITION TABLE THAT HAVE NOT BEEN APPROVED OR DENIED
            $requestData = DB::table($requestTable)
                ->where('status', Utility::STATUS_ACTIVE)->where('approval_id', $approvalId)
                ->where('complete_status', Utility::ZERO)->get();   //REQUESTS STILL AWAITING APPROVAL

            if(!empty($requestData)){
               

                foreach($requestData as $data){

                    $approvalArray = $levelToUserPairJson;    //LIST OF APPROVAL USERS AND THERE LEVEL
                    $approvalLevel = $stageArr; //ALL THE LEVELS ARRAY
                    $approvalUsers = $userArr;  //ALL THE USERS ARRAY
                    $approveUsers = $userJson; $approveLevels = $stageJson;   //USERS AND LEVELS ARRAY
                    $holdUser = ''; //ID OF NEXT PERSON TO APPROVE
                    $appLevel = [];
                    $appUser = [];
        
                    self::processChangedDeptApproval($approvalArray,$approvalLevel,$approvalUsers,$approveUsers,$approveLevels,$appLevel,$appUser,$holdUser,$data->request_user);
        

                    $dbData = [
                        'approval_json' => $approvalArray,
                        'approval_level' => $approveLevels,
                        'approval_user' => $approvalUsers,
                        'approved_users' => '',
                    ];

                    Utility::defaultUpdate($requestTable,'id',$data->id,$dbData);

                    //SEND OUT MAIL TO NEXT PERSON IN LINE FOR APPROVAL
                    if($holdUser != '') {
                        $firstUser = User::firstRow('id', $holdUser);   //DETAILS OF NEXT PERSON TO APPROVE
                        $reqUser = User::firstRow('id',$data->request_user);
                        $email = $firstUser->email;
                        $fullName = $firstUser->firstname . ' ' . $firstUser->lastname;
                        $senderName = $reqUser->firstname . ' ' . $reqUser->lastname;
                        $subject = 'A New Fund Request from ' . $senderName;
                        /*$emailContent = [
                            'user_id' => $reqUser,
                            'type' => 'next_approval',
                            'name' => $fullName,
                            'sender_name' => $senderName,
                            'desc' => $request->input('description'),
                            'amount' => $request->input('amount')
                        ];*/
                        $emailContent = new \stdClass();
                        $emailContent->user_id = $data->request_user;
                        $emailContent->type = 'next_approval';
                        $emailContent->name = $fullName;
                        $emailContent->sender_name = $senderName;
                        $emailContent->desc = $data->req_desc;
                        $emailContent->amount = $data->amount;
                        Notify::sendMail('requisition.send_request',$emailContent,$email,$fullName,$subject);
                    }

                }
            }

        }

    }

    //HANDLES CHANGES WHEN A DIFFERENT APPROVAL IS SELECTED FOR A DEPARTMENT/UNIT
    public static function actionOnChangingApprovalSysForDept($deptApprovalTable,$requestTable,$approvalTable,$deptApprovalId,$newApprovalId,$deptId){
        $deptApproval = DB::table($deptApprovalTable)
            ->where('status', Utility::STATUS_ACTIVE)->where('id', $deptApprovalId)->first();   //FETCH EXISTING APPROVAL TO BE MODIFIED FROM DB

        if($deptApproval->approval_id == $newApprovalId){

        }else{ //UPDATE ALL DEPT APPROVAL SYS IN THE REQUISITION TABLE THAT HAVE NOT BEEN APPROVED OR DENIED
            $requestData = DB::table($requestTable)
                ->where('status', Utility::STATUS_ACTIVE)->where('dept_id', $deptId)
                ->where('complete_status', Utility::ZERO)->get();   //REQUESTS STILL AWAITING APPROVAL

            $approveSys = DB::table($approvalTable)
                ->where('status', Utility::STATUS_ACTIVE)->where('id', $newApprovalId)->first(); //NEW SELECTED APPROVAL SYSTEM DATA

            if(!empty($requestData)){
               

                foreach($requestData as $data){

                    $approvalArray = json_decode($approveSys->level_users,TRUE);    //LIST OF APPROVAL USERS AND THERE LEVEL
                    $approvalLevel = json_decode($approveSys->levels,TRUE); //ALL THE LEVELS DECODED
                    $approvalUsers = json_decode($approveSys->users,TRUE);  //ALL THE USERS DECODED
                    $approveUsers = $approveSys->users; $approveLevels = $approveSys->levels;   //USERS AND LEVELS NOT DECODED
                    $holdUser = ''; //ID OF NEXT PERSON TO APPROVE
                    $appLevel = [];
                    $appUser = [];
        
                    self::processChangedDeptApproval($approvalArray,$approvalLevel,$approvalUsers,$approveUsers,$approveLevels,$appLevel,$appUser,$holdUser,$data->request_user);
        
                    $dbData = [
                        'approval_json' => $approvalArray,
                        'approval_level' => $approveLevels,
                        'approval_user' => $approveUsers,
                        'approved_users' => '',
                    ];

                    Utility::defaultUpdate($requestTable,'id',$data->id,$dbData);

                    //SEND OUT MAIL TO NEXT PERSON IN LINE FOR APPROVAL
                    if($holdUser != '') {
                        $firstUser = User::firstRow('id', $holdUser);   //DETAILS OF NEXT PERSON TO APPROVE
                        $reqUser = User::firstRow('id',$data->request_user);
                        $email = $firstUser->email;
                        $fullName = $firstUser->firstname . ' ' . $firstUser->lastname;
                        $senderName = $reqUser->firstname . ' ' . $reqUser->lastname;
                        $subject = 'A New Fund Request from ' . $senderName;
                        /*$emailContent = [
                            'user_id' => $reqUser,
                            'type' => 'next_approval',
                            'name' => $fullName,
                            'sender_name' => $senderName,
                            'desc' => $request->input('description'),
                            'amount' => $request->input('amount')
                        ];*/
                        $emailContent = new \stdClass();
                        $emailContent->user_id = $data->request_user;
                        $emailContent->type = 'next_approval';
                        $emailContent->name = $fullName;
                        $emailContent->sender_name = $senderName;
                        $emailContent->desc = $data->req_desc;
                        $emailContent->amount = $data->amount;
                        Notify::sendMail('requisition.send_request',$emailContent,$email,$fullName,$subject);
                    }

                }
            }

        }

    }

}