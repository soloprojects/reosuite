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
use App\Http\Requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __contstuct(){
        $this->middleware('auth');
        $this->middleware('auth:temp_user');
    }

    public function index(Request $request)
    {
        //
        //$req = new Request();
        $projectId = [];
        $checkUser = ProjectTeam::specialColumns('user_id',Utility::checkAuth('temp_user')->id);
        if(!empty($checkUser)){
            foreach($checkUser as $data){
                $projectId[] = $data->project_id;
            }
        }


        $mainData = (in_array(Utility::checkAuth('temp_user')->role,Utility::HR_MANAGEMENT)) ? Project::paginateAllData() : Project::massDataPaginate('id',$projectId) ;
        $billMethod = BillMethod::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','project.reload','project.reload'),
                array('mainData' => $mainData,'billMethod' => $billMethod))->render());

        }else{
            return view::make(Utility::authBlade('temp_user','project.main_view','project.main_view_temp'))
                ->with('mainData',$mainData)->with('billMethod',$billMethod);
        }

    }

    public function indexTemp(Request $request)
    {
        //
        //$req = new Request();
        $projectId = [];
        $checkUser = ProjectTeam::specialColumns('temp_user',Utility::checkAuth('temp_user')->id);
        if(!empty($checkUser)){
            foreach($checkUser as $data){
                $projectId[] = $data->project_id;
            }
        }

        $mainData = Project::massDataPaginate('id',$projectId);
        $billMethod = BillMethod::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','project.reload','project.reload'),
                array('mainData' => $mainData,'billMethod' => $billMethod))->render());

        }else{
            return view::make(Utility::authBlade('temp_user','project.main_view','project.main_view_temp'))
                ->with('mainData',$mainData)->with('billMethod',$billMethod);
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
        $validator = Validator::make($request->all(),Project::$mainRules);
        if($validator->passes()){

            $countData = Project::countData('project_name',$request->input('project_name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'project_name' => ucfirst($request->input('project_name')),
                    'project_desc' => ucfirst($request->input('project_description')),
                    'project_head' => $request->input('project_head'),
                    'start_date' => Utility::standardDate($request->input('start_date')),
                    'end_date' => Utility::standardDate($request->input('end_date')),
                    'bill_id' => $request->input('bill_method'),
                    'customer_id' => $request->input('customer'),
                    'project_status' => $request->input('project_status'),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                $pro = Project::create($dbDATA);

                $uid = Utility::generateUniqueId('project_team','unique_id');
                $dbDATA2 = [
                    'unique_id' => $uid,
                    'project_id' => $pro->id,
                    'user_id' => Auth::user()->id,
                    'project_access' => Utility::STATUS_ACTIVE,
                    'team_lead' => 0,
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                ProjectTeam::create($dbDATA2);


                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
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
        $dept = Project::firstRow('id',$request->input('dataId'));
        $billMethod = BillMethod::getAllData();
        return view::make('project.edit_form')->with('edit',$dept)->with('billMethod',$billMethod);

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
        $validator = Validator::make($request->all(),Project::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'project_name' => ucfirst($request->input('project_name')),
                'project_desc' => $request->input('project_description'),
                'project_head' => $request->input('project_head'),
                'start_date' => Utility::standardDate($request->input('start_date')),
                'end_date' => Utility::standardDate($request->input('end_date')),
                'bill_id' => $request->input('bill_method'),
                'customer_id' => $request->input('customer'),
                'project_status' => $request->input('project_status'),
                'updated_by' => Auth::user()->id
            ];
            $rowData = Project::specialColumns('project_name', $request->input('project_name'));
            $teamAssoc = ProjectTeam::specialColumns2('project_id',$request->input('edit_id'),'user_id',$request->input('project_head'));

            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    Project::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                    //CHECK WHEATHER PROJECT HEAD EXIST IN PROJECT TEAM, IF NOT ADD HIM/HER TO THE TEAM
                    if(empty($teamAssoc)){
                        $uid = Utility::generateUniqueId('project_team','unique_id');
                        $dbDATA2 = [
                            'unique_id' => $uid,
                            'project_id' => $request->input('edit_id'),
                            'user_id' => $request->input('project_head'),
                            'project_access' => Utility::STATUS_ACTIVE,
                            'team_lead' => 0,
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];
                        ProjectTeam::create($dbDATA2);
                    }

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);

                } else {
                    return response()->json([
                        'message' => 'good',
                        'message2' => 'Entry already exist, please try another entry'
                    ]);

                }

            } else{
                Project::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                //CHECK WHEATHER PROJECT HEAD EXIST IN PROJECT TEAM, IF NOT ADD HIM/HER TO THE TEAM
                if(empty($teamAssoc)){
                    $uid = Utility::generateUniqueId('project_team','unique_id');
                    $dbDATA2 = [
                        'unique_id' => $uid,
                        'project_id' => $request->input('edit_id'),
                        'user_id' => $request->input('project_head'),
                        'project_access' => Utility::STATUS_ACTIVE,
                        'team_lead' => 0,
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];
                    ProjectTeam::create($dbDATA2);
                }

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
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
     PROJECT ITEM
     */
    public function projectItem(Request $request, $id)
    {
        //
        $project = Project::firstRow('id',$id);
        $billMethod = BillMethod::getAllData();
        //print_r($project);exit();
        Utility::processProjectItem($project);
        return view::make(Utility::authBlade('temp_user','project.project_item','project.project_item_temp'))->with('item',$project)->with('billMethod',$billMethod);

    }

    public function projectItemTemp(Request $request, $id)
    {
        //
        $project = Project::firstRow('id',$id);
        $billMethod = BillMethod::getAllData();
        //print_r($project);exit();
        Utility::processProjectItem($project);
        return view::make(Utility::authBlade('temp_user','project.project_item','project.project_item_temp'))->with('item',$project)->with('billMethod',$billMethod);

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

        $nonController = [];
        foreach($idArray as $id){
        $projHead = Project::specialColumns2('id',$id,'project_head',Auth::user()->id);
            if(!empty($projHead)){
                $delete = Project::massUpdate('id',$idArray,$dbData);
                if($delete){
                $deleteTask = Project::massUpdate('project_id',$idArray,$dbData);
                $deleteTaskList = TaskList::massUpdate('project_id',$idArray,$dbData);
                $deleteMilestone = Milestone::massUpdate('project_id',$idArray,$dbData);
                $deleteTimesheet = TimeSheet::massUpdate('project_id',$idArray,$dbData);                
                $deleteProjectRequests = ProjectMemberRequest::massUpdate('project_id',$idArray,$dbData);
                }
            }else{
                $nonController[] = $id;
            }
        }

        $message = (count($nonController) < 1) ? 'Data deleted successfully' : 'Data deleted successfully, '.count($nonController).
        ' projects are not under your control and can\'t be deleted by you as you are not the project leader';


        return response()->json([
            'message2' => 'deleted',
            'message' => $message
        ]);

    }

}
