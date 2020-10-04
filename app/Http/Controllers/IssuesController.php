<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\Issues;
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

class IssuesController extends Controller
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
        $mainData = Issues::paginateAllData();

        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','issues.reload','issues.reload'),array('mainData' => $mainData,
                'item' => $project))->render());

        }
        return view::make(Utility::authBlade('temp_user','issues.main_view','issues.main_view_temp'))->with('mainData',$mainData)
            ->with('item',$project);

    }

    public function indexTemp(Request $request, $id)
    {
        //
        //$req = new Request();
        $projectDropdown = Project::getAllData();
        $mainData = Issues::paginateAllData();

        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','issues.reload','issues.reload'),array('mainData' => $mainData,
                'item' => $project))->render());

        }
        return view::make(Utility::authBlade('temp_user','issues.main_view','issues.main_view_temp'))->with('mainData',$mainData)
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
        $validator = Validator::make($request->all(),Issues::$mainRules);
        if($validator->passes()){

            $userType = (Utility::authTable('temp_user') == 'temp_users') ? Utility::T_USER : Utility::P_USER;
            $dbDATA = [
                'project_id' => $request->input('project'),
                'issue_desc' => ucfirst($request->input('issue_description')),
                'impact' => ucfirst($request->input('impact')),
                'resolution' => ucfirst($request->input('resolution')),
                'user_type' => $userType,
                'importance' => ucfirst($request->input('importance')),
                'issue_status' => Utility::STATUS_ACTIVE,
                'status' => Utility::STATUS_ACTIVE,
                'created_by' => Utility::checkAuth('temp_user')->id,
            ];
            Issues::create($dbDATA);

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
        $issues = Issues::firstRow('id',$request->input('dataId'));
        return view::make('issues.edit_form')->with('edit',$issues);

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
        $validator = Validator::make($request->all(),Issues::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'issue_desc' => ucfirst($request->input('issue_description')),
                'impact' => ucfirst($request->input('impact')),
                'resolution' => ucfirst($request->input('resolution')),
                'importance' => ucfirst($request->input('importance')),
                'updated_by' => Utility::checkAuth('temp_user')->id,
            ];

            Issues::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
            $data = Issues::firstRow2('id',$id,'user_type',$column);
            if(!empty($data)){
                $delete = Issues::massUpdate('id',$all_id,$dbData);
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


}
