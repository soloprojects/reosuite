<?php

namespace App\Http\Controllers;

use App\Helpers\Notify;
use App\model\Inventory;
use Illuminate\Http\Request;
use App\model\AssumpConstraint;
use App\model\BillMethod;
use App\model\ChangeLog;
use App\model\Decision;
use App\model\Deliverable;
use App\model\Issues;
use App\model\LessonsLearnt;
use App\model\Milestone;
use App\model\Project;
use App\model\ProjectDocs;
use App\model\ProjectMemberRequest;
use App\model\ProjectTeam;
use App\Helpers\Utility;
use App\model\Risk;
use App\model\TaskList;
use App\model\Timesheet;
use App\User;
use App\model\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Input;
use Hash;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use App\Http\Requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class ProjectMemberRequestController extends Controller
{

    function __contstuct(){
        $this->middleware('auth');
        $this->middleware('auth:temp_user');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$id)
    {


        $mainData = ProjectMemberRequest::specialColumnsPage2('project_id',$id,Utility::authColumn('temp_user'),Utility::checkAuth('temp_user')->id);
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','project_request.reload','project_request.reload'),array('mainData' => $mainData,
                'item' => $project))->render());

        }
        return view::make(Utility::authBlade('temp_user','project_request.main_view','project_request.main_view_temp'))->with('mainData',$mainData)
            ->with('item',$project);

    }

    public function indexTemp(Request $request,$id)
    {

        $mainData = ProjectMemberRequest::specialColumnsPage2('project_id',$id,Utility::authColumn('temp_user'),Utility::checkAuth('temp_user')->id);
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','project_request.reload','project_request.reload'),array('mainData' => $mainData,
                'item' => $project))->render());

        }
        return view::make(Utility::authBlade('temp_user','project_request.main_view','project_request.main_view_temp'))->with('mainData',$mainData)
            ->with('item',$project);

    }

    public function allRequests(Request $request,$id)
    {


        $mainData = ProjectMemberRequest::specialColumnsPage('project_id',$id);
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','project_request.all_request_reload','project_request.all_request_reload'),array('mainData' => $mainData,
                'item' => $project))->render());

        }
        return view::make(Utility::authBlade('temp_user','project_request.all_request','project_request.all_request'))->with('mainData',$mainData)
            ->with('item',$project);

    }

    public function requestResponse(Request $request)
    {
        //
        $validator = Validator::make($request->all(),ProjectMemberRequest::$responseRules);
        if($validator->passes()) {
            $editId = $request->input('edit_id');
            $response = $request->input('ckInput');
            $dbData = [
                'response' => $response,
                'response_status' => Utility::STATUS_ACTIVE,
                'updated_by' => Utility::checkAuth('temp_user')->id,
            ];

            ProjectMemberRequest::defaultUpdate('id', $editId, $dbData);

            //SEND OUT EMAIL
            $dbData = ProjectMemberRequest::firstRow('id',$editId);
            $userTable = (!empty($dbData->assigned_user)) ? 'users' : 'temp_users';
            $userId = (!empty($dbData->assigned_user)) ? $dbData->assigned_user : $dbData->temp_user;
            $userData = DB::table($userTable)->where('',$userId)->first();
            $userEmail = $userData->email;
            $mailContent = [];

            $messageBody = "Hello $userData->firstname, your project request has been resolved, please visit the portal to confirm";

            $mailContent['message'] = $messageBody;
            $mailContent['fromEmail'] = Utility::checkAuth('temp_user')->email;
            Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);


            return response()->json([
                'message' => 'saved',
                'message2' => 'Processed'
            ]);
        }

        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),ProjectMemberRequest::$mainRules);
        if($validator->passes()){

            $subject = $request->input('subject');
            $details = $request->input('ckInput');
            $projectId = $request->input('project_id');

            $dbDATA = [
                'subject' => $subject,
                'details' => $details,
                'project_id' => $projectId,
                Utility::authColumn('temp_user') => Utility::checkAuth('temp_user')->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            ProjectMemberRequest::create($dbDATA);

                $projDetails = Project::firstRow('id',$projectId);
                $userData = User::firstRow('id',$projDetails->project_head);
                $userEmail = $userData->email;

                $mailContent = [];

                $messageBody = "Hello $userData->firstname, a team member sent in a request
                 on the project ".$projDetails->project_name." please visit the portal to respond";

                $mailContent['message'] = $messageBody;
                $mailContent['fromEmail'] = Utility::checkAuth('temp_user')->email;
                Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);


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
        $projectRequest = ProjectMemberRequest::firstRow('id',$request->input('dataId'));
        return view::make('project_request.edit_form')->with('edit',$projectRequest);

    }

    public function requestResponseForm(Request $request)
    {
        //
        $projectRequest = ProjectMemberRequest::firstRow('id',$request->input('dataId'));
        return view::make('project_request.attach_form')->with('edit',$projectRequest);

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

        $validator = Validator::make($request->all(),ProjectMemberRequest::$mainRules);
        if($validator->passes()) {

            $subject = $request->input('subject');
            $details = $request->input('ckInput');

            $dbDATA = [
                'subject' => $subject,
                'details' => $details,
                Utility::authColumn('temp_user') => Utility::checkAuth('temp_user')->id,
                'response_status' => Utility::ZERO,
            ];

            ProjectMemberRequest::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

            //SEND OUT MAIL
            $itemData = ProjectMemberRequest::firstRow('id',$request->input('edit_id'));
            $projDetails = Project::firstRow('id',$itemData->project_id);
            $userData = User::firstRow('id',$projDetails->project_head);
            $userEmail = $userData->email;

            $mailContent = [];

            $messageBody = "Hello $userData->firstname, a team member modified already existing request
             on the project ".$projDetails->project_name." please visit the portal to respond";

            $mailContent['message'] = $messageBody;
            $mailContent['fromEmail'] = Utility::checkAuth('temp_user')->email;
            Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);

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
        ProjectMemberRequest::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);
    }
}
