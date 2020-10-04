<?php

namespace App\Http\Controllers;

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
use Auth;
use View;
use Validator;
use Input;
use Hash;
use DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class ProjectStatusController extends Controller
{
    //
    public function index(Request $request, $id)
    {
        //
        //$req = new Request();
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);
        $this->report($project);
        //print_r($project);exit();

        return view::make(Utility::authBlade('temp_user','project_status.main_view','project_status.main_view_temp'))
            ->with('item',$project);

    }

    public function indexTemp(Request $request, $id)
    {
        //
        //$req = new Request();
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);
        $this->report($project);

        return view::make(Utility::authBlade('temp_user','project_status.main_view','project_status.main_view_temp'))
            ->with('item',$project);

    }

    public function projectStatus(Request $request)
    {
        //
        //$req = new Request();
        $user = User::firstRow('id',Utility::checkAuth('temp_user')->id);
        $this->generalReport($user);
        //print_r($user);exit();

        return view::make('project_status.project_status')->with('item',$user);

    }

    public function arrangeStatus($status,$holdArr,$mainArr){
        $arrStatus = Utility::TASK_STATUS;
        foreach($arrStatus as $key => $var){
            $mainArr[$var] = [];
            $holdArr[$key] = [];
                if($key == $status){
                    $holdArr[$key][] = $status;
                    $mainArr[$var][] = $status;
                }

        }

        return $mainArr;
    }

    public function countStatus($statusArr){
        $newArr = [];
        foreach($statusArr as $key => $val){
            if(is_array($val)){
                $newArr[$key] = count($val);
            }else{
                $new[$key] = 0;
            }
        }
        return $newArr;
    }

    public function report($project){

        $column = (Utility::authColumn('temp_user') == 'temp_user') ? 'temp_user' : 'assigned_user';
        $task = Task::specialColumns('project_id',$project->id);
        $userTask = Task::specialColumns2('project_id',$project->id,$column,Utility::checkAuth('temp_user')->id);
        $taskList = TaskList::specialColumns('project_id',$project->id);
        $milestone = Milestone::specialColumns('project_id',$project->id);

        $openTask = []; $closedTask = []; $overdueTask = []; $todayTask = []; $taskStatus = [];
        $openUserTask = []; $closedUserTask = []; $overdueUserTask = []; $todayUserTask = []; $taskUserStatus = [];
        $openMilestone = []; $closedMilestone = []; $overdueMilestone = []; $todayMilestone = []; $milestoneStatus = [];
        $openList = []; $closedList = []; $overdueList = []; $todayList = []; $listStatus = [];

        $statusOpen = [1,2,5]; //KEY FROM TASK STATUS
        $statusClosed = 3; $currDate = date('Y-m-d');

        $taskHoldArr = []; $taskMainArr = []; $listHoldArr = []; $listMainArr = []; $milestoneHoldArr = []; $milestoneMainArr = [];
        $taskUserHoldArr = []; $taskUserMainArr = []; $arrStatus = Utility::TASK_STATUS;

        foreach($task as $val){

            foreach($arrStatus as $key => $var){
                if($key == $val->task_status){
                    $taskHoldArr[$key][] = $val->task_status;
                    $taskMainArr[$var][] = $val->task_status;
                }
            }

            if(in_array($val->task_status,$statusOpen)){
                $openTask[] = $val->task_status;
            }
            if($val->task_status == $statusClosed){
                $closedTask[] = $val->task_status;
            }
            if($currDate > $val->end_date && $val->task_status != $statusClosed){
                $overdueTask[] = $val->end_date;
            }
            if($currDate <= $val->end_date && $val->task_status != $statusClosed){
                $todayTask[] = $currDate;
            }

        }

        foreach($userTask as $val){

            foreach($arrStatus as $key => $var){
                if($key == $val->task_status){
                    $taskUserHoldArr[$key][] = $val->task_status;
                    $taskUserMainArr[$var][] = $val->task_status;
                }
            }

            if(in_array($val->task_status,$statusOpen)){
                $openUserTask[] = $val->task_status;
        }
            if($val->task_status == $statusClosed){
                $closedUserTask[] = $val->task_status;
            }
            if($currDate > $val->end_date && $val->task_status != $statusClosed){
                $overdueUserTask[] = $val->end_date;
            }
            if($currDate <= $val->end_date && $val->task_status != $statusClosed){
                $todayUserTask[] = $currDate;
            }

        }

        foreach($taskList as $val){

            foreach($arrStatus as $key => $var){
                if($key == $val->list_status){
                    $listHoldArr[$key][] = $val->list_status;
                    $listMainArr[$var][] = $val->list_status;
                }
            }

            if(in_array($val->list_status,$statusOpen)){
                $openList[] = $val->list_status;
            }
            if($val->list_status == $statusClosed){
                $closedList[] = $val->list_status;
            }
            if($currDate > $val->end_date && $val->list_status != $statusClosed){
                $overdueList[] = $val->end_date;
            }
            if($currDate <= $val->end_date && $val->list_status != $statusClosed){
                $todayList[] = $currDate;
            }
        }

        foreach($milestone as $val){

            foreach($arrStatus as $key => $var){
                if($key == $val->milestone_status){
                    $milestoneHoldArr[$key][] = $val->milestone_status;
                    $milestoneMainArr[$var][] = $val->milestone_status;
                }
            }

            if(in_array($val->milestone_status,$statusOpen)){
                $openMilestone[] = $val->milestone_status;
            }
            if($val->milestone_status == $statusClosed){
                $closedMilestone[] = $val->milestone_status;
            }
            if($currDate > $val->end_date && $val->milestone_status != $statusClosed){
                $overdueMilestone[] = $val->end_date;
            }
            if($currDate <= $val->end_date && $val->milestone_status != $statusClosed){
                $todayMilestone[] = $currDate;
            }
        }

            $project->openTask = count($openTask);
            $project->closedTask = count($closedTask);
            $project->taskStatus = $this->countStatus($taskMainArr);
            $project->overdueTask = count($overdueTask);
            $project->todayTask = count($todayTask);
            $project->totalTask = $task->count();

            $project->openUserTask = count($openUserTask);
            $project->closedUserTask = count($closedUserTask);
            $project->taskUserStatus = $this->countStatus($taskUserMainArr);
            $project->overdueUserTask = count($overdueUserTask);
            $project->todayUserTask = count($todayUserTask);
            $project->totalUserTask = $task->count();

            $project->openList = count($openList);
            $project->closedList = count($closedList);
            $project->listStatus = $this->countStatus($listMainArr);
            $project->overdueList = count($overdueList);
            $project->todayList = count($todayList);
            $project->totalList = $taskList->count();

            $project->openMilestone = count($openMilestone);
            $project->closedMilestone = count($closedMilestone);
            $project->milestoneStatus = $this->countStatus($milestoneMainArr);
            $project->overdueMilestone = count($overdueMilestone);
            $project->todayMilestone = count($todayMilestone);
            $project->totalMilestone = $milestone->count();


    }

    public function generalReport($project){

        $column = (Utility::authColumn('temp_user') == 'temp_user') ? 'temp_user' : 'assigned_user';
        $task = Task::getAllData();
        $userTask = Task::specialColumns($column,Utility::checkAuth('temp_user')->id);
        $taskList = TaskList::getAllData();
        $milestone = Milestone::getAllData();
        $projectData = Project::getAllData();

        $openTask = []; $closedTask = []; $overdueTask = []; $todayTask = []; $taskStatus = [];
        $openProject = []; $closedProject = []; $overdueProject = []; $todayProject = []; $ProjectStatus = [];
        $openUserTask = []; $closedUserTask = []; $overdueUserTask = []; $todayUserTask = []; $taskUserStatus = [];
        $openMilestone = []; $closedMilestone = []; $overdueMilestone = []; $todayMilestone = []; $milestoneStatus = [];
        $openList = []; $closedList = []; $overdueList = []; $todayList = []; $listStatus = [];

        $statusOpen = [1,2,5]; //KEY FROM TASK STATUS
        $statusClosed = 3; $currDate = date('Y-m-d');

        $taskHoldArr = []; $taskMainArr = []; $listHoldArr = []; $listMainArr = []; $milestoneHoldArr = []; $milestoneMainArr = [];
        $taskUserHoldArr = []; $taskUserMainArr = []; $projectHoldArr = []; $projectMainArr = []; $arrStatus = Utility::TASK_STATUS;

        foreach($projectData as $val){

            foreach($arrStatus as $key => $var){
                if($key == $val->project_status){
                    $projectHoldArr[$key][] = $val->project_status;
                    $projectMainArr[$var][] = $val->project_status;
                }
            }

            if(in_array($val->project_status,$statusOpen)){
                $openProject[] = $val->project_status;
            }
            if($val->project_status == $statusClosed){
                $closedProject[] = $val->project_status;
            }
            if($currDate > $val->end_date){
                $overdueProject[] = $val->end_date;
            }
            if($currDate <= $val->end_date && $val->project_status != $statusClosed){
                $todayProject[] = $currDate;
            }

        }

        foreach($task as $val){

            foreach($arrStatus as $key => $var){
                if($key == $val->task_status){
                    $taskHoldArr[$key][] = $val->task_status;
                    $taskMainArr[$var][] = $val->task_status;
                }
            }

            if(in_array($val->task_status,$statusOpen)){
                $openTask[] = $val->task_status;
            }
            if($val->task_status == $statusClosed){
                $closedTask[] = $val->task_status;
            }
            if($currDate > $val->end_date){
                $overdueTask[] = $val->end_date;
            }
            if($currDate <= $val->end_date && $val->task_status != $statusClosed){
                $todayTask[] = $currDate;
            }

        }

        foreach($userTask as $val){

            foreach($arrStatus as $key => $var){
                if($key == $val->task_status){
                    $taskUserHoldArr[$key][] = $val->task_status;
                    $taskUserMainArr[$var][] = $val->task_status;
                }
            }

            if(in_array($val->task_status,$statusOpen)){
                $openUserTask[] = $val->task_status;
            }
            if($val->task_status == $statusClosed){
                $closedUserTask[] = $val->task_status;
            }
            if($currDate > $val->end_date){
                $overdueUserTask[] = $val->end_date;
            }
            if($currDate <= $val->end_date && $val->task_status != $statusClosed){
                $todayUserTask[] = $currDate;
            }

        }

        foreach($taskList as $val){

            foreach($arrStatus as $key => $var){
                if($key == $val->list_status){
                    $listHoldArr[$key][] = $val->list_status;
                    $listMainArr[$var][] = $val->list_status;
                }
            }

            if(in_array($val->list_status,$statusOpen)){
                $openList[] = $val->list_status;
            }
            if($val->list_status == $statusClosed){
                $closedList[] = $val->list_status;
            }
            if($currDate > $val->end_date){
                $overdueList[] = $val->end_date;
            }
            if($currDate <= $val->end_date && $val->list_status != $statusClosed){
                $todayList[] = $currDate;
            }
        }

        foreach($milestone as $val){

            foreach($arrStatus as $key => $var){
                if($key == $val->milestone_status){
                    $milestoneHoldArr[$key][] = $val->milestone_status;
                    $milestoneMainArr[$var][] = $val->milestone_status;
                }
            }

            if(in_array($val->milestone_status,$statusOpen)){
                $openMilestone[] = $val->milestone_status;
            }
            if($val->milestone_status == $statusClosed){
                $closedMilestone[] = $val->milestone_status;
            }
            if($currDate > $val->end_date){
                $overdueMilestone[] = $val->end_date;
            }
            if($currDate <= $val->end_date && $val->list_status != $statusClosed){
                $todayMilestone[] = $currDate;
            }
        }

        $project->openTask = count($openTask);
        $project->closedTask = count($closedTask);
        $project->taskStatus = $this->countStatus($taskMainArr);
        $project->overdueTask = count($overdueTask);
        $project->todayTask = count($todayTask);
        $project->totalTask = $task->count();

        $project->openUserTask = count($openUserTask);
        $project->closedUserTask = count($closedUserTask);
        $project->taskUserStatus = $this->countStatus($taskUserMainArr);
        $project->overdueUserTask = count($overdueUserTask);
        $project->todayUserTask = count($todayUserTask);
        $project->totalUserTask = $task->count();

        $project->openList = count($openList);
        $project->closedList = count($closedList);
        $project->listStatus = $this->countStatus($listMainArr);
        $project->overdueList = count($overdueList);
        $project->todayList = count($todayList);
        $project->totalList = $taskList->count();

        $project->openMilestone = count($openMilestone);
        $project->closedMilestone = count($closedMilestone);
        $project->milestoneStatus = $this->countStatus($milestoneMainArr);
        $project->overdueMilestone = count($overdueMilestone);
        $project->todayMilestone = count($todayMilestone);
        $project->totalMilestone = $milestone->count();

        $project->openProject = count($openProject);
        $project->closedProject = count($closedProject);
        $project->projectStatus = $this->countStatus($projectMainArr);
        $project->overdueProject = count($overdueProject);
        $project->todayProject = count($todayProject);
        $project->totalProject = $projectData->count();


    }


}
