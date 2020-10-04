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
use App\model\TaskItems;
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

class TaskListController extends Controller
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


        $mainData = TaskList::specialColumnsPage('project_id',$id);
        $taskList = TaskList::specialColumns('project_id',$id);
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);
        $this->countTask($mainData);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','task_list.reload','task_list.reload'),array('mainData' => $mainData,
                'item' => $project,'taskList',$taskList))->render());

        }
        return view::make(Utility::authBlade('temp_user','task_list.main_view','task_list.main_view_temp'))
            ->with('mainData',$mainData)->with('item',$project)->with('taskList',$taskList);

    }

    public function indexTemp(Request $request,$id)
    {

        $mainData = TaskList::specialColumnsPage('project_id',$id);
        $taskList = TaskList::specialColumns('project_id',$id);
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);
        $this->countTask($mainData);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','task_list.reload','task_list.reload'),array('mainData' => $mainData,
                'item' => $project,'taskList',$taskList))->render());

        }
        return view::make(Utility::authBlade('temp_user','task_list.main_view','task_list.main_view_temp'))
            ->with('mainData',$mainData)->with('item',$project)->with('taskList',$taskList);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $taskTitle = Utility::jsonUrlDecode($request->input('task_title'));
        $user= Utility::jsonUrlDecode($request->input('user_class'));
        $taskDetails = Utility::jsonUrlDecode($request->input('task_details'));
        $taskStatus = Utility::jsonUrlDecode($request->input('task_status'));
        $startDate = Utility::jsonUrlDecode($request->input('start_date'));
        $endDate = Utility::jsonUrlDecode($request->input('end_date'));
        $taskPriority = Utility::jsonUrlDecode($request->input('task_priority'));
        $timePlanned = Utility::jsonUrlDecode($request->input('time_planned'));
        $changeUser = Utility::jsonUrlDecode($request->input('change_user'));
        $projectId = $request->input('project_id');
        $changeTask = $request->input('change_task');
        $listDesc = $request->input('list_desc');
        $listTitle = ($changeTask != 2) ? $request->input('list_title'):$request->input('task_list');

        /*return response()->json([
            'message' => 'warning',
            'message2' => 'changeTask='.$changeTask.'list_name='.$listTitle
        ]);*/
        $validator = Validator::make($request->all(),TaskList::$mainRules);
        if($validator->passes()) {

            if (!empty($taskTitle) && !empty($taskDetails) && !empty($taskStatus) && !empty($startDate) && !empty($endDate)) {

                $taskNewId = [];

                for ($i = 0; $i < count($taskTitle); $i++) {
                    $changeUserTbl = ($changeUser[$i] == Utility::P_USER) ? 'assigned_user' : 'temp_user';
                    $changeUserDbTbl = ($changeUser[$i] == Utility::P_USER) ? 'users' : 'temp_users';

                    $userType = ($user[$i] == '') ? '' : $changeUser[$i];
                    $dbDATA = [
                        'project_id' => $projectId,
                        'task' => $taskTitle[$i],
                        'task_desc' => Utility::checkEmptyArrayItem($taskDetails,$i,''),
                        $changeUserTbl => Utility::checkEmptyArrayItem($user, $i, ''),
                        'task_status' => $taskStatus[$i],
                        'start_date' => Utility::standardDate($startDate[$i]),
                        'end_date' => Utility::standardDate($endDate[$i]),
                        'task_priority' => Utility::checkEmptyArrayItem($taskPriority, $i, ''),
                        'work_hours' => Utility::checkEmptyArrayItem($timePlanned, $i, ''),
                        'user_type' => $userType,
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];

                    $task = Task::create($dbDATA);
                    $taskNewId[] = $task->id;
                    $projDetails = Project::firstRow('id', $projectId);
                    if (Utility::checkEmptyArrayItem($user, $i, '') != '') {
                        $userData = Utility::firstRow($changeUserDbTbl, 'id', $user[$i]);
                        $userEmail = $userData->email;

                        $mailContent = [];

                        $messageBody = "Hello '.$userData->firstname.', a task " . $taskTitle[$i] . " have been
                    assigned to you on the project " . $projDetails->project_name . " please visit the portal to view";

                        $mailContent['message'] = $messageBody;
                        $mailContent['fromEmail'] = Utility::checkAuth('temp_user')->email;
                        Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);

                    }


                }
                $createUpdate = ($changeTask == '2') ? 'updated_by' : 'created_by';
                if($changeTask == '2'){
                    $listData = TaskList::firstRow('id',$listTitle);
                    $listTitle = $listData->list_name;
                }

                $dbDATAList = [
                    'list_name' => $listTitle,
                    'list_desc' => $listDesc,
                    'project_id' => $projectId,
                    'list_status' => $request->input('list_status'),
                    'status' => Utility::STATUS_ACTIVE,
                    $createUpdate => Auth::user()->id,
                ];

                $taskList = ($changeTask == '2') ? TaskList::defaultUpdate('id',$listTitle,$dbDATAList) : TaskList::create($dbDATAList);
                $listId = ($changeTask == '2') ? $request->input('task_list') : $taskList->id;

                foreach ($taskNewId as $taskId) {
                    $dbDATAList = [
                        'list_id' => $listId,
                        'task_id' => $taskId,
                        'status' => Utility::STATUS_ACTIVE,
                        'created_by' => Auth::user()->id,
                    ];

                }
                TaskItems::create($dbDATAList);

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);


            } else {
                return response()->json([
                    'message' => 'warning',
                    'message2' => 'Please fill in all required task fields, Title,Status,Start date, End date'
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
        $tasks = TaskList::firstRow('id',$request->input('dataId'));
        return view::make('task_list.edit_form')->with('edit',$tasks);

    }

    public function taskForm(Request $request)
    {
        //
        $tasks = TaskItems::specialColumns('list_id',$request->input('dataId'));
        $taskIds = [];
        foreach($tasks as $t){
            $taskIds[] = $t->task_id;
        }
        $mainData = Task::massData('id',$taskIds);
        return view::make('task_list.task_form')->with('mainData',$mainData);

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

        $validator = Validator::make($request->all(),TaskList::$mainRules);
        if($validator->passes()) {

            $taskTitle = $request->input('list_title');
            $taskDetails = $request->input('list_desc');

            $dbDATA = [
                'list_name' => $taskTitle,
                'list_desc' => $taskDetails,
                'list_status' => $request->input('list_status'),
                'updated_by' => Auth::user()->id,
            ];

            TaskList::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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



        $taskItems = TaskItems::massData('list_id',$idArray);
        $taskArray = [];
        foreach ($taskItems as $task){
            $taskArray[] = $task->task_id;
        }

        $delete1 = TaskList::massUpdate('id',$idArray,$dbData);
        $delete2 = TaskItems::massUpdate('task_id',$taskArray,$dbData);
        $delete3 = Task::massUpdate('task_id',$taskArray,$dbData);
        $delete4 = Timesheet::massUpdate('task_id',$taskArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

    public function destroyListItem(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];

        $delete2 = TaskItems::massUpdate('task_id',$idArray,$dbData);
        $delete3 = Task::massUpdate('id',$idArray,$dbData);
        $delete4 = Timesheet::massUpdate('task_id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);
    }

    public function countTask($data){
        foreach($data as $d){
            $countTask = TaskItems::countData('list_id',$d->id);
            $d->count_task = $countTask;
        }
    }

}
