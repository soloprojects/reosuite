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
use View;
use Validator;
use Input;
use Hash;
use DB;
use Intervention\Image\Facades\Image;
use App\Http\Requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class ProjectTeamController extends Controller
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


        $mainData = ProjectTeam::specialColumnsPage('project_id',$id);
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','project_team.reload','project_team.reload'),array('mainData' => $mainData,
                'item' => $project))->render());

        }
        return view::make(Utility::authBlade('temp_user','project_team.main_view','project_team.main_view_temp'))->with('mainData',$mainData)->with('item',$project);

    }

    public function indexTemp(Request $request,$id)
    {

        $mainData = Task::specialColumnsPage2('project_id',$id,Utility::authColumn('temp_user'),Utility::checkAuth('temp_user')->id);
        //$mainData = Task::specialColumnsPage('project_id',$id);
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','project_team.reload','project_team.reload'),array('mainData' => $mainData,
                'item' => $project))->render());

        }
        return view::make(Utility::authBlade('temp_user','project_team.main_view','project_team.main_view_temp'))->with('mainData',$mainData)->with('item',$project);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //

        $user= Utility::jsonUrlDecode($request->input('user_class'));
        $changeUser = Utility::jsonUrlDecode($request->input('change_user'));
        $projectId = $request->input('project_id');

        /*return response()->json([
            'message' => 'warning',
            'message2' => json_encode($user).'changeUser='.json_encode($changeUser)
        ]);*/

        if(!empty($user)){

            for($i=0;$i<count($user);$i++) {
                $uid = Utility::generateUniqueId('project_team','unique_id');
                $changeUserTbl = ($changeUser[$i] == Utility::P_USER) ? 'user_id' : 'temp_user' ;
                $changeUserDbTbl = ($changeUser[$i] == Utility::P_USER) ? 'users' : 'temp_users' ;

                $userType = ($user[$i] == '' ) ? '' : $changeUser[$i];
                $dbDATA = [
                    'unique_id' => $uid,
                    'project_id' => $projectId,
                    'project_access' => Utility::STATUS_ACTIVE,
                    $changeUserTbl => Utility::checkEmptyArrayItem($user,$i,''),
                    'user_type' => $userType,
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                ProjectTeam::create($dbDATA);
                $projDetails = Project::firstRow('id',$projectId);
                if(Utility::checkEmptyArrayItem($user,$i,'') != ''){
                    $userData = Utility::firstRow($changeUserDbTbl,'id',$user[$i]);
                    $userEmail = $userData->email;

                    $mailContent = [];

                    $messageBody = "Hello '.$userData->firstname.', you have been
                    added as a team member on the project ".$projDetails->project_name." please visit the portal to view";

                    $mailContent['message'] = $messageBody;
                    $mailContent['fromEmail'] = Utility::checkAuth('temp_user')->email;
                    Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);

                }


            }

            return response()->json([
                'message' => 'good',
                'message2' => 'saved'
            ]);


        }else{
            return response()->json([
                'message' => 'warning',
                'message2' => 'Please fill in all required task fields'
            ]);
        }


        /* $errors = $validator->errors();
         return response()->json([
             'message2' => 'fail',
             'message' => $errors
         ]);*/


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
        $skill = ProjectTeam::firstRow('id',$request->input('dataId'));
        return view::make('project_team.edit_form')->with('edit',$skill);

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

        $validator = Validator::make($request->all(),ProjectTeam::$mainRules);
        if($validator->passes()) {

            $user= $request->input('user');
            $changeUser = $request->input('change_user');
            $changeUser = ($changeUser != '') ? Utility::T_USER : Utility::P_USER ;

            $userType = ($user == '' ) ? '' : $changeUser ;
            $taskTbl = ProjectTeam::firstRow('id',$request->input('edit_id'));
            $changeUserCol = ($changeUser != Utility::P_USER) ? 'temp_user' : 'user_id' ;
            $changeUserDbTbl = ($changeUser != Utility::P_USER) ? 'temp_users' : 'users' ;

            $dbDATA = [
                $changeUserCol => $user,
                'user_type' => $userType,
                'updated_by' => Auth::user()->id,
            ];

            $formUserColumn = ($taskTbl->user_type == '') ? '': ($taskTbl->user_type == Utility::P_USER) ? 'user_id' : 'temp_user';
            $formUserDbTbl = ($taskTbl->user_type == '') ? '': ($taskTbl->user_type == Utility::P_USER) ? 'users' : 'temp_users';

            /*return response()->json([
            'message' => 'warning',
            'message2' => 'userType='.$userType.'userId='.$user.'changeUser='.$changeUser.'column='.$formUserColumn
        ]);*/
            if($user != ''){

                $projDetails = Project::firstRow('id',$taskTbl->project_id);
                $userData = Utility::firstRow($changeUserDbTbl,'id',$user);
                $userEmail = $userData->email;
                $userEmailOld = '';

                $mailContentNew = [];
                $mailContentOld = [];
                $mailContentWithdraw = [];

                $messageBodyNew = "Hello '.$userData->firstname.', you have been
                    added as a team member on the project ".$projDetails->project_name." please visit the portal to view";

                $messageBodyOld = "Hello '.$userData->firstname.', you have been
                    added as a team member on the project ".$projDetails->project_name." please visit the portal to view";

                $mailContentNew['message'] = $messageBodyNew;
                $mailContentOld['message'] = $messageBodyOld;
                $mailContentNew['fromEmail'] = Utility::checkAuth('temp_user')->email;
                $mailContentOld['fromEmail'] = Utility::checkAuth('temp_user')->email;
                $mailContentWithDraw['fromEmail'] = Utility::checkAuth('temp_user')->email;
                $mailContent = ($taskTbl->user_type == '') ? $mailContentNew : $mailContentOld;

                //IF TASK WAS ASSIGNED TO A DIFFERENT USER AND NOW ASSIGNED TO A NEW USER, SEND MAIL TO OLD USER THAT TASK HAVE BEEN WITHDRAWN FROM HE/SHE
                if($taskTbl->user_type != ''){
                    $userDataOld = Utility::firstRow($formUserDbTbl,'id',$user);
                    $userEmailOld= $userDataOld->email;

                    $messageWithdraw = "Hello '.$userDataOld->firstname.', you have been
                    replaced by a team member on the project ".$projDetails->project_name;

                    $mailContentWithdraw['message'] = $messageWithdraw;

                }


                if($changeUserCol == $formUserColumn ){ //CHECK IF TASK HAS BEEN SWITCHED FROM TEMP/EXTERNAL USER TO A PERMANENT USER
                    if($taskTbl->user_type == Utility::P_USER) {
                        if ($taskTbl->assigned_user != $user) { //IF ASSIGNED TO A DIFFERENT USER SEND A MAIL
                            Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);
                            if($taskTbl->user_type != ''){ Notify::GeneralMail('mail_views.general', $mailContentWithdraw, $userEmailOld); }

                        }
                    }else{
                        if ($taskTbl->temp_user != $user) { //IF ASSIGNED TO A DIFFERENT USER SEND A MAIL
                            Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);
                            if($taskTbl->user_type != ''){ Notify::GeneralMail('mail_views.general', $mailContentWithdraw, $userEmailOld); }

                        }
                    }
                }else{
                    ProjectTeam::defaultUpdate('id',$request->input('edit_id'),[$formUserColumn => '']);
                }

            }else{
                $update = ($formUserColumn == '') ? '' : ProjectTeam::defaultUpdate('id',$request->input('edit_id'),[$formUserColumn => '']);
            }

            ProjectTeam::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

    public function searchTeamMember(Request $request)
    {
        //
        $table = $_GET['table'];
        $column = $_GET['column'];
        $search = ProjectTeam::searchProjectTeam($_GET['searchVar'],$table,$column);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->po_id;
        }

        //print_r($search); exit();
        $receipt_ids = array_unique($obtain_array);
        $mainData =  ProjectTeam::massData('unique_id', $receipt_ids);
        //print_r($obtain_array); die();
        if (count($receipt_ids) > 0) {

            return view::make('project_team.receipt_search')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
        }

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
        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];
        $deleteTeam = ProjectTeam::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);
    }
}
