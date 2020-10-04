<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
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

class CrmNotesController extends Controller
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
        $mainData = CrmNotes::specialColumns2('opportunity_id',$opportunity,'stage_id',$stage);

        if ($request->ajax()) {
            return \Response::json(view::make('crm_notes.reload',array('mainData' => $mainData))->render());

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
        $validator = Validator::make($request->all(),CrmNotes::$mainRules);
        if($validator->passes()){

            $opportunity = $request->input('opportunity');
            $details = $request->input('details');
            $stage = $request->input('opportunity_stage');

                $dbDATA = [
                    'opportunity_id' => $opportunity,
                    'details' => $details,
                    'stage_id' => $stage,
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                CrmNotes::create($dbDATA);

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
        $mainData = CrmNotes::firstRow('id',$request->input('dataId'));
        return view::make('crm_notes.edit_form')->with('edit',$mainData)
            ->with('activityType',$activityType)->with('opportunityStage',$opportunityStage);

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
        $validator = Validator::make($request->all(),CrmNotes::$mainRulesEdit);
        if($validator->passes()) {
            $details = $request->input('details');

            $dbDATA = [
                'details' => $details,
                'updated_by' => Auth::user()->id,
            ];

                CrmNotes::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
        $deleteId = $request->input('dataId');
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];
        CrmNotes::defaultUpdate('id',$deleteId,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }


}
