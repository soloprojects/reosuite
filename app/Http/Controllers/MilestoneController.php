<?php

namespace App\Http\Controllers;

use App\Helpers\Notify;
use App\model\Inventory;
use App\model\MilestoneItems;
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

class MilestoneController extends Controller
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


        $mainData = Milestone::specialColumnsPage('project_id',$id);
        $milestone = Milestone::specialColumns('project_id',$id);
        $taskList = TaskList::specialColumns('project_id',$id);
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);
        $this->countTask($mainData);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','milestone.reload','task_list.reload'),array('mainData' => $mainData,
                'item' => $project,'taskList',$taskList,'milestone',$milestone))->render());

        }
        return view::make(Utility::authBlade('temp_user','milestone.main_view','task_list.main_view_temp'))
            ->with('mainData',$mainData)->with('item',$project)->with('taskList',$taskList)
            ->with('milestone',$milestone);

    }

    public function indexTemp(Request $request,$id)
    {

        $mainData = Milestone::specialColumnsPage('project_id',$id);
        $milestone = Milestone::specialColumns('project_id',$id);
        $taskList = TaskList::specialColumns('project_id',$id);
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);
        $this->countTask($mainData);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','milestone.reload','milestone.reload'),array('mainData' => $mainData,
                'item' => $project,'taskList',$taskList,'milestone',$milestone))->render());

        }
        return view::make(Utility::authBlade('temp_user','milestone.main_view','milestone.main_view_temp'))
            ->with('mainData',$mainData)->with('item',$project)->with('taskList',$taskList)
            ->with('milestone',$milestone);

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
        $taskList = Utility::jsonUrlDecode($request->input('task_list'));
        $projectId = $request->input('project_id');
        $changeMilestone = $request->input('change_milestone');
        $listDesc = $request->input('milestone_desc');
        $milestoneTitle = ($changeMilestone != 2) ? $request->input('milestone_title'):$request->input('milestone_list');
        $milestoneStartDate = $request->input('milestone_start_date');
        $milestoneEndDate = $request->input('milestone_end_date');
        $taskNewId = [];

        /*return response()->json([
            'message' => 'warning',
            'message2' => 'changeTask='.$changeTask.'list_name='.$listTitle
        ]);*/
        $validator = Validator::make($request->all(),Milestone::$mainRules);
        if($validator->passes()) {

            // PROCESS ALL TASKS ADDED FOR THIS MILESTONE
            if(!empty($taskTitle)) {
                if (!empty($taskTitle) && !empty($taskStatus) && !empty($startDate) && !empty($endDate)) {



                    for ($i = 0; $i < count($taskTitle); $i++) {
                        $changeUserTbl = ($changeUser[$i] == Utility::P_USER) ? 'assigned_user' : 'temp_user';
                        $changeUserDbTbl = ($changeUser[$i] == Utility::P_USER) ? 'users' : 'temp_users';

                        $userType = ($user[$i] == '') ? '' : $changeUser[$i];
                        $dbDATA = [
                            'project_id' => $projectId,
                            'task' => $taskTitle[$i],
                            'task_desc' => Utility::checkEmptyArrayItem($taskDetails, $i, ''),
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
                    //END OF INSERTING TASK INTO DATABASE


                } else {
                    return response()->json([
                        'message' => 'warning',
                        'message2' => 'Please fill in all required task fields, Title,Status,Start date, End date'
                    ]);
                }

            }
            //END OF PROCESS ALL TASKS ADDED FOR THIS MILESTONE

            $createUpdate = ($changeMilestone == '2') ? 'updated_by' : 'created_by';
            if($changeMilestone == '2'){
                $listData = Milestone::firstRow('id',$milestoneTitle);
                $milestoneTitle = $listData->list_name;
            }

            $dbDATAList = [
                'milestone_name' => $milestoneTitle,
                'milestone_desc' => $listDesc,
                'project_id' => $projectId,
                'start_date' => Utility::standardDate($milestoneStartDate),
                'end_date' => Utility::standardDate($milestoneEndDate),
                'milestone_status' => $request->input('milestone_status'),
                'status' => Utility::STATUS_ACTIVE,
                $createUpdate => Auth::user()->id,
            ];

            $milestone = ($changeMilestone == '2') ? Milestone::defaultUpdate('id',$milestoneTitle,$dbDATAList) : Milestone::create($dbDATAList);
            $milestoneId = ($changeMilestone == '2') ? $request->input('milestone_list') : $milestone->id;

            //BEGIN OF INSERTING TASK LIST INTO MILESTONE ITEM TABLE
            if(!empty($taskList)){
                for($k=0;$k<count($taskList);$k++){
                    $dbDATA2 = [
                        'milestone_id' => $milestoneId,
                        'list_id' => Utility::checkEmptyArrayItem($taskList, $k, ''),
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];
                    if(Utility::checkEmptyArrayItem($taskList, $k, '') != ''){
                        MilestoneItems::create($dbDATA2);
                    }
                }
            }

            // ADD TASKS TO MILESTONE ITEMS TABLE
            if(!empty($taskNewId)) {
                foreach ($taskNewId as $taskId) {
                    $dbDATAList = [
                        'milestone_id' => $milestoneId,
                        'task_id' => $taskId,
                        'status' => Utility::STATUS_ACTIVE,
                        'created_by' => Auth::user()->id,
                    ];

                }

                MilestoneItems::create($dbDATAList);
            }

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
        $tasks = Milestone::firstRow('id',$request->input('dataId'));
        return view::make('milestone.edit_form')->with('edit',$tasks);

    }

    public function milestoneTaskList(Request $request)
    {
        //
        $tasks = MilestoneItems::specialColumns('milestone_id',$request->input('dataId'));
        $taskIds = [];
        $milestone = '';
        foreach($tasks as $t){
            $taskIds[] = $t->list_id;
            $milestone = $t->milestone->milestone_name;
        }
        $mainData = TaskList::massData('id',$taskIds);
        $this->countTaskItem($mainData);
        return view::make('milestone.task_list_form')->with('mainData',$mainData)
            ->with('milestone',$milestone);

    }

    public function milestoneTask(Request $request)
    {
        //
        $tasks = MilestoneItems::specialColumns('milestone_id',$request->input('dataId'));
        $taskIds = [];
        foreach($tasks as $t){
            $taskIds[] = $t->task_id;
        }
        $mainData = Task::massData('id',$taskIds);
        return view::make('milestone.task_form')->with('mainData',$mainData);

    }

    public function milestoneTaskListItem(Request $request)
    {
        //
        $tasks = TaskItems::specialColumns('list_id',$request->input('dataId'));
        $list = '';
        $taskIds = [];
        foreach($tasks as $t){
            $taskIds[] = $t->task_id;
            $list = $t->listItem->list_name;
        }
        $mainData = Task::massData('id',$taskIds);
        return view::make('milestone.milestone_item')->with('mainData',$mainData)
            ->with('listName',$list);

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

            $taskTitle = $request->input('milestone_title');
            $taskDetails = $request->input('milestone_desc');
            $startDate = $request->input('milestone_start_date');
            $endDate = $request->input('milestone_end_date');

            $dbDATA = [
                'milestone_name' => $taskTitle,
                'milestone_desc' => $taskDetails,
                'start_date' => Utility::standardDate($startDate),
                'end_date' => Utility::standardDate($endDate),
                'milestone_status' => $request->input('milestone_status'),
                'updated_by' => Auth::user()->id,
            ];

            Milestone::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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



        $taskItems = MilestoneItems::massData('milestone_id',$idArray);
        $taskArray = [];
        foreach ($taskItems as $task){
            $taskArray[] = $task->task_id;
        }

        $delete1 = Milestone::massUpdate('id',$idArray,$dbData);
        $delete2 = MilestoneItems::massUpdate('milestone_id',$idArray,$dbData);
        $delete3 = Task::massUpdate('id',$taskArray,$dbData);
        $delete4 = Timesheet::massUpdate('task_id',$taskArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

    public function destroyMilestoneTask(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];

        $delete2 = MilestoneItems::massUpdate('task_id',$idArray,$dbData);
        $delete3 = Task::massUpdate('id',$idArray,$dbData);
        $delete4 = Timesheet::massUpdate('task_id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);
    }

    public function destroyMilestoneList(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];

        $delete2 = MilestoneItems::massUpdate('list_id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);
    }

    public function countTaskItem($data){
        foreach($data as $d){
            $countTask = TaskItems::countData('list_id',$d->id);
            $d->count_task = $countTask;
        }
    }

    public function countTask($ndata){
        foreach($ndata as $d){
            $taskListArray = [];
            $taskArray = [];
            $bdata = MilestoneItems::specialColumns('milestone_id',$d->id);
            foreach($bdata as $data){
                if($data->list_id != 0 || $data->list_id != ''){
                    $taskListArray[] = $data->list_id;
                }
                if($data->task_id != 0 || $data->task_id != ''){
                    $taskArray[] = $data->task_id;
                }
            }


            $d->count_task = count($taskArray);
            $d->count_task_list = count($taskListArray);
        }
    }

}
