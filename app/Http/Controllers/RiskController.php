<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\Risk;
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

class RiskController extends Controller
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
        $mainData = Risk::paginateAllData();

        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','risk.reload','risk.reload'),array('mainData' => $mainData,
                'item' => $project))->render());

        }
        return view::make(Utility::authBlade('temp_user','risk.main_view','risk.main_view_temp'))->with('mainData',$mainData)
            ->with('item',$project);

    }

    public function indexTemp(Request $request, $id)
    {
        //
        //$req = new Request();
        $projectDropdown = Project::getAllData();
        $mainData = Risk::paginateAllData();

        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','risk.reload','risk.reload'),array('mainData' => $mainData,
                'item' => $project))->render());

        }
        return view::make(Utility::authBlade('temp_user','risk.main_view','risk.main_view_temp'))->with('mainData',$mainData)
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
        $validator = Validator::make($request->all(),Risk::$mainRules);
        if($validator->passes()){

            $dbDATA = [
                'project_id' => $request->input('project'),
                'risk_desc' => ucfirst($request->input('risk_description')),
                'probability' => ucfirst($request->input('probability')),
                'impact' => ucfirst($request->input('impact')),
                'detectability' => ucfirst($request->input('detectability')),
                'category' => ucfirst($request->input('category')),
                'trigger' => ucfirst($request->input('trigger')),
                'contingency_plan' => ucfirst($request->input('contingency_plan')),
                'risk_status' => Utility::STATUS_ACTIVE,
                'status' => Utility::STATUS_ACTIVE,
                'created_by' => Utility::checkAuth('temp_user')->id,
            ];
            Risk::create($dbDATA);

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
        $risk = Risk::firstRow('id',$request->input('dataId'));
        return view::make('risk.edit_form')->with('edit',$risk);

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
        $validator = Validator::make($request->all(),Risk::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'risk_desc' => ucfirst($request->input('risk_description')),
                'probability' => ucfirst($request->input('probability')),
                'impact' => ucfirst($request->input('impact')),
                'detectability' => ucfirst($request->input('detectability')),
                'importance' => ucfirst($request->input('importance')),
                'category' => ucfirst($request->input('category')),
                'trigger' => ucfirst($request->input('trigger')),
                'response' => ucfirst($request->input('response')),
                'contingency_plan' => ucfirst($request->input('contingency_plan')),
                'updated_by' => Utility::checkAuth('temp_user')->id,
            ];

            Risk::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

                $delete = Risk::massUpdate('id',$all_id,$dbData);

          return response()->json([
            'message2' => 'deleted',
            'message' => count($all_id).' data(s) has been deleted'
        ]);



    }


}
