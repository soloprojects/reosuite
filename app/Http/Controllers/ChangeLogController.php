<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\ChangeLogComment;
use App\model\ChangeLog;
use App\model\Project;
use App\User;
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

class ChangeLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        //
        //$req = new Request();
        $projectDropdown = Project::getAllData();
        $mainData = ChangeLog::paginateAllData();

        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','change_log.reload','change_log.reload'),array('mainData' => $mainData,
                'item' => $project,'projectDropdown' => $projectDropdown))->render());

        }
        return view::make(Utility::authBlade('temp_user','change_log.main_view','change_log.main_view_temp'))->with('mainData',$mainData)
            ->with('item',$project)->with('projectDropdown',$projectDropdown);

    }

    public function indexTemp(Request $request, $id)
    {
        //
        //$req = new Request();
        $projectDropdown = Project::getAllData();
        $mainData = ChangeLog::paginateAllData();

        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','change_log.reload','change_log.reload'),array('mainData' => $mainData,
                'item' => $project,'projectDropdown' => $projectDropdown))->render());

        }
        return view::make(Utility::authBlade('temp_user','change_log.main_view','change_log.main_view_temp'))->with('mainData',$mainData)
            ->with('item',$project)->with('projectDropdown',$projectDropdown);

    }

    public function changeView(Request $request, $id,$log_id)
    {
        //
        $mainData = ChangeLog::firstRow2('project_id',$id,'id',$log_id);
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);
        $this->logComments($mainData,$log_id);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','change_log.change_view_reload','change_log.change_view_reload'),array('mainData' => $mainData,
                'item' => $project))->render());

        }
        return view::make(Utility::authBlade('temp_user','change_log.change_view','change_log.change_view'))->with('mainData',$mainData)
            ->with('item',$project);

    }

    public function changeViewTemp(Request $request, $id,$log_id)
    {
        //
        $mainData = ChangeLog::firstRow2('project_id',$id,'id',$log_id);
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);
        $this->logComments($mainData,$log_id);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','change_log.change_view_reload','change_log.change_view_reload'),array('mainData' => $mainData,
                'item' => $project))->render());

        }
        return view::make(Utility::authBlade('temp_user','change_log.change_view','change_log.change_view_temp'))->with('mainData',$mainData)
            ->with('item',$project);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),ChangeLog::$mainRules);
        if($validator->passes()){


                $dbDATA = [
                    'project_id' => $request->input('project'),
                    'change_desc' => ucfirst($request->input('change_description')),
                    'priority' => ucfirst($request->input('priority')),
                    'change_status' => Utility::STATUS_ACTIVE,
                    'status' => Utility::STATUS_ACTIVE,
                    'created_by' => Utility::checkAuth('temp_user')->id,
                ];
                ChangeLog::create($dbDATA);

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

    public function comment(Request $request)
    {
        //
        $validator = Validator::make($request->all(),ChangeLogComment::$mainRules);
        if($validator->passes()){

            $userColumn = (Utility::authColumn('temp_user') == 'temp_user') ? 'temp_user' : 'user_id';

            $dbDATA = [
                'project_id' => $request->input('project'),
                'change_id' => $request->input('change_id'),
                $userColumn => Utility::checkAuth('temp_user')->id,
                'comment' => ucfirst($request->input('comment')),
                'status' => Utility::STATUS_ACTIVE,
                'created_by' => Utility::checkAuth('temp_user')->id,
            ];
            $newComment = ChangeLogComment::create($dbDATA);

            return view::make('change_log.change_view_reload')->with('data',$newComment);


        }

        return '';


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
        $changeLog = ChangeLog::firstRow('id',$request->input('dataId'));
        return view::make('change_log.edit_form')->with('edit',$changeLog);

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
        $validator = Validator::make($request->all(),ChangeLog::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'change_desc' => ucfirst($request->input('change_description')),
                'priority' => ucfirst($request->input('priority')),
                'updated_by' => Utility::checkAuth('temp_user')->id,
            ];

                ChangeLog::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
        $all_id = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];


            $delete = ChangeLog::massUpdate('id',$all_id,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($all_id).' data(s) has been deleted'
            ]);



    }

    public function logComments($log,$log_id){
        $comments = ChangeLogComment::specialColumns('change_id',$log_id);
        $log->allComments = $comments;
        return $log;
    }

}
