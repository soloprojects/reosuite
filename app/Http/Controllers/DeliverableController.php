<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\DeliverableComment;
use App\model\Deliverable;
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

class DeliverableController extends Controller
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
        $mainData = Deliverable::paginateAllData();

        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','deliverable.reload','deliverable.reload'),array('mainData' => $mainData,
                'item' => $project,'projectDropdown' => $projectDropdown))->render());

        }
        return view::make(Utility::authBlade('temp_user','deliverable.main_view','deliverable.main_view_temp'))->with('mainData',$mainData)
            ->with('item',$project)->with('projectDropdown',$projectDropdown);

    }

    public function indexTemp(Request $request, $id)
    {
        //
        //$req = new Request();
        $projectDropdown = Project::getAllData();
        $mainData = Deliverable::paginateAllData();

        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','deliverable.reload','deliverable.reload'),array('mainData' => $mainData,
                'item' => $project,'projectDropdown' => $projectDropdown))->render());

        }
        return view::make(Utility::authBlade('temp_user','deliverable.main_view','deliverable.main_view_temp'))->with('mainData',$mainData)
            ->with('item',$project)->with('projectDropdown',$projectDropdown);

    }

    public function deliverableView(Request $request, $id,$log_id)
    {
        //
        $mainData = Deliverable::firstRow2('project_id',$id,'id',$log_id);
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);
        $this->logComments($mainData,$log_id);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','deliverable.change_view_reload','deliverable.change_view_reload'),array('mainData' => $mainData,
                'item' => $project))->render());

        }
        return view::make(Utility::authBlade('temp_user','deliverable.change_view','deliverable.change_view'))->with('mainData',$mainData)
            ->with('item',$project);

    }

    public function deliverableViewTemp(Request $request, $id,$log_id)
    {
        //
        $mainData = Deliverable::firstRow2('project_id',$id,'id',$log_id);
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);
        $this->logComments($mainData,$log_id);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','deliverable.change_view_reload','deliverable.change_view_reload'),array('mainData' => $mainData,
                'item' => $project))->render());

        }
        return view::make(Utility::authBlade('temp_user','deliverable.change_view','deliverable.change_view_temp'))->with('mainData',$mainData)
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
        $validator = Validator::make($request->all(),Deliverable::$mainRules);
        if($validator->passes()){


            $dbDATA = [
                'project_id' => $request->input('project'),
                'del_desc' => ucfirst($request->input('deliverable')),
                'del_status' => Utility::STATUS_ACTIVE,
                'status' => Utility::STATUS_ACTIVE,
                'created_by' => Utility::checkAuth('temp_user')->id,
            ];
            Deliverable::create($dbDATA);

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
        $validator = Validator::make($request->all(),DeliverableComment::$mainRules);
        if($validator->passes()){

            $userColumn = (Utility::authColumn('temp_user') == 'temp_user') ? 'temp_user' : 'user_id';

            $dbDATA = [
                'project_id' => $request->input('project'),
                'del_id' => $request->input('deliverable_id'),
                $userColumn => Utility::checkAuth('temp_user')->id,
                'comment' => ucfirst($request->input('comment')),
                'status' => Utility::STATUS_ACTIVE,
                'created_by' => Utility::checkAuth('temp_user')->id,
            ];
            $newComment = DeliverableComment::create($dbDATA);

            return view::make('deliverable.change_view_reload')->with('data',$newComment);


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
        $deliverable = Deliverable::firstRow('id',$request->input('dataId'));
        return view::make('deliverable.edit_form')->with('edit',$deliverable);

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
        $validator = Validator::make($request->all(),Deliverable::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'del_desc' => ucfirst($request->input('deliverable')),
                'updated_by' => Utility::checkAuth('temp_user')->id,
            ];

            Deliverable::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
        $all_id = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];


        $delete = Deliverable::massUpdate('id',$all_id,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => count($all_id).' data(s) has been deleted'
        ]);

    }

    public function logComments($log,$log_id){
        $comments = DeliverableComment::specialColumnsAsc('del_id',$log_id);
        $log->allComments = $comments;
        return $log;
    }

}
