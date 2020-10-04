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

class TimesheetController extends Controller
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


        $mainData = Timesheet::specialColumnsPage2('project_id',$id,Utility::authColumn('temp_user'),Utility::checkAuth('temp_user')->id);
        $task = Task::specialColumns2('project_id',$id,Utility::authColumn('temp_user'),Utility::checkAuth('temp_user')->id);
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','timesheet.reload','timesheet.reload'),array('mainData' => $mainData,
                'item' => $project,'task' => $task))->render());

        }
        return view::make(Utility::authBlade('temp_user','timesheet.main_view','timesheet.main_view_temp'))->with('mainData',$mainData)
            ->with('item',$project)->with('task',$task);

    }

    public function indexTemp(Request $request,$id)
    {

        $mainData = Timesheet::specialColumnsPage2('project_id',$id,Utility::authColumn('temp_user'),Utility::checkAuth('temp_user')->id);
        //$mainData = Task::specialColumnsPage('project_id',$id);
        $project = Project::firstRow('id',$id);$task = Task::specialColumns2('project_id',$id,Utility::authColumn('temp_user'),Utility::checkAuth('temp_user')->id);
        Utility::processProjectItem($project);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','timesheet.reload','task.reload'),array('mainData' => $mainData,
                'item' => $project,'task' => $task))->render());

        }
        return view::make(Utility::authBlade('temp_user','timesheet.main_view','timesheet.main_view_temp'))->with('mainData',$mainData
        )->with('item',$project)->with('task',$task);


    }

    public function approval(Request $request,$id)
    {


        $mainData = Timesheet::specialColumnsPage('project_id',$id);
        $task = Task::specialColumns2('project_id',$id,Utility::authColumn('temp_user'),Utility::checkAuth('temp_user')->id);
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','timesheet.approval_reload','timesheet.approval_reload'),array('mainData' => $mainData,
                'item' => $project,'task' => $task))->render());

        }
        return view::make(Utility::authBlade('temp_user','timesheet.approval','timesheet.approval'))->with('mainData',$mainData)
            ->with('item',$project)->with('task',$task);

    }

    public function approveTimesheet(Request $request)
    {
        //
        $all_id = json_decode($request->input('all_data'));
        $status = $request->input('status');

        $dbData = [
            'approval_status' => $status,
            'approved_by' => Utility::checkAuth('temp_user')->id,
        ];

        Timesheet::massUpdate('id',$all_id,$dbData);

        return response()->json([
            'message' => 'saved',
            'message2' => 'Processed'
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
        $validator = Validator::make($request->all(),Timesheet::$mainRules);
        if($validator->passes()){

            $files = $request->file('attachment');
            $timesheetTitle = $request->input('timesheet_title');
            $taskId= $request->input('task');
            $timesheetDetails = $request->input('timesheet_details');
            $projectId = $request->input('project_id');
            $workHours = $request->input('work_hours');
            $workDate = $request->input('work_date');
            $attachment = [];

            if($files != ''){
                foreach($files as $file){
                    //return$file;
                    $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                    $file->move(
                        Utility::FILE_URL(), $file_name
                    );
                    //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                    $attachment[] =  $file_name;

                }
            }


                $dbDATA = [
                    'task_id' => $taskId,
                    'timesheet_title' => $timesheetTitle,
                    'timesheet_desc' => $timesheetDetails,
                    'project_id' => $projectId,
                    'work_date' => Utility::standardDate($workDate),
                    'work_hours' => $workHours,
                    'attachment' => json_encode($attachment),
                    Utility::authColumn('temp_user') => Utility::checkAuth('temp_user')->id,
                    'created_by' => Utility::checkAuth('temp_user')->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                Timesheet::create($dbDATA);

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
        $timesheet = Timesheet::firstRow('id',$request->input('dataId'));
        return view::make('timesheet.edit_form')->with('edit',$timesheet);

    }

    public function attachmentForm(Request $request)
    {
        //
        $timesheet = Timesheet::firstRow('id',$request->input('dataId'));
        return view::make('timesheet.attach_form')->with('edit',$timesheet);

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

        $validator = Validator::make($request->all(),Timesheet::$mainRulesEdit);
        if($validator->passes()) {

            $timesheetTitle = $request->input('timesheet_title');
            $taskId= $request->input('task');
            $timesheetDetails = $request->input('timesheet_details');
            $projectId = $request->input('project_id');
            $workHours = $request->input('work_hours');
            $workDate = $request->input('work_date');

            $dbDATA = [
                'timesheet_title' => $timesheetTitle,
                'timesheet_desc' => $timesheetDetails,
                'work_date' => Utility::standardDate($workDate),
                'work_hours' => $workHours,
                Utility::authColumn('temp_user') => Utility::checkAuth('temp_user')->id,
                'updated_by' => Utility::checkAuth('temp_user')->id,
            ];

            Timesheet::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
        //return $files;
        $attachment = [];
        $editId = $request->input('edit_id');
        $oldData = Timesheet::firstRow('id',$editId);
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
        $save = Timesheet::defaultUpdate('id',$editId,$dbData);

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
        $oldData = Timesheet::firstRow('id',$editId);
        $oldAttachment = json_decode($oldData->attachment,true);


        //REMOVE FILES FROM AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
        $attachJson = Utility::removeJsonItem($oldData->attachment,$file_name);

        $dbData = [
            'attachment' => $attachJson
        ];
        $save = Timesheet::defaultUpdate('id',$editId,$dbData);

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

    public function searchTimesheet(Request $request)
    {
        //
        $task = $request->input('task');
        $user = $request->input('user');
        $changeUser = $request->input('change_user');
        $userColumn = ($changeUser != '2') ? 'assigned_user' : 'temp_user';

        $validator = Validator::make($request->all(),Timesheet::$searchRules);
        if($validator->passes()) {

            $mainData = Timesheet::specialColumns2('task_id',$task,$userColumn,$user);

            return view::make('timesheet.search_user_timesheet')->with('mainData',$mainData)
                    ->with('type','data');

        }else{
            $mainData = $validator->errors();
            return view::make('timesheet.search_user_timesheet')->with('mainData',$mainData)->with('type','error');
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
        Timesheet::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);
    }
}
