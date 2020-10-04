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
use App\model\TaskItems;
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

class ProjectReportController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        $mainData = Project::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('project_report.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('project_report.main_view')->with('mainData',$mainData);
        }

    }

    public function index2(Request $request, $id)
    {
        //
        //$req = new Request();
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);
        //print_r($project);exit();

        return view::make(Utility::authBlade('temp_user','project_report_single.main_view','project_report_single.main_view_temp'))
            ->with('item',$project);

    }

    public function indexTemp(Request $request, $id)
    {
        //
        //$req = new Request();
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        return view::make(Utility::authBlade('temp_user','project_report_single.main_view','project_report_single.main_view_temp'))
            ->with('item',$project);

    }

    public function searchReport(Request $request)
    {
        //
        /*$searchResultRules = [
            'project' => 'required',
            'report_type' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
        ];
        $validator = Validator::make($request->all(),$searchResultRules);
        if($validator->passes()) {*/

            $startDate = Utility::standardDate($request->input('start_date'));
            $endDate = Utility::standardDate($request->input('end_date'));
            $project = $request->input('project');
            $reportType = $request->input('report_type');
            $status = $request->input('status');
            $mainData = [];

            //PROCESS SEARCH IF SEARCH TYPE IS TASK
            if($reportType == 'task'){
                $priority = $request->input('priority');
                if($priority != '' && $status != ''){
                    $mainData = Task::specialColumnsDate5('project_id', $project, 'task_status', $status, 'task_priority', $priority, 'start_date', $startDate, 'end_date', $endDate);
                }
                if($priority != '' && $status == ''){
                    $mainData = Task::specialColumnsDate4('project_id', $project, 'task_priority', $priority, 'start_date', $startDate, 'end_date', $endDate);
                }
                if($priority == '' && $status != ''){
                    $mainData = Task::specialColumnsDate4('project_id', $project, 'task_status', $status, 'start_date', $startDate, 'end_date', $endDate);
                }
                if($priority == '' && $status == ''){
                    $mainData = Task::specialColumnsDate3('project_id', $project, 'start_date', $startDate, 'end_date', $endDate);
                }

            }

           /* //PROCESS SEARCH IF SEARCH TYPE IS TASK LIST
            if($reportType == 'list'){
                if($status == ''){
                    $mainData = TaskItems::specialColumnsDate3('tasks.project_id', $project, 'tasks.start_date', $startDate, 'task.end_date', $endDate);
                }
                if($status != ''){
                    $mainData = TaskItems::specialColumnsDate4('tasks.project_id', $project, 'task_items.list_status', $status, 'tasks.start_date', $startDate, 'tasks.end_date', $endDate);
                }

            }*/

            //PROCESS SEARCH IF SEARCH TYPE IS MILESTONE
            if($reportType == 'milestone'){
                if($status != ''){
                    $mainData = Milestone::specialColumnsDate4('project_id', $project, 'milestone_status', $status, 'start_date', $startDate, 'end_date', $endDate);
                }
                if($status == ''){
                    $mainData = Milestone::specialColumnsDate3('project_id', $project, 'start_date', $startDate, 'end_date', $endDate);
                }

            }



            return view::make('project_report.reload')->with('mainData',$mainData)->with('reportType',$reportType);

        /*}else{

            $errors = $validator->errors();
            return response()->json([
                'message2' => 'fail',
                'message' => $errors
            ]);

        }*/

    }

}
