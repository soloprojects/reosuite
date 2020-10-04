<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\AssumpConstraintsComment;
use App\model\AssumpConstraint;
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

class AssumpConstraintsController extends Controller
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
        $mainData = AssumpConstraint::paginateAllData();

        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','assump_constraint.reload','assump_constraint.reload'),array('mainData' => $mainData,
                'item' => $project,'projectDropdown' => $projectDropdown))->render());

        }
        return view::make(Utility::authBlade('temp_user','assump_constraint.main_view','assump_constraint.main_view_temp'))->with('mainData',$mainData)
            ->with('item',$project)->with('projectDropdown',$projectDropdown);

    }

    public function indexTemp(Request $request, $id)
    {
        //
        //$req = new Request();
        $projectDropdown = Project::getAllData();
        $mainData = AssumpConstraint::paginateAllData();

        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','assump_constraint.reload','assump_constraint.reload'),array('mainData' => $mainData,
                'item' => $project,'projectDropdown' => $projectDropdown))->render());

        }
        return view::make(Utility::authBlade('temp_user','assump_constraint.main_view','assump_constraint.main_view_temp'))->with('mainData',$mainData)
            ->with('item',$project)->with('projectDropdown',$projectDropdown);

    }

    public function assumpView(Request $request, $id,$log_id)
    {
        //
        $mainData = AssumpConstraint::firstRow2('project_id',$id,'id',$log_id);
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);
        $this->logComments($mainData,$log_id);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','assump_constraint.change_view_reload','assump_constraint.change_view_reload'),array('mainData' => $mainData,
                'item' => $project))->render());

        }
        return view::make(Utility::authBlade('temp_user','assump_constraint.change_view','assump_constraint.change_view'))->with('mainData',$mainData)
            ->with('item',$project);

    }

    public function assumpViewTemp(Request $request, $id,$log_id)
    {
        //
        $mainData = AssumpConstraint::firstRow('id',$log_id);
        //print_r($mainData.$log_id.$id); exit();
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);
        $this->logComments($mainData,$log_id);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','assump_constraint.change_view_reload','assump_constraint.change_view_reload'),array('mainData' => $mainData,
                'item' => $project))->render());

        }
        return view::make(Utility::authBlade('temp_user','assump_constraint.change_view','assump_constraint.change_view_temp'))->with('mainData',$mainData)
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
        $validator = Validator::make($request->all(),AssumpConstraint::$mainRules);
        if($validator->passes()){

            $userType = (Utility::authTable('temp_user') == 'temp_users') ? Utility::T_USER : Utility::P_USER;

            $dbDATA = [
                'project_id' => $request->input('project'),
                'assump_desc' => ucfirst($request->input('details')),
                'type' => ucfirst($request->input('type')),
                'assump_status' => Utility::STATUS_ACTIVE,
                'user_type' => $userType,
                'status' => Utility::STATUS_ACTIVE,
                'created_by' => Utility::checkAuth('temp_user')->id,
            ];
            AssumpConstraint::create($dbDATA);

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
        $validator = Validator::make($request->all(),AssumpConstraintsComment::$mainRules);
        if($validator->passes()){

            $userColumn = (Utility::authColumn('temp_user') == 'temp_user') ? 'temp_user' : 'user_id';

            $dbDATA = [
                'project_id' => $request->input('project'),
                'assump_id' => $request->input('assump_id'),
                $userColumn => Utility::checkAuth('temp_user')->id,
                'comment' => ucfirst($request->input('comment')),
                'status' => Utility::STATUS_ACTIVE,
                'created_by' => Utility::checkAuth('temp_user')->id,
            ];
            $newComment = AssumpConstraintsComment::create($dbDATA);

            return view::make('assump_constraint.change_view_reload')->with('data',$newComment);


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
        $assumpConstraint = AssumpConstraint::firstRow('id',$request->input('dataId'));
        return view::make('assump_constraint.edit_form')->with('edit',$assumpConstraint);

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
        $validator = Validator::make($request->all(),AssumpConstraint::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'assump_desc' => ucfirst($request->input('details')),
                'type' => ucfirst($request->input('type')),
                'updated_by' => Utility::checkAuth('temp_user')->id,
            ];

            AssumpConstraint::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

        $arr = [];
        $column = (Utility::authTable('temp_user') == 'temp_users') ? Utility::T_USER : Utility::P_USER;
        foreach($all_id as $id){
            $data = AssumpConstraint::firstRow2('id',$id,'user_type',$column);
            if(!empty($data)){
                $delete = AssumpConstraint::massUpdate('id',$all_id,$dbData);
            }else{
                $arr[] = $id;
            }
        }

        $message = (count($arr) >0) ? count($arr).' was not deleted and was not created by you' : '';
        return response()->json([
            'message2' => 'deleted',
            'message' => count($all_id).' data(s) has been deleted'.$message
        ]);

    }

    public function logComments($log,$log_id){
        $comments = AssumpConstraintsComment::specialColumnsAsc('assump_id',$log_id);
        $log->allComments = $comments;
        return $log;
    }

}
