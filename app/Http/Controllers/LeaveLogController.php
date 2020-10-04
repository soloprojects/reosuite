<?php

namespace App\Http\Controllers;

use App\model\LeaveLog;
use App\model\LeaveType;
use App\model\Department;
use App\model\HrisApprovalSys;
use App\model\LeaveApproval;
use App\Helpers\Utility;
use App\Helpers\Notify;
use App\Helpers\Approve;
use App\User;
use Auth;
use Monolog\Handler\Curl\Util;
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

class LeaveLogController extends Controller
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
        $approveSys = HrisApprovalSys::getAllData();
        $approveAccess = Approve::approveAccess($approveSys);
        $mainData = LeaveLog::specialColumnsPage('request_user',Auth::user()->id);
        $this->filterData($mainData);
        $leaveType = LeaveType::getAllData();
        $leaveStatus = $this->leaveDaysStatus();

        if ($request->ajax()) {
            return \Response::json(view::make('leave_log.reload',array('mainData' => $mainData,
                'leaveType' => $leaveType, 'appAccess' => $approveAccess))->render());

        }else{
            return view::make('leave_log.main_view')->with('mainData',$mainData)->with('leaveType',$leaveType)
                ->with('appAccess',$approveAccess)->with('leaveStatus',$leaveStatus);
        }

    }

    public function myLeaveStatus(Request $request)
    {
        //
        //$req = new Request();

        $mainData = $this->leaveDaysStatus();

            return view::make('leave_log.leave_status')->with('mainData',$mainData);

    }

    public function leaveHistory(Request $request)
    {
        //
        //$req = new Request();
        $approveSys = HrisApprovalSys::getAllData();
        $approveAccess = Approve::approveAccess($approveSys);
        $mainData = LeaveLog::paginateAllData();
        $this->filterData($mainData);
        $leaveType = LeaveType::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('leave_log.leave_history_reload',array('mainData' => $mainData,
                'leaveType' => $leaveType, 'appAccess' => $approveAccess))->render());

        }else{
            return view::make('leave_log.leave_history')->with('mainData',$mainData)->with('leaveType',$leaveType)
                ->with('appAccess',$approveAccess);
        }

    }

    public function myRequests(Request $request)
    {
        //
        //$req = new Request();
        $approveSys = HrisApprovalSys::getAllData();
        $approveAccess = Approve::approveAccess($approveSys);
        $mainData = LeaveLog::paginateAllData();
        $this->filterData($mainData);
        $leaveType = LeaveType::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('leave_log.request_reload',array('mainData' => $mainData,
                'leaveType' => $leaveType, 'appAccess' => $approveAccess))->render());

        }else{
            return view::make('leave_log.request')->with('mainData',$mainData)->with('leaveType',$leaveType)
                ->with('appAccess',$approveAccess);
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
        $validator = Validator::make($request->all(),LeaveLog::$mainRules);
        if($validator->passes()) {
            $startDate = strtotime($request->input('start_date'));
            $endDate = strtotime($request->input('end_date'));
            $year = date("Y",$startDate);
            $numOfDays = Utility::getDaysLength($request->input('start_date'), $request->input('end_date'));

            if ($startDate <= $endDate) {
                if(Utility::LeaveDaysValidator($request->input('leave_type'),$numOfDays) == true) {

                    $files = $request->file('attachment');
                    //return $files;
                    $attachment = [];
                    //print_r($files);

                    if ($files != '') {
                        foreach ($files as $file) {
                            //return$file;
                            $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();
                            $real_images[] = $file_name;
                            $file->move(
                                Utility::FILE_URL(), $file_name
                            );
                            //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                            //array_push($cdn_images,$file_name);
                            $attachment[] = $file_name;

                        }
                    }

                    $attachJson = json_encode($attachment);
                    $userInput = $request->input('user');
                    $user = User::firstRow('id', $request->input('user'));
                    $reqUser = ($request->input('user') == null) ? Auth::user()->id : $user->id;
                    $reqDept = ($request->input('user') == null) ? Auth::user()->dept_id : $user->dept_id;

                    $approveDept = LeaveApproval::firstRow('dept', $reqDept);
                    $approveSys = HrisApprovalSys::firstRow('id', $approveDept->approval_id);
                    $approvalArray = json_decode($approveSys->level_users, TRUE);
                    $approvalLevel = json_decode($approveSys->levels, TRUE);
                    $approvalUsers = json_decode($approveSys->users, TRUE);
                    $approveUsers = $approveSys->users;
                    $approveLevels = $approveSys->levels;
                    $holdUser = '';
                    $appLevel = [];
                    $appUser = [];

                    Approve::processApproval($approvalArray, $approvalLevel, $approvalUsers, $approveUsers, $approveLevels, $appLevel, $appUser, $holdUser);
                    /*return response()->json([
                                    'message' => 'good',
                                    'message2' => json_encode($approvalUsers)
                                ]);*/
                    if ($holdUser != '') {
                        $firstUser = User::firstRow('id', $holdUser);
                        $email = $firstUser->email;
                        $fullName = $firstUser->firstname . ' ' . $firstUser->lastname;
                        $senderName = ($userInput == null) ? Auth::user()->firstname . ' ' . Auth::user()->lastname : $user->firstname . ' ' . $user->lastname;
                        $subject = 'A New leave Request from ' . $senderName;
                        /*$emailContent = [
                            'user_id' => $reqUser,
                            'type' => 'next_approval',
                            'name' => $fullName,
                            'sender_name' => $senderName,
                            'desc' => $request->input('description'),
                            'amount' => $request->input('amount')
                        ];*/
                        $emailContent = new \stdClass();
                        $emailContent->user_id = $reqUser;
                        $emailContent->type = 'next_approval';
                        $emailContent->name = $fullName;
                        $emailContent->sender_name = $senderName;
                        $emailContent->desc = $request->input('leave_description');
                        $emailContent->amount = $request->input('amount');
                        Notify::leaveRequestMail('leave_log.send_request', $emailContent, $email, $fullName, $subject);
                    }

                    $user = User::firstRow('id', $reqUser);
                    $dept_id = ($userInput == null) ? Auth::user()->dept_id : $user->dept_id;
                    $reqStatus = ($holdUser == '') ? Utility::APPROVED : Utility::PROCESSING;

                    $dbDATA = [
                        'duration' => Utility::getDaysLength($request->input('start_date'), $request->input('end_date')),
                        'start_date' => date('Y,m,d,H:i:s', $startDate),
                        'leave_type' => $request->input('leave_type'),
                        'end_date' => date('Y,m,d,H:i:s', $endDate),
                        'year' => $year,
                        'leave_desc' => $request->input('leave_description'),
                        'dept_id' => $dept_id,
                        'approval_json' => $approvalArray,
                        'approval_level' => $approveLevels,
                        'approval_user' => $approveUsers,
                        'approval_id' => $approveSys->id,
                        'approval_status' => $reqStatus,
                        'complete_status' => $reqStatus,
                        'request_user' => $reqUser,
                        'dept_req_user' => $dept_id,
                        'attachment' => $attachJson,
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];
                    $requisition = LeaveLog::create($dbDATA);


                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);

                }else{
                    return  response()->json([
                        'message2' => 'You have '.Utility::extraLeaveDays($request->input('leave_type')).' days remaining for this leave type',
                        'message' => 'warning'
                    ]);
                }

            }else{

                return  response()->json([
                    'message2' => 'Please ensure that the end date is greater than the start date',
                    'message' => 'warning'
                ]);

            }

        }

        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }


    public function editUserLeave(Request $request)
    {
        //
        $validator = Validator::make($request->all(), LeaveLog::$hrRules);
        if ($validator->passes()) {
            $startDate = strtotime($request->input('start_date'));
            $endDate = strtotime($request->input('end_date'));
            $year = date("Y",$startDate);
            $numOfDays = Utility::getDaysLength($request->input('start_date'), $request->input('end_date'));

            if ($startDate <= $endDate) {
                if(Utility::LeaveDaysValidator($request->input('leave_type'),$numOfDays) == true) {

                    $dbDATA = [
                        'start_date' => date('Y,m,d,H:i:s', $startDate),
                        'end_date' => date('Y,m,d,H:i:s', $endDate),
                        'duration' => Utility::getDaysLength($request->input('start_date'), $request->input('end_date')),
                        'year' => $year,
                        'updated_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];
                    LeaveLog::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);

                }else{
                    return  response()->json([
                        'message2' => 'User have '.Utility::extraLeaveDays($request->input('leave_type')).' days remaining for this leave type',
                        'message' => 'warning'
                    ]);
                }

            }else{
                return  response()->json([
                    'message2' => 'Please ensure that the end date is greater than the start date',
                    'message' => 'Warning'
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
        $request = LeaveLog::firstRow('id',$request->input('dataId'));
        $leaveType = LeaveType::getAllData();
        return view::make('leave_log.edit_form')->with('edit',$request)->with('leaveType',$leaveType);

    }

    public function editUserLeaveForm(Request $request)
    {
        //
        $request = LeaveLog::firstRow('id',$request->input('dataId'));
        $leaveType = LeaveType::getAllData();
        return view::make('leave_log.edit_user_leave_form')->with('edit',$request)->with('leaveType',$leaveType);

    }

    public function attachmentForm(Request $request)
    {
        //
        $request = LeaveLog::firstRow('id',$request->input('dataId'));
        return view::make('leave_log.attach_form')->with('edit',$request);

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
        $validator = Validator::make($request->all(),LeaveLog::$mainRules);
        if($validator->passes()) {
            $startDate = strtotime($request->input('start_date'));
            $endDate = strtotime($request->input('end_date'));
            $year = date("Y",$startDate);
            $numOfDays = Utility::getDaysLength($request->input('start_date'), $request->input('end_date'));

            if ($startDate <= $endDate) {
                if(Utility::LeaveDaysValidator($request->input('leave_type'),$numOfDays) == true) {
                    $previousArray = [];
                    $previousData = LeaveLog::firstRow('id', $request->input('edit_id'));
                    $approvalSys = HrisApprovalSys::firstRow('id', $previousData->approval_id);

                    $dbDATA = [
                        'start_date' => date('Y,m,d,H:i:s', $startDate),
                        'leave_type' => $request->input('leave_type'),
                        'end_date' => date('Y,m,d,H:i:s', $endDate),
                        'year' => $year,
                        'duration' => Utility::getDaysLength($request->input('start_date'), $request->input('end_date')),
                        'leave_desc' => $request->input('leave_description'),
                        'updated_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];

                    $previousEntry = '';
                    if ($previousData->approved_users != '') {

                        if ($previousData->deny_user != 0) {

                            return response()->json([
                                'message' => 'good',
                                'message2' => 'Request has been denied and can\'t be edited'
                            ]);

                        } else {

                            $previousArray['leave_type'] = $previousData->leaveType->leave_type;
                            $previousArray['start_date'] = $previousData->start_date;

                            $previousArray['end_date'] = $previousData->end_date;

                            $previousArray['leave_desc'] = $previousData->leave_desc;
                            $previousArray['duration'] = $previousData->duration . ' days';

                            $previousEntry = json_encode($previousArray);

                            $approvalArray = json_decode($approvalSys->level_users, TRUE);
                            $approvalLevel = json_decode($approvalSys->levels, TRUE);
                            $approvalUsers = json_decode($approvalSys->users, TRUE);
                            $approveUsers = $approvalSys->users;
                            $approveLevels = $approvalSys->levels;
                            $appLevel = [];
                            $appUser = [];
                            $holdUser = '';

                            Approve::processApproval($approvalArray, $approvalLevel, $approvalUsers, $approveUsers, $approveLevels, $appLevel, $appUser, $holdUser);
                            $reqStatus = ($holdUser == '') ? Utility::APPROVED : Utility::PROCESSING;
                            $dbDATA = [
                                'start_date' => date('Y,m,d,H:i:s', $startDate),
                                'leave_type' => $request->input('leave_type'),
                                'end_date' => date('Y,m,d,H:i:s', $endDate),
                                'duration' => Utility::getDaysLength($request->input('start_date'), $request->input('end_date')),
                                'year' => $year,
                                'leave_desc' => $request->input('leave_description'),
                                'edit_request' => $previousEntry,
                                'approved_users' => '',
                                'approval_json' => $approvalArray,
                                'approval_level' => $approveLevels,
                                'approval_user' => $approveUsers,
                                'approval_status' => $reqStatus,
                                'views' => '',
                                'complete_status' => $reqStatus,
                                'updated_by' => Auth::user()->id,
                                'status' => Utility::STATUS_ACTIVE
                            ];

                            if ($holdUser != '') {
                                $reqUser = $previousData->request_user;
                                $user = User::firstRow('id', $reqUser);
                                $firstUser = User::firstRow('id', $holdUser);
                                $email = $firstUser->email;
                                $fullName = $previousData->requestUser->firstname . ' ' . $previousData->requestUser->lastname;
                                $senderName = $user->firstname . ' ' . $user->lastname;
                                $subject = 'A New leave Request from ' . $senderName;
                                /*$emailContent = [
                                    'user_id' => $previousData->request_user,
                                    'type' => 'next_approval',
                                    'name' => $fullName,
                                    'sender_name' => $senderName,
                                    'desc' => $request->input('description'),
                                    'amount' => $request->input('amount')
                                ];*/
                                $emailContent = new \stdClass();
                                $emailContent->user_id = $previousData->request_user;
                                $emailContent->type = 'next_approval';
                                $emailContent->name = $fullName;
                                $emailContent->sender_name = $senderName;
                                $emailContent->desc = $request->input('leave_description');
                                $emailContent->amount = $request->input('duration');


                                Notify::leaveRequestMail('leave_log.send_request', $emailContent, $email, $fullName, $subject);
                            }
                        }   //END OF CHECK FOR IF DENIED

                    } //END OF CHECK FOR REQUEST APPROVAL


                    LeaveLog::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);

                }else{
                    return  response()->json([
                        'message2' => 'You have '.Utility::extraLeaveDays($request->input('leave_type')).' days remaining for this leave type',
                        'message' => 'warning'
                    ]);
                }

            }else{
                return  response()->json([
                    'message2' => 'warning',
                    'message' => 'Please ensure that the end date is greater than the start date'
                ]);
            }
        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    public function editAttachment(Request $request){
        $files = $request->file('attachment');
        //return $files;
        $attachment = [];
        $editId = $request->input('edit_id');
        $oldData = LeaveLog::firstRow('id',$editId);
        $oldAttachment = json_decode($oldData->attachment);

        if($files != ''){
            foreach($files as $file){
                //return$file;
                $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                $file->move(
                    Utility::FILE_URL(), $file_name
                );
                //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                array_push($oldAttachment,$file_name);

            }
        }

        $attachJson = json_encode($oldAttachment);
        $dbData = [
            'attachment' => $attachJson
        ];
        $save = LeaveLog::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message' => 'good',
            'message2' => 'saved'
        ]);

    }

    public function removeAttachment(Request $request){
        $file_name = $request->input('attachment');
        //return $files;
        $attachment = [];
        $editId = $request->input('edit_id');
        $oldData = LeaveLog::firstRow('id',$editId);
        $oldAttachment = json_decode($oldData->attachment,true);


        //REMOVE FILES FROM AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
        if (($key = array_search($file_name, $oldAttachment)) !== false) {
            $fileUrl = Utility::FILE_URL($file_name);
            unset($oldAttachment[$key]);
            unlink($fileUrl);
        }


        $attachJson = json_encode($oldAttachment);
        $dbData = [
            'attachment' => $attachJson
        ];
        $save = LeaveLog::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message' => 'good',
            'message2' => 'File have been removed'
        ]);

    }

    public function downloadAttachment(){
        $file = $_GET['file'];
        $download = Utility::FILE_URL($file);
        return response()->download($download);
        //return $file;
    }

    /**
     * Approve the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approval(Request $request)
    {
        //

        $dbData = [];

        $in_use = [];
        $unused = [];
        $idArray = json_decode($request->input('all_data'));


        for($i=0;$i<count($idArray);$i++){
            $rowDataRequest = LeaveLog::firstRow('id', $idArray[$i]);
            if($rowDataRequest->complete_status == 1 || $rowDataRequest->deny_reason !=''){
                $unused[$i] = $idArray[$i];
            }else{
                $in_use[$i] = $idArray[$i];
            }
        }

        $message = (count($unused) > 0) ? ' and '.count($unused).
            ' has been approved/denied and cannot be changed' : '';
        if(count($in_use) > 0){

            if($request->input('status') == 1){
                foreach($in_use as $reqId){
                    $proRequisition = LeaveLog::firstRow('id', $reqId);
                    $approvalUsers = json_decode($proRequisition->approval_user,true);
                    $approvalLevels = json_decode($proRequisition->approval_level,true);
                    $approvalJson = json_decode($proRequisition->approval_json,true);
                    $nextUser = '';
                    $appStatus = '';
                    $compStatus = '';
                    Approve::approvalCheck($proRequisition->approval_status,$approvalUsers,$approvalLevels,$approvalJson,$appStatus,$compStatus,$nextUser);
                    $approvedUsers = ($proRequisition->approved_users == '') ? [] : json_decode($proRequisition->approved_users,true);
                    $approvedUsers[] = Auth::user()->id;
                    $appUsersJson = json_encode($approvedUsers);
                    $dbData = [
                        'approval_status' => $appStatus,
                        'approval_user' => json_encode($approvalUsers),
                        'approved_users' => $appUsersJson,
                        'approval_level' => json_encode($approvalLevels),
                        'approval_json' => json_encode($approvalJson),
                        'complete_status' => $compStatus
                    ];

                    $update = LeaveLog::defaultUpdate('id',$reqId,$dbData);

                    $mailContentApproved = new \stdClass();
                    $mailContentApproved->type = 'request_approved';
                    $mailContentApproved->desc = $proRequisition->req_desc;
                    $mailContentApproved->amount = $proRequisition->amount;
                    $mailContentApproved->sender = $proRequisition->requestUser->firstname . ' ' . $proRequisition->requestUser->lastname;

                    if(count($approvalLevels) > 0) {
                        $firstUser = User::firstRow('id', $nextUser);
                        $email = $firstUser->email;
                        $fullName = $firstUser->firstname . ' ' . $firstUser->lastname;
                        $senderName = $proRequisition->requestUser->firstname . ' ' . $proRequisition->requestUser->lastname;
                        $subject = 'A New leave Request from ' . $senderName;
                        /*$emailContent = [
                            'type' => 'next_approval',
                            'name' => $fullName,
                            'user_id' => $proRequisition->request_user,
                            'sender' => $senderName,
                            'desc' => $proRequisition->req_desc,
                            'amount' => $proRequisition->amount
                        ];*/
                        $emailContent = new \stdClass();
                        $emailContent->type = 'next_approval';
                        $emailContent->name = $fullName;
                        $emailContent->user_id = $proRequisition->request_user;
                        $emailContent->sender = $senderName;
                        $emailContent->desc = $proRequisition->req_desc;
                        $emailContent->amount = $proRequisition->amount;

                        /*$mailContentApproved = [
                            'type' => 'request_approved',
                            'desc' => $proRequisition->req_desc,
                            'amount' => $proRequisition->amount,
                            'sender' => $proRequisition->requestUser->firstname . ' ' . $proRequisition->requestUser->lastname
                        ];*/

                        if($update){
                            Notify::leaveRequestMail('leave_log.send_request', $emailContent, $email, $fullName, $subject);
                        }

                    }


                    if($compStatus == 1){
                        Notify::leaveRequestMail('leave_log.send_request', $mailContentApproved, $proRequisition->requestUser->email, $proRequisition->requestUser->firstname, 'Request Approval');
                        if($proRequisition->request_user != $proRequisition->created_by) {  //IF REQUEST WAS MADE FOR ANOTHER USER NOTIFY WHO MADE THE REQUEST
                            Notify::leaveRequestMail('leave_log.send_request', $mailContentApproved, $proRequisition->user_c->email, $proRequisition->user_c->firstname, 'Request Approval');
                        }

                        $accountants = User::specialColumns('role',Utility::HR);
                        if(count($accountants) >0){ //SEND MAIL TO ALL IN HR DEPARTMENT ABOUT THIS APPROVAL
                            foreach($accountants as $data) {
                                Notify::leaveRequestMail('leave_log.send_request', $mailContentApproved, $data->email, $proRequisition->requestUser->firstname, 'Request Approval');
                            }
                        }

                    }   //END OF WHEN STATUS IS COMPLETE

                }   //END OF LOOP FOR APPROVING PROCESS


                return response()->json([
                    'message2' => 'deleted',
                    'message' => count($in_use).' request(s) has been approved '.$message
                ]);

            }else{  //DENY USER CODES BEGINS HERE

                $denyReason = $request->input('input_text');

                foreach($in_use as $reqId) {
                    $proRequisition = LeaveLog::firstRow('id', $reqId);
                    $dbData = [
                        'deny_user' => Auth::user()->id,
                        'deny_reason' => $denyReason,
                        'approval_status' => Utility::DENIED,
                        'complete_status' => Utility::COMPLETED,
                    ];
                    /*$mailContentDenied = [
                        'type' => 'request_denied',
                        'desc' => $proRequisition->req_desc,
                        'amount' => $proRequisition->amount
                    ];*/
                    $mailContentDenied = new \stdClass();
                    $mailContentDenied->type = 'request_denied';
                    $mailContentDenied->desc = $proRequisition->req_desc;
                    $mailContentDenied->amount = $proRequisition->amount;

                    $update = LeaveLog::defaultUpdate('id',$reqId,$dbData);

                    if($update) {
                        Notify::leaveRequestMail('leave_log.send_request', $mailContentDenied, $proRequisition->requestUser->email, $proRequisition->requestUser->firstname, 'Request Denied');
                        if ($proRequisition->request_user != $proRequisition->created_by) { //IF REQUEST WAS MADE FOR ANOTHER USER NOTIFY WHO MADE THE REQUEST
                            Notify::leaveRequestMail('leave_log.send_request', $mailContentDenied, $proRequisition->user_c->email, $proRequisition->user_c->firstname, 'Request Denied');
                        }
                    }
                }

                return  response()->json([
                    'message2' => 'The '.count($unused).' requests has been denied and status cannot be changed',
                    'message' => 'good'
                ]);

            }   //END OF DENY CODES

        }else{
            return  response()->json([
                'message2' => 'warning',
                'message' => 'The '.count($unused).' requests has been approved/denied and status cannot be changed'
            ]);

        }



        //END FOR NORMAL USER DELETE

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

        if (in_array(Auth::user()->role,Utility::TOP_USERS) ) {

            $delete = LeaveLog::massUpdate('id', $idArray, $dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => 'Data deleted successfully'
            ]);

        }else{  //END OF REMOVAL FOR THE TOP USERS

            $in_use = [];
            $unused = [];
            for($i=0;$i<count($idArray);$i++){
                $rowDataRequest = LeaveLog::firstRow('id', $idArray[$i]);
                if($rowDataRequest->complete_status == 1 || $rowDataRequest->deny_reason !=''){
                    $unused[$i] = $idArray[$i];
                }else{
                    $in_use[$i] = $idArray[$i];
                }
            }
            $message = (count($unused) > 0) ? ' and '.count($unused).
                ' has been approved/denied and cannot be deleted' : '';
            if(count($in_use) > 0){
                $delete = LeaveLog::massUpdate('id',$in_use,$dbData);

                return response()->json([
                    'message2' => 'deleted',
                    'message' => count($in_use).' data(s) has been deleted '.$message
                ]);

            }else{
                return  response()->json([
                    'message2' => 'The '.count($unused).' has been approved/denied and cannot be deleted',
                    'message' => 'warning'
                ]);

            }



        }   //END FOR NORMAL USER DELETE

    }

    public function filterData($dbData){
        foreach($dbData as $data) {
            if ($data->approved_users != '') {
                $jsonUsers = json_decode($data->approved_users,true);
                if (count($jsonUsers) > 0) {
                    $data->approved_by = User::massData('id', $jsonUsers);
                }
            }

            if ($data->complete_status != 1){
                $jsonLevels = json_decode($data->approval_level, true);
                $jsonApp = json_decode($data->approval_json, true);
                $leastLevel = min($jsonLevels);
                $nextUser = $jsonApp[$leastLevel];
                $data->next_user = $nextUser.Auth::user()->id;
                if ($nextUser == Auth::user()->id) {
                    $data->approval_view = 1;
                } else {
                    $data->approval_view = 0;
                }
            }

        }
        return $dbData;
    }   //END OF FILTERING DATA

    public function leaveDaysStatus()
    {
        $year = date('Y');
        $leaveType = LeaveType::getAllData();

        foreach($leaveType as $type){

            $daysTaken = DB::table('leave_log')
                ->where('status', Utility::STATUS_ACTIVE)
                ->where('leave_type', $type->id)
                ->where('request_user', Auth::user()->id)
                ->where('deny_reason', '')
                ->where('approval_status', Utility::APPROVED)
                ->where('year', $year)->sum('duration');

            $daysRemaining = $type->days - $daysTaken;
            $displayRemaining = ($daysRemaining == '') ? $type->days : $daysRemaining;
            $type->daysRemaining = $displayRemaining;

        }


        return $leaveType;
    }


}
