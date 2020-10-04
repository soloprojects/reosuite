<?php

namespace App\Http\Controllers;

use App\model\CrmStages;
use App\Helpers\Utility;
use App\model\CrmOpportunity;
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

class CrmStagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $mainData = CrmStages::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('crm_opportunity_stages.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('crm_opportunity_stages.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),CrmStages::$mainRules);
        if($validator->passes()){

            $countData = CrmStages::countData('name',$request->input('name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry/Stage already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'name' => ucfirst($request->input('name')),
                    'probability' => $request->input('probability'),
                    'stage' => $request->input('stage'),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                $pro = CrmStages::create($dbDATA);

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
        $dept = CrmStages::firstRow('id',$request->input('dataId'));
        return view::make('crm_opportunity_stages.edit_form')->with('edit',$dept);

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
        $validator = Validator::make($request->all(),CrmStages::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'name' => ucfirst($request->input('name')),
                'probability' => $request->input('probability'),
                'stage' => $request->input('stage'),
                'updated_by' => Auth::user()->id
            ];
            $rowData = CrmStages::specialColumns('stage', $request->input('stage'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    CrmStages::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);

                } else {
                    return response()->json([
                        'message' => 'good',
                        'message2' => 'Stage already exist, please try another stage'
                    ]);

                }

            } else{
                CrmStages::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

        $in_use = [];
        $unused = [];
        for($i=0;$i<count($all_id);$i++){
            $rowDataStage = CrmOpportunity::firstRow('stage_id',$all_id[$i]);
            if(!empty($rowDataStage)){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }

        $inactiveStage = [];
        $activeStage = [];

        foreach($in_use as $var){
            $stageRequest = CrmStages::firstRow('id',$var);
            if($stageRequest->created_by == Auth::user()->id || in_array(Auth::user()->id,Utility::TOP_USERS)){
                $inactiveStage[] = $var;
            }else{
                $activeStage[] = $var;
            }
        }

        $stageMessage = (count($inactiveStage) < 1) ? ', '.count($activeStage).
            ' opportunity stage(s) was not created by you and cannot be deleted' : '';

        $message = (count($unused) > 0) ? ' and '.count($unused).
            ' opportunity stage(s) has been used in various opportunities and cannot be deleted' : '';

        if(count($in_use) > 0 && count($inactiveStage) > 0){
            $delete = CrmStages::massUpdate('id',$in_use,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($in_use).' data(s) has been deleted'.$message.$stageMessage
            ]);

        }else{
            return  response()->json([
                'message2' => $message.$stageMessage,
                'message' => 'warning'
            ]);

        }


    }

}
