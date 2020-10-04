<?php

namespace App\Http\Controllers;

use App\model\RequestAccess;
use App\model\RequestType;
use App\model\AdminRequisition;
use App\model\AdminCategory;
use App\model\ProjectTeam;
use App\model\Project;
use App\model\Department;
use App\model\AdminApprovalSys;
use App\model\AdminApprovalDept;
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

class AdminRequestController extends Controller
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
        $appButton = '';
        $appUsers = [];
        $approveSys = AdminApprovalSys::getAllData();
        $approveAccess = Approve::approveAccess($approveSys);
        $mainData = AdminRequisition::specialColumnsPageOr2('request_user',Auth::user()->id,'created_by',Auth::user()->id);
        $this->filterData($mainData);
        $reqCat = AdminCategory::paginateAllData();
        $requestType = RequestType::getAllData();
        $project = ProjectTeam::specialColumns('user_id',Auth::user()->id);

        $requestAccess = RequestAccess::getAllData();
        $access = Utility::detectRequestAccess($requestAccess);


        if ($request->ajax()) {
            return \Response::json(view::make('admin_requisition.reload',array('mainData' => $mainData,
                'reqType' => $requestType,'project' => $project, 'reqCat' => $reqCat, 'appAccess' => $approveAccess,
                'access' => $access))->render());

        }else{
            return view::make('admin_requisition.main_view')->with('mainData',$mainData)->with('reqType',$requestType)
                ->with('project',$project)->with('reqCat',$reqCat)->with('appAccess',$approveAccess)
                ->with('access',$access);
        }

    }

    public function myRequests(Request $request)
    {
        //
        //$req = new Request();
        $approveSys = AdminApprovalSys::getAllData();
        $approveAccess = Approve::approveAccess($approveSys);
        $mainData = AdminRequisition::paginateAllData();
        $this->filterData($mainData);
        $reqCat = AdminCategory::getAllData();
        $requestType = RequestType::getAllData();
        $project = ProjectTeam::specialColumns('user_id',Auth::user()->id);

        if ($request->ajax()) {
            return \Response::json(view::make('admin_requisition.request_reload',array('mainData' => $mainData,
                'reqType' => $requestType,'project' => $project, 'reqCat' => $reqCat, 'appAccess' => $approveAccess,
                ))->render());

        }else{
            return view::make('admin_requisition.request')->with('mainData',$mainData)->with('reqType',$requestType)
                ->with('project',$project)->with('reqCat',$reqCat)->with('appAccess',$approveAccess);
        }

    }

    public function approvedRequests(Request $request)
    {
        //
        //$req = new Request();
        $approveSys = AdminApprovalSys::getAllData();
        $approveAccess = Approve::approveAccess($approveSys);
        $mainData = (in_array(Auth::user()->role,\App\Helpers\Utility::ACCOUNT_MANAGEMENT)) ? AdminRequisition::paginateAllData() : AdminRequisition::specialColumnsPageOr2('request_user',Auth::user()->id,'created_by',Auth::user()->id);

        $this->filterData($mainData);
        $reqCat = AdminCategory::getAllData();
        $requestType = RequestType::getAllData();
        $project = ProjectTeam::specialColumns('user_id',Auth::user()->id);
        $dept = Department::getAllData();

        $detectHod = Utility::detectHOD(Auth::user()->id);
        $requestAccess = RequestAccess::getAllData();
        $access = Utility::detectRequestAccess($requestAccess);

        if ($request->ajax()) {
            return \Response::json(view::make('admin_requisition.approved_requests_reload',array('mainData' => $mainData,
                'reqType' => $requestType,'project' => $project, 'reqCat' => $reqCat, 'appAccess' => $approveAccess,
                'access' => $access,'dept'=>$dept,'detectHod'=>$detectHod))->render());

        }else{
            return view::make('admin_requisition.approved_requests')->with('mainData',$mainData)->with('reqType',$requestType)
                ->with('project',$project)->with('reqCat',$reqCat)->with('appAccess',$approveAccess)
                ->with('access',$access)->with('dept',$dept)
                ->with('detectHod',$detectHod);
        }

    }

    public function chartApprovedRequests(Request $request)
    {
        //
        //$req = new Request();
        $approveSys = AdminApprovalSys::getAllData();
        $approveAccess = Approve::approveAccess($approveSys);
        $mainData = (in_array(Auth::user()->role,\App\Helpers\Utility::ACCOUNT_MANAGEMENT)) ? AdminRequisition::paginateAllData() : AdminRequisition::specialColumnsPageOr2('request_user',Auth::user()->id,'created_by',Auth::user()->id);

        $this->filterData($mainData);
        $reqCat = AdminCategory::getAllData();
        $requestType = RequestType::getAllData();
        $project = ProjectTeam::specialColumns('user_id',Auth::user()->id);
        $dept = Department::getAllData();

        $detectHod = Utility::detectHOD(Auth::user()->id);
        $requestAccess = RequestAccess::getAllData();
        $access = Utility::detectRequestAccess($requestAccess);

        if ($request->ajax()) {
            return \Response::json(view::make('admin_requisition.approved_requests_reload',array('mainData' => $mainData,
                'reqType' => $requestType,'project' => $project, 'reqCat' => $reqCat, 'appAccess' => $approveAccess,
                'access' => $access,'dept'=>$dept,'detectHod'=>$detectHod))->render());

        }else{
            return view::make('admin_requisition.chart_approved_requests')->with('mainData',$mainData)->with('reqType',$requestType)
                ->with('project',$project)->with('reqCat',$reqCat)->with('appAccess',$approveAccess)
                ->with('access',$access)->with('dept',$dept)
                ->with('detectHod',$detectHod);
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
        $validator = Validator::make($request->all(),AdminRequisition::$mainRules);
        if($validator->passes()){

            $files = $request->file('attachment');
            //return $files;
            $attachment = [];

            if($files != ''){
                foreach($files as $file){
                    //return$file;
                    $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();
                    $real_images[] = $file_name;
                    $file->move(
                        Utility::FILE_URL(), $file_name
                    );
                    //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                    //array_push($cdn_images,$file_name);
                    $attachment[] =  $file_name;

                }
            }

            $attachJson = json_encode($attachment);
            $userInput = $request->input('user');
            $user = User::firstRow('id',$request->input('user'));
            $reqUser = ($request->input('user') == null) ? Auth::user()->id : $user->id ;
            $reqDept = ($request->input('user') == null) ? Auth::user()->dept_id : $user->dept_id ;

            $approveDept = AdminApprovalDept::firstRow('dept',$reqDept);
            if(empty($approveDept)){
                return response()->json([
                    'message' => 'warning',
                    'message2' => 'There is no approval system assigned to your department, contact admin for help'
                ]);
            }

            $approveSys = AdminApprovalSys::firstRow('id',$approveDept->approval_id);
            $project = $request->input('project');
            $approvalArray = json_decode($approveSys->level_users,TRUE);
            $approvalLevel = json_decode($approveSys->levels,TRUE);
            $approvalUsers = json_decode($approveSys->users,TRUE);
            $approveUsers = $approveSys->users; $approveLevels = $approveSys->levels;
            $holdUser = '';
            $appLevel = [];
            $appUser = [];

            Approve::processApproval($approvalArray,$approvalLevel,$approvalUsers,$approveUsers,$approveLevels,$appLevel,$appUser,$holdUser);

            if($holdUser != '') {
                $firstUser = User::firstRow('id', $holdUser);
                $email = $firstUser->email;
                $fullName = $firstUser->firstname . ' ' . $firstUser->lastname;
                $senderName = ($userInput == null) ? Auth::user()->firstname . ' ' . Auth::user()->lastname : $user->firstname . ' ' . $user->lastname;
                $subject = 'A New Request from ' . $senderName;
                /*$emailContent = [
                    'user_id' => $reqUser,
                    'type' => 'next_approval',
                    'name' => $fullName,
                    'sender_name' => $senderName,
                    'desc' => $request->input('description'),
                ];*/
                $emailContent = new \stdClass();
                $emailContent->user_id = $reqUser;
                $emailContent->type = 'next_approval';
                $emailContent->name = $fullName;
                $emailContent->sender_name = $senderName;
                $emailContent->desc = $request->input('description');
                Notify::AdminMail('admin_requisition.send_request',$emailContent,$email,$fullName,$subject);
            }

            if($request->input('request_type') == Utility::USUAL_REQUEST_TYPE ){
                $project = 0;
            }
            $user = User::firstRow('id',$reqUser);
            $dept_id = ($userInput == null) ? Auth::user()->dept_id : $user->dept_id;
            $reqStatus = ($holdUser == '') ? Utility::APPROVED : Utility::PROCESSING;

            $dbDATA = [
                'req_cat' => $request->input('request_category'),
                'req_type' => $request->input('request_type'),
                'proj_id' => $project,
                'req_desc' => $request->input('request_description'),
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
            $requisition = AdminRequisition::create($dbDATA);


            return response()->json([
                'message' => 'good',
                'message2' => 'saved'
            ]);


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
        $request = AdminRequisition::firstRow('id',$request->input('dataId'));
        $reqCat = AdminCategory::getAllData();
        $requestType = RequestType::getAllData();
        $project = ProjectTeam::specialColumns('user_id',Auth::user()->id);
        return view::make('admin_requisition.edit_form')->with('edit',$request)->with('reqType',$requestType)
            ->with('reqCat',$reqCat)->with('project',$project);

    }

    public function printPreview(Request $request)
    {
        //
        $request = AdminRequisition::firstRow('id',$request->input('dataId'));
        $this->filterItemData($request);
        return view::make('admin_requisition.print_preview')->with('data',$request);

    }

    public function createFeedback(Request $request)
    {
        //
        $validator = Validator::make($request->all(),AdminRequisition::$feedbackMainRules);
        if($validator->passes()){


            $dbData = [
                    'feedback' => ucfirst($request->input('feedback')),
                    'updated_by' => Auth::user()->id,
                ];
            AdminRequisition::defaultUpdate('id',$request->input('request_id'),$dbData);

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    public function attachmentForm(Request $request)
    {
        //
        $request = AdminRequisition::firstRow('id',$request->input('dataId'));
        $reqCat = AdminCategory::getAllData();
        $requestType = RequestType::getAllData();
        $project = ProjectTeam::specialColumns('user_id',Auth::user()->id);
        return view::make('admin_requisition.attach_form')->with('edit',$request)->with('reqType',$requestType)
            ->with('reqCat',$reqCat)->with('project',$project);

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
        $validator = Validator::make($request->all(),AdminRequisition::$mainRules);
        if($validator->passes()) {

            $project = $request->input('project');
            if($request->input('request_type') == Utility::USUAL_REQUEST_TYPE ){
                $project = 0;
            }

            $previousArray = [];
            $previousData = AdminRequisition::firstRow('id',$request->input('edit_id'));
            $approvalSys = AdminApprovalSys::firstRow('id',$previousData->approval_id);

            $dbDATA = [
                'req_cat' => $request->input('request_category'),
                'req_type' => $request->input('request_type'),
                'proj_id' => $project,
                'req_desc' => $request->input('request_description'),
                'updated_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];

            $previousEntry = '';
            if($previousData->approved_users != '') {

                if ($previousData->deny_user != 0) {

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'Request has been denied and can\'t be edited'
                    ]);

                } else {

                        $previousArray['request_type'] = $previousData->requestType->request_type;
                        $previousArray['request_category'] = $previousData->requestCat->request_name;
                        if ($previousData->proj_id != 0) {
                            $previousArray['project'] = $previousData->project->project_name;
                        }
                        $previousArray['request_desc'] = $previousData->req_desc;

                        $previousEntry = json_encode($previousArray);

                        $approvalArray = json_decode($approvalSys->level_users,TRUE);
                        $approvalLevel = json_decode($approvalSys->levels,TRUE);
                        $approvalUsers = json_decode($approvalSys->users,TRUE);
                        $approveUsers = $approvalSys->users; $approveLevels = $approvalSys->levels;
                        $appLevel = [];
                        $appUser = [];
                        $holdUser = '';

                        Approve::processApproval($approvalArray,$approvalLevel,$approvalUsers,$approveUsers,$approveLevels,$appLevel,$appUser,$holdUser);
                        $reqStatus = ($holdUser == '') ? Utility::APPROVED : Utility::PROCESSING;
                        $dbDATA = [
                            'req_cat' => $request->input('request_category'),
                            'req_type' => $request->input('request_type'),
                            'proj_id' => $project,
                            'req_desc' => $request->input('request_description'),
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

                        if($holdUser != '') {
                            $reqUser = $previousData->request_user;
                            $user = User::firstRow('id', $reqUser);
                            $firstUser = User::firstRow('id', $holdUser);
                            $email = $firstUser->email;
                            $fullName = $previousData->requestUser->firstname . ' ' . $previousData->requestUser->lastname;
                            $senderName = $user->firstname . ' ' . $user->lastname;
                            $subject = 'A New Fund Request from ' . $senderName;
                            /*$emailContent = [
                                'user_id' => $previousData->request_user,
                                'type' => 'next_approval',
                                'name' => $fullName,
                                'sender_name' => $senderName,
                                'desc' => $request->input('description'),
                            ];*/
                            $emailContent = new \stdClass();
                            $emailContent->user_id = $previousData->request_user;
                            $emailContent->type = 'next_approval';
                            $emailContent->name = $fullName;
                            $emailContent->sender_name = $senderName;
                            $emailContent->desc = $request->input('description');


                            Notify::AdminMail('admin_requisition.send_request', $emailContent, $email, $fullName, $subject);
                        }

                }   //END OF CHECK FOR IF DENIED

            } //END OF CHECK FOR REQUEST APPROVAL


            AdminRequisition::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

            return response()->json([
                'message' => 'good',
                'message2' => 'saved'
            ]);

        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    public function editAttachment(Request $request){
        $files = $request->file('attachment');

        $attachment = [];
        $editId = $request->input('edit_id');
        $oldData = AdminRequisition::firstRow('id',$editId);
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
        $save = AdminRequisition::defaultUpdate('id',$editId,$dbData);

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
        $oldData = AdminRequisition::firstRow('id',$editId);
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
        $save = AdminRequisition::defaultUpdate('id',$editId,$dbData);

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
            $rowDataRequest = AdminRequisition::firstRow('id', $idArray[$i]);
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
                    $proRequisition = AdminRequisition::firstRow('id', $reqId);
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

                    $update = AdminRequisition::defaultUpdate('id',$reqId,$dbData);

                    $mailContentApproved = new \stdClass();
                    $mailContentApproved->type = 'request_approved';
                    $mailContentApproved->desc = $proRequisition->req_desc;
                    $mailContentApproved->sender = $proRequisition->requestUser->firstname . ' ' . $proRequisition->requestUser->lastname;

                    if(count($approvalLevels) > 0) {
                        $firstUser = User::firstRow('id', $nextUser);
                        $email = $firstUser->email;
                        $fullName = $firstUser->firstname . ' ' . $firstUser->lastname;
                        $senderName = $proRequisition->requestUser->firstname . ' ' . $proRequisition->requestUser->lastname;
                        $subject = 'A New Request from ' . $senderName;
                        /*$emailContent = [
                            'type' => 'next_approval',
                            'name' => $fullName,
                            'user_id' => $proRequisition->request_user,
                            'sender' => $senderName,
                            'desc' => $proRequisition->req_desc,
                        ];*/
                        $emailContent = new \stdClass();
                        $emailContent->type = 'next_approval';
                        $emailContent->name = $fullName;
                        $emailContent->user_id = $proRequisition->request_user;
                        $emailContent->sender = $senderName;
                        $emailContent->desc = $proRequisition->req_desc;

                        /*$mailContentApproved = [
                            'type' => 'request_approved',
                            'desc' => $proRequisition->req_desc,
                            'sender' => $proRequisition->requestUser->firstname . ' ' . $proRequisition->requestUser->lastname
                        ];*/

                        if($update){
                            Notify::AdminMail('admin_requisition.send_request', $emailContent, $email, $fullName, $subject);
                        }

                    }


                    if($compStatus == 1){
                        Notify::AdminMail('admin_requisition.send_request', $mailContentApproved, $proRequisition->requestUser->email, $proRequisition->requestUser->firstname, 'Request Approval');
                        if($proRequisition->request_user != $proRequisition->created_by) {  //IF REQUEST WAS MADE FOR ANOTHER USER NOTIFY WHO MADE THE REQUEST
                            Notify::AdminMail('admin_requisition.send_request', $mailContentApproved, $proRequisition->user_c->email, $proRequisition->user_c->firstname, 'Request Approval');
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
                    $proRequisition = AdminRequisition::firstRow('id', $reqId);
                    $dbData = [
                        'deny_user' => Auth::user()->id,
                        'deny_reason' => $denyReason,
                        'approval_status' => Utility::DENIED,
                        'complete_status' => Utility::COMPLETED,
                    ];
                    /*$mailContentDenied = [
                        'type' => 'request_denied',
                        'desc' => $proRequisition->req_desc,
                    ];*/
                    $mailContentDenied = new \stdClass();
                    $mailContentDenied->type = 'request_denied';
                    $mailContentDenied->desc = $proRequisition->req_desc;

                    $update = AdminRequisition::defaultUpdate('id',$reqId,$dbData);

                    if($update) {
                        Notify::AdminMail('admin_requisition.send_request', $mailContentDenied, $proRequisition->requestUser->email, $proRequisition->requestUser->firstname, 'Request Denied');
                        if ($proRequisition->request_user != $proRequisition->created_by) { //IF REQUEST WAS MADE FOR ANOTHER USER NOTIFY WHO MADE THE REQUEST
                            Notify::AdminMail('admin_requisition.send_request', $mailContentDenied, $proRequisition->user_c->email, $proRequisition->user_c->firstname, 'Request Denied');
                        }
                    }
                }

            }   //END OF DENY CODES

        }else{
            return  response()->json([
                'message2' => 'warning',
                'message' => 'The '.count($unused).' requests has been approved/denied and status cannot be changed'
            ]);

        }



        //END FOR NORMAL USER DELETE

    }

    public function allOrSome($array){
        $data = '';
        $mainData = '';
        if(is_array($array)){
            if(count($array) >0){
                foreach($array as $var){
                    if($var == 0){
                        $data = 0;
                    }
                }
            }

            if($data == 0 && count($array) >0){
                $mainData = Utility::ALL_DATA;
            }
            if($data != '0' && count($array) >0){
                $mainData = Utility::SELECTED;
            }


        }else{
            $mainData = Utility::ALL_DATA;
        }

        return $mainData;

    }

    public function valdDeptUsers($dept1,$users){

        $data = '';
        if(is_array($dept1)){
            $dept = count($dept1);
            if($dept > 0 && $users == ''){
                $data = 1;
            }
            if($dept > 0 && $users != ''){
                $data = 1;
            }
            if($dept < 1 && $users != ''){
                $data = 0;
            }

        }else{
            if($dept1 == '' && $users == ''){
                $data = 1;
            }else{
                $data = 0;
            }
        }

        return $data;

    }

    public function valSelType($type){
        $dataType = '';
        if($type == Utility::USUAL_REQUEST_TYPE){
            $dataType = Utility::USUAL_REQUEST_TYPE;
        }
        if($type == Utility::PROJECT_REQUEST_TYPE){
            $dataType =  Utility::PROJECT_REQUEST_TYPE;
        }
        if($type == Utility::ALL_DATA){
            $dataType = Utility::ALL_DATA;
        }
        return $dataType;
    }

    public function valReqType($reqType){
        $type = '';
        if($reqType == '1' || $reqType == '2'){
            $type = 1;
        }
        if($reqType == '0'){
            $type = 0;
        }
        return $type;
    }

    public function tableRequestReport(Request $request){

        $reportType = $request->input('report_type');
        $dept = $request->input('department');
        $user = $request->input('user');
        $category = $request->input('request_category');
        $type = $request->input('request_type');
        $project = $request->input('project');

        $deptN = '';
        $userN = (!empty($dept)) ? '' : ($user == '')? '' : User::firstRow('id',$request->input('user'));
        $categoryN = '';
        $typeN = '';
        $projectN = '';

        $fromDate = Utility::standardDate($request->input('from_date'));
        $toDate = Utility::standardDate($request->input('to_date'));
        $code = $this->valdDeptUsers($dept,$user).$this->allOrSome($category).$this->valReqType($type);
        //return $this->valdDeptUsers($dept,$user).$this->allOrSome($category).$this->valReqType($type);
        $dateArray = [$fromDate,$toDate];
        $query = [];

        if($toDate < $fromDate){
            return  'Please ensure that the start/from date is less than the end/to date';
        }



        //FIRST CONDITION
        //SELECT FROM WHEN DEPARTMENT IS NOT EMPTY AND TYPE IS SELECTED BUT NOT ALL, CATEGORY SELECTED ALSO NOT ALL
        if($this->valdDeptUsers($dept,$user)== '1' && $this->allOrSome($category) == Utility::SELECTED && $this->valReqType($type) == '1'){

            //DEPARTMENT,CATEGORY SELECTED, TYPE IS ALL
            if($this->allOrSome($dept) == Utility::SELECTED && $this->valSelType($type) == Utility::USUAL_REQUEST_TYPE){

                $deptN = Department::specialColumnsMass('id',$dept);
                $categoryN = AdminCategory::specialColumnsMass('id',$category);
                $typeN = 'Usual Requisition';
                $projectN = 'None';

                $query = AdminRequisition::specialArraySingleColumnsPageDate3('dept_id',$dept,'req_cat',$category,'req_type',$type,$dateArray);
            }
            //DEPARTMENT IS ALL,CATEGORY SELECTED, TYPE IS ALL
            if($this->allOrSome($dept) == Utility::ALL_DATA && $this->valSelType($type) == Utility::USUAL_REQUEST_TYPE){

                $deptN = 'All';
                $categoryN = AdminCategory::specialColumnsMass('id',$category);
                $typeN = 'Usual Requisition';
                $projectN = 'None';

                $query = AdminRequisition::specialArraySingleColumns1PageDate2('req_cat',$category,'req_type',$type,$dateArray);
            }

            //DEPARTMENT,CATEGORY,TYPE SELECTED
            if($this->allOrSome($dept) == Utility::SELECTED && $this->valSelType($type) == Utility::PROJECT_REQUEST_TYPE){

                //PROJECT IS ALL,CATEGORY,DEPARTMENT SELECTED
                if($this->allOrSome($dept) == Utility::SELECTED && $this->allOrSome($project) == Utility::ALL_DATA){

                    $deptN = Department::specialColumnsMass('id',$dept);
                    $categoryN = AdminCategory::specialColumnsMass('id',$category);
                    $typeN = 'Project Requisition';
                    $projectN = 'All';

                    $query = AdminRequisition::specialArraySingleColumnsPageDate3('dept_id',$dept,'req_cat',$category,'req_type',$type,$dateArray);
                }
                //PROJECT,CATEGORY,DEPARTMENT SELECTED
                if($this->allOrSome($dept) == Utility::SELECTED && $this->allOrSome($project) == Utility::SELECTED){

                    $deptN = Department::specialColumnsMass('id',$dept);
                    $categoryN = AdminCategory::specialColumnsMass('id',$category);
                    $typeN = 'Project Requisition';
                    $projectN = Project::specialColumnsMass('id',$project);

                    $query = AdminRequisition::specialArrayColumnsPageDate3('dept_id',$dept,'req_cat',$category,'proj_id',$project,$dateArray);
                }
            }

            //DEPARTMENT IS ALL,CATEGORY,TYPE SELECTED
            if($this->allOrSome($dept) == Utility::ALL_DATA && $this->valSelType($type) == Utility::PROJECT_REQUEST_TYPE){

                //PROJECT IS ALL,CATEGORY,DEPARTMENT SELECTED
                if($this->allOrSome($dept) == Utility::ALL_DATA && $this->allOrSome($project) == Utility::ALL_DATA){

                    $deptN = 'All';
                    $categoryN = AdminCategory::specialColumnsMass('id',$category);
                    $typeN = 'Project Requisition';
                    $projectN = 'All';

                    $query = AdminRequisition::specialArraySingleColumns1PageDate2('req_cat',$category,'req_type',$type,$dateArray);
                }
                //PROJECT,CATEGORY,DEPARTMENT SELECTED
                if($this->allOrSome($dept) == Utility::ALL_DATA && $this->allOrSome($project) == Utility::SELECTED){

                    $deptN = 'All';
                    $categoryN = AdminCategory::specialColumnsMass('id',$category);
                    $typeN = 'Project Requisition';
                    $projectN = Project::specialColumnsMass('id',$project);

                    $query = AdminRequisition::specialArrayColumnsPageDate2('req_cat',$category,'proj_id',$project,$dateArray);
                }
            }

        }

        //SECOND CONDITION
        //SELECT FROM WHEN USER IS NOT EMPTY AND TYPE IS SELECTED BUT NOT ALL, CATEGORY SELECTED ALSO NOT ALL
        if($this->valdDeptUsers($dept,$user)== '0' && $this->allOrSome($category) == Utility::SELECTED && $this->valReqType($type) == '1'){

            //USER,CATEGORY SELECTED, TYPE IS USUAL REQUEST TYPE
            if($this->valSelType($type) == Utility::USUAL_REQUEST_TYPE){

                $deptN = 'None';
                $categoryN = AdminCategory::specialColumnsMass('id',$category);
                $typeN = 'Usual Request';
                $projectN = 'None';

                $query = AdminRequisition::specialArraySingleColumns2PageDate3('request_user',$user,'req_cat',$category,'req_type',$type,$dateArray);
            }

            //USER,CATEGORY,TYPE SELECTED
            if($this->valSelType($type) == Utility::PROJECT_REQUEST_TYPE){

                //PROJECT IS ALL,CATEGORY,USER SELECTED
                if($this->allOrSome($category) == Utility::SELECTED && $this->allOrSome($project) == Utility::ALL_DATA){

                    $deptN = 'None';
                    $categoryN = AdminCategory::specialColumnsMass('id',$category);
                    $typeN = 'Project Request';
                    $projectN = 'All';

                    $query = AdminRequisition::specialArraySingleColumns2PageDate3('request_user',$user,'req_cat',$category,'req_type',$type,$dateArray);
                }
                //PROJECT,CATEGORY,USER SELECTED
                if($this->allOrSome($category) == Utility::SELECTED && $this->allOrSome($project) == Utility::SELECTED){

                    $deptN = 'None';
                    $categoryN = AdminCategory::specialColumnsMass('id',$category);
                    $typeN = 'Project Request';
                    $projectN = Project::specialColumnsMass('id',$project);

                    $query = AdminRequisition::specialArrayColumnsPageDate3('request_user',$user,'req_cat',$category,'proj_id',$project,$dateArray);
                }
            }


        }

        //THIRD CONDITION
        //SELECT FROM WHEN DEPARTMENT IS NOT EMPTY AND TYPE IS SELECTED BUT NOT ALL, CATEGORY SELECTED ALSO NOT ALL
        if($this->valdDeptUsers($dept,$user)== '1' && $this->allOrSome($category) == Utility::ALL_DATA && $this->valReqType($type) == '1'){

            //DEPARTMENT,CATEGORY SELECTED, TYPE IS ALL
            if($this->allOrSome($dept) == Utility::SELECTED && $this->valSelType($type) == Utility::USUAL_REQUEST_TYPE){

                $deptN = Department::specialColumnsMass('id',$dept);
                $categoryN = AdminCategory::specialColumnsMass('id',$category);
                $typeN = 'Usual Request';
                $projectN = 'None';

                $query = AdminRequisition::specialArrayColumnsPageDate2('dept_id',$dept,'req_type',$type,$dateArray);
            }
            //DEPARTMENT IS ALL,CATEGORY SELECTED, TYPE IS ALL
            if($this->allOrSome($dept) == Utility::ALL_DATA && $this->valSelType($type) == Utility::USUAL_REQUEST_TYPE){

                $deptN = Department::specialColumnsMass('id',$dept);
                $categoryN = AdminCategory::specialColumnsMass('id',$category);
                $typeN = 'Usual Request';
                $projectN = 'None';

                $query = AdminRequisition::specialColumnsPageDate('req_type',$type,$dateArray);
            }

            //DEPARTMENT,CATEGORY ALL,TYPE SELECTED
            if($this->allOrSome($dept) == Utility::SELECTED && $this->valSelType($type) == Utility::PROJECT_REQUEST_TYPE){

                //PROJECT IS ALL,CATEGORY,DEPARTMENT SELECTED
                if($this->allOrSome($dept) == Utility::SELECTED && $this->allOrSome($project) == Utility::ALL_DATA){

                    $deptN = Department::specialColumnsMass('id',$dept);
                    $categoryN = AdminCategory::specialColumnsMass('id',$category);
                    $typeN = 'Project Request';
                    $projectN = 'All';

                    $query = AdminRequisition::specialArrayColumnsPageDate2('dept_id',$dept,'req_type',$type,$dateArray);
                }
                //PROJECT,CATEGORY,DEPARTMENT SELECTED
                if($this->allOrSome($dept) == Utility::SELECTED && $this->allOrSome($project) == Utility::SELECTED){

                    $deptN = Department::specialColumnsMass('id',$dept);
                    $categoryN = AdminCategory::specialColumnsMass('id',$category);
                    $typeN = 'Project Request';
                    $projectN = Project::specialColumnsMass('id',$project);

                    $query = AdminRequisition::specialArrayColumnsPageDate2('dept_id',$dept,'proj_id',$project,$dateArray);
                }
            }

            //DEPARTMENT IS ALL,CATEGORY ALL,TYPE SELECTED
            if($this->allOrSome($dept) == Utility::ALL_DATA && $this->valSelType($type) == Utility::PROJECT_REQUEST_TYPE){

                //PROJECT IS ALL,CATEGORY ALL,DEPARTMENT ALL
                if($this->allOrSome($dept) == Utility::ALL_DATA && $this->allOrSome($project) == Utility::ALL_DATA){

                    $deptN = 'All';
                    $categoryN = 'All';
                    $typeN = 'Project Request';
                    $projectN = 'All';

                    $query = AdminRequisition::specialColumnsPageDate('req_type',$type,$dateArray);
                }
                //PROJECT,CATEGORY,DEPARTMENT ALL
                if($this->allOrSome($dept) == Utility::ALL_DATA && $this->allOrSome($project) == Utility::SELECTED){

                    $deptN = 'All';
                    $categoryN = 'All';
                    $typeN = 'Project Request';
                    $projectN = Project::specialColumnsMass('id',$project);

                    $query = AdminRequisition::specialColumnsPageDate('proj_id',$project,$dateArray);

                }
            }

        }

        //FOURTH CONDITION
        //SELECT FROM WHEN USER IS NOT EMPTY AND TYPE IS SELECTED BUT NOT ALL, CATEGORY SELECTED ALSO NOT ALL
        if($this->valdDeptUsers($dept,$user)== '0' && $this->allOrSome($category) == Utility::ALL_DATA && $this->valReqType($type) == '1'){

            //DEPARTMENT,CATEGORY ALL, TYPE IS ALL
            if($this->valSelType($type) == Utility::USUAL_REQUEST_TYPE){

                $deptN = 'None';
                $categoryN = 'All';
                $typeN = 'Usual Requisition';
                $projectN = 'None';

                $query = AdminRequisition::specialColumnsPageDate2('request_user',$user,'req_type',$type,$dateArray);
            }

            //USER,CATEGORY,TYPE SELECTED
            if($this->valSelType($type) == Utility::PROJECT_REQUEST_TYPE){

                //PROJECT IS ALL,CATEGORY IS ALL,USER SELECTED
                if($this->allOrSome($project) == Utility::ALL_DATA){

                    $deptN = 'None';
                    $categoryN = 'All';
                    $typeN = 'Project Requisition';
                    $projectN = 'All';

                    $query = AdminRequisition::specialColumnsPageDate2('request_user',$user,'req_type',$type,$dateArray);
                }
                //PROJECT,CATEGORY,DEPARTMENT SELECTED
                if($this->allOrSome($project) == Utility::SELECTED){

                    $deptN = 'None';
                    $categoryN = 'All';
                    $typeN = 'Project Requisition';
                    $projectN = Project::specialColumnsMass('id',$project);
                    $query = AdminRequisition::specialArraySingleColumns1PageDate2('proj_id',$project,'request_user',$user,$dateArray);
                }
            }


        }

        //FIFTH CONDITION
        //SELECT FROM WHEN USER IS NOT EMPTY AND TYPE IS SELECTED BUT NOT ALL, CATEGORY SELECTED ALSO NOT ALL
        if($this->valdDeptUsers($dept,$user)== '1' && $this->allOrSome($category) == Utility::SELECTED && $this->valReqType($type) == '0'){

            //DEPARTMENT,CATEGORY SELECTED, TYPE IS ALL
            if($this->allOrSome($dept) == Utility::SELECTED){

                $deptN = Department::specialColumnsMass('id',$dept);
                $categoryN = AdminCategory::specialColumnsMass('id',$category);
                $typeN = 'All';
                $projectN = 'All';

                $query = AdminRequisition::specialArrayColumnsPageDate2('req_cat',$category,'dept_id',$dept,$dateArray);
            }

            //DEPARTMENT IS ALL,CATEGORY ALL, TYPE IS ALL
            if($this->allOrSome($dept) == Utility::ALL_DATA){

                $deptN = 'All';
                $categoryN = AdminCategory::specialColumnsMass('id',$category);
                $typeN = 'All';
                $projectN = 'All';

                $query = AdminRequisition::specialArrayColumnsPageDate('req_cat',$category,$dateArray);
            }

        }

        //SIXTH CONDITION
        //SELECT FROM WHEN USER IS NOT EMPTY AND TYPE IS SELECTED BUT NOT ALL, CATEGORY SELECTED ALSO NOT ALL
        if($this->valdDeptUsers($dept,$user)== '0' && $this->allOrSome($category) == Utility::SELECTED && $this->valReqType($type) == '0'){

            //DEPARTMENT,CATEGORY SELECTED, TYPE IS ALL
            if($this->allOrSome($category) == Utility::SELECTED){

                $deptN = 'None';
                $categoryN = AdminCategory::specialColumnsMass('id',$category);
                $typeN = 'All';
                $projectN = 'All';

                $query = AdminRequisition::specialArraySingleColumns1PageDate2('req_cat',$category,'request_user',$user,$dateArray);
            }

        }

        //SEVENTH CONDITION
        //SELECT FROM WHEN DEPARTMENT IS NOT EMPTY AND TYPE IS ALL, CATEGORY ALL
        if($this->valdDeptUsers($dept,$user)== '1' && $this->allOrSome($category) == Utility::ALL_DATA && $this->valReqType($type) == '0'){

            //DEPARTMENT,CATEGORY SELECTED, TYPE IS ALL
            if($this->allOrSome($dept) == Utility::SELECTED){

                $deptN = Department::specialColumnsMass('id',$dept);
                $categoryN = 'All';
                $typeN = 'All';
                $projectN = 'All';

                $query = AdminRequisition::specialArrayColumnsPageDate('dept_id',$dept,$dateArray);
            }

            //DEPARTMENT IS ALL,CATEGORY ALL, TYPE IS ALL
            if($this->allOrSome($dept) == Utility::ALL_DATA){

                $deptN = 'All';
                $categoryN = 'All';
                $typeN = 'All';
                $projectN = 'All';

                $query = AdminRequisition::paginateAllDataDate($dateArray);
            }

        }

        //EIGHT CONDITION
        //SELECT FROM WHEN USER IS NOT EMPTY AND TYPE IS ALL, CATEGORY ALL
        if($this->valdDeptUsers($dept,$user)== '0' && $this->allOrSome($category) == Utility::ALL_DATA && $this->valReqType($type) == '0'){

            //DEPARTMENT,CATEGORY ALL, TYPE IS ALL
            if($this->allOrSome($category) == Utility::ALL_DATA){

                $deptN = 'None';
                $categoryN = 'All';
                $typeN = 'All';
                $projectN = 'All';

                $query = AdminRequisition::specialColumnsPageDate('request_user',$user,$dateArray);
            }

        }

        $newDept = '';
        $newCat = '';
        $newProj = '';
        //return $deptN;
        if(is_object($deptN) && !empty($deptN)){
            $dep = [];
            foreach($deptN as $val){
                $dep[] = $val->dept_name;
            }
            $newDept = implode(',',$dep);
        }else{
            $newDept = $deptN;
        }

        //return json_encode($categoryN);
        if(is_object($categoryN) && !empty($categoryN)){
            $cat = [];
            foreach($categoryN as $val){
                $cat[] = $val->request_name;
            }
            $newCat = implode(',',$cat);
        }else{
            $newCat = $categoryN;
        }

        if(is_object($projectN) && !empty($projectN)){
            $proj = [];
            foreach($projectN as $val){
                $proj[] = $val->project_name;
            }
            $newProj = implode(',',$proj);
        }else{
            $newProj = $projectN;
        }
        $newDept = ($newDept == 'None') ? '': $newDept;
        if(!empty($query)){
            $userN = (!empty($userN)) ? $userN->firstname.' '.$userN->lastname: '';
            $categoryN = (is_array($category)) ? json_encode($category) : $categoryN;
            $projectN = (is_array($project)) ? json_encode($project) : $projectN;

            //CHECK THE REPORT TYPE IS TABLE OR CHART
            if($reportType == 'table'){
                $this->filterData($query);
                return view::make('admin_requisition.table_request_report')->with('mainData',$query)
                    ->with('from_date',$request->input('from_date'))
                    ->with('to_date',$request->input('to_date'))->with('deptN',$newDept)
                    ->with('userN',$userN)->with('categoryN',$newCat)->with('typeN',$typeN)
                    ->with('projectN',$newProj);
            }

            if($reportType == 'chart'){
                $chartData = $this->arrangeMonth($query,$fromDate,$toDate);
                $this->filterData($query);
                return view::make('admin_requisition.chart_request_report')->with('mainData',$query)
                    ->with('from_date',$request->input('from_date'))
                    ->with('to_date',$request->input('to_date'))->with('chart_data',$chartData)
                    ->with('deptN',$newDept)->with('userN',$userN)->with('categoryN',$newCat)
                    ->with('typeN',$typeN)->with('projectN',$newProj);
            }

        }else{
            return 'Match not found';
        }


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

            $delete = AdminRequisition::massUpdate('id', $idArray, $dbData);

            return response()->json([
                'message' => 'deleted',
                'message2' => 'Data deleted successfully'
            ]);

        }else{  //END OF REMOVAL FOR THE TOP USERS

            $in_use = [];
            $unused = [];
            for($i=0;$i<count($idArray);$i++){
                $rowDataRequest = AdminRequisition::firstRow('id', $idArray[$i]);
                if($rowDataRequest->complete_status == 1 || $rowDataRequest->deny_reason !=''){
                    $unused[$i] = $idArray[$i];
                }else{
                    $in_use[$i] = $idArray[$i];
                }
            }
            $message = (count($unused) > 0) ? ' and '.count($unused).
                ' has been approved/denied and cannot be deleted' : '';
            if(count($in_use) > 0){
                $delete = AdminRequisition::massUpdate('id',$in_use,$dbData);

                return response()->json([
                    'message' => 'deleted',
                    'message2' => count($in_use).' data(s) has been deleted '.$message
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

    public function filterItemData($data){

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


        return $data;
    }   //END OF FILTERING DATA

    public function sumReportAmount($query){
        $amountArray = [];
        $sum = 0.00;
        if(!empty($query)){
            foreach($query as $val){
                $amountArray[] = $val->amount;
            }
            $sum = array_sum($amountArray);
        }

        return number_format($sum);
    }

    public function arrangeMonth($query,$start,$end){
        $startDate = Utility::standardDate($start);
        $endDate = Utility::standardDate($end);
        $startYear =  date('Y',strtotime($startDate));
        $endYear = date('Y',strtotime($endDate));
        $monthYear = [];
        for($y=$startYear;$y<=$endYear;$y++){
            for($m=1;$m<=12;$m++){
                $monthName = date("F", mktime(0, 0, 0, $m, 10));
                $calcMonthAmtArray = [];
                foreach($query as $val){

                    $stdDate = Utility::standardDate($val->created_at);
                    $getM = date('m',strtotime($stdDate)); $getY = date('Y',strtotime($stdDate));
                    if($getM == $m && $getY == $y){
                        $calcMonthAmtArray[] = $val->id;
                    }

                }
                $monthYear[$monthName.'-'.$y] = count($calcMonthAmtArray);

            }
        }
        return $monthYear;

    }

}
