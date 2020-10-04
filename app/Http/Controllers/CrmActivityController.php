<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\CrmActivity;
use App\model\CrmActivityType;
use App\model\CrmNotes;
use App\model\CrmStages;
use App\User;
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

class CrmActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $opportunity = $request->input('opportunity');
        $stage  = $request->input('opportunity_stage');
        $mainData = CrmActivity::specialColumns2('opportunity_id',$opportunity,'stage_id',$stage);

        if ($request->ajax()) {
            return \Response::json(view::make('crm_activity.reload',array('mainData' => $mainData))->render());

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
        $validator = Validator::make($request->all(),CrmActivity::$mainRules);
        if($validator->passes()){

            $opportunity = $request->input('opportunity');
            $subject = $request->input('subject');
            $dueDate = Utility::standardDate($request->input('due_date'));
            $details = $request->input('details');
            $activityType = $request->input('activity_type');
            $stage = $request->input('opportunity_stage');

            $dbDATA = [
                'opportunity_id' => $opportunity,
                'details' => $details,
                'stage_id' => $stage,
                'subject' => $subject,
                'due_date' => $dueDate,
                'activity_type' => $activityType,
                'created_by' => Auth::user()->id,
                'response_status' => Utility::ZERO,
                'status' => Utility::STATUS_ACTIVE
            ];
            CrmActivity::create($dbDATA);

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
        $opportunityStage = CrmStages::getAllData();
        $activityType = CrmActivityType::getAllData();
        $mainData = CrmActivity::firstRow('id',$request->input('dataId'));
        return view::make('crm_activity.edit_form')->with('edit',$mainData)
            ->with('activityType',$activityType)->with('opportunityStage',$opportunityStage);

    }


    public function activityResponseForm(Request $request)
    {
        //
        $helpDesk = CrmActivity::firstRow('id',$request->input('dataId'));
        return view::make('crm_activity.attach_form')->with('edit',$helpDesk);

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
        $validator = Validator::make($request->all(),CrmActivity::$mainRulesEdit);
        if($validator->passes()) {

            $subject = $request->input('subject');
            $dueDate = Utility::standardDate($request->input('due_date'));
            $details = $request->input('details');
            $activityType = $request->input('activity_type');

            $dbDATA = [
                'details' => $details,
                'subject' => $subject,
                'due_date' => $dueDate,
                'activity_type' => $activityType,
                'updated_by' => Auth::user()->id,
            ];
            CrmActivity::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

    public function activityResponse(Request $request)
    {
        //
        $validator = Validator::make($request->all(),CrmActivity::$responseRules);
        if($validator->passes()) {
            $editId = $request->input('edit_id');
            $response = $request->input('feedback');
            $responseDate = date("d-m-Y H:i:s");
            $activityData = CrmActivity::firstRow('id',$editId);
            $responseRate = Utility::dateTimeDiff($activityData->created_at,$responseDate);
            $dbData = [];
            if(empty($activityData->response_rate)) {
                $dbData = [
                    'response' => $response,
                    'response_rate' => $responseRate,
                    'response_status' => Utility::STATUS_ACTIVE,
                    'updated_by' => Utility::checkAuth('temp_user')->id,
                ];
            }else{
                $dbData = [
                    'response' => $response,
                    'response_status' => Utility::STATUS_ACTIVE,
                    'updated_by' => Utility::checkAuth('temp_user')->id,
                ];
            }

            CrmActivity::defaultUpdate('id', $editId, $dbData);

            return response()->json([
                'message' => 'saved',
                'message2' => 'Processed'
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
        $deleteId = $request->input('dataId');
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];
        CrmActivity::defaultUpdate('id',$deleteId,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }


}
