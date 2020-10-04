<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\CrmSalesCycle;
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

class CrmSalesCycleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $mainData = CrmSalesCycle::paginateAllData();
        $this->processData($mainData);

        if ($request->ajax()) {
            return \Response::json(view::make('crm_sales_cycle.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('crm_sales_cycle.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),CrmSalesCycle::$mainRules);
        if($validator->passes()){

            $jsonStages = $request->input('stages');
            $decodeStages = json_decode($jsonStages);
            $stages = array_unique($decodeStages);

            $countData = CrmSalesCycle::countData('name',$request->input('name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                $dbDATA = [
                    'name' => ucfirst($request->input('name')),
                    'stages' => json_encode($stages),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                CrmSalesCycle::create($dbDATA);

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
        $mainData = CrmSalesCycle::firstRow('id',$request->input('dataId'));
        $this->processItemData($mainData);
        return view::make('crm_sales_cycle.edit_form')->with('edit',$mainData);

    }

    public function removeStage(Request $request){

        $editId = $request->input('dataId');
        $stageId = $request->input('param');
        $oldData = CrmSalesCycle::firstRow('id',$editId);
        $oldStages = json_decode($oldData->stages,true);


        //REMOVE USER FROM AN ARRAY
        if (($key = array_search($stageId, $oldStages)) != false) {
            unset($oldStages[$key]);
        }

        $stagesArrayToJson = json_encode($oldStages);
        $dbData = [
            'stages' => $stagesArrayToJson,
        ];
        $save = CrmSalesCycle::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message' => 'good',
            'message2' => 'Stage have been removed'
        ]);

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
        $validator = Validator::make($request->all(),CrmSalesCycle::$mainRulesEdit);
        if($validator->passes()) {
            $jsonStages = $request->input('stages');
            $decodeStages = json_decode($jsonStages);
            $stages = array_unique($decodeStages);

            $dbDATA = [
                'name' => ucfirst($request->input('name')),
                'stages' => json_encode($stages),
                'updated_by' => Auth::user()->id,
            ];
            $rowData = CrmSalesCycle::specialColumns('name', $request->input('name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    CrmSalesCycle::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                CrmSalesCycle::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

    public function searchData(Request $request)
    {

        $searchValue = $request->input('searchVar');
        //PROCESS SEARCH REQUEST
        $mainData = CrmSalesCycle::searchData('name',$searchValue);
        $this->processData($mainData);
        return view::make('crm_sales_cycle.search')->with('mainData',$mainData);

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

        $inactiveSalesCycle = [];
        $activeSalesCycle = [];

        foreach($all_id as $var){
            $salesTeamRequest = CrmSalesCycle::firstRow('id',$var);
            if($salesTeamRequest->created_by == Auth::user()->id || in_array(Auth::user()->id,Utility::TOP_USERS)){
                $inactiveSalesCycle[] = $var;
            }else{
                $activeSalesCycle[] = $var;
            }
        }

        $message = (count($inactiveSalesCycle) < 1) ? ' and '.count($activeSalesCycle).
            ' sales cycle was not created by you and cannot be deleted' : '';
        if(count($inactiveSalesCycle) > 0){


            $delete = CrmSalesCycle::massUpdate('id',$inactiveSalesCycle,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($inactiveSalesCycle).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($activeSalesCycle).' was not created by you and cannot be deleted',
                'message' => 'warning'
            ]);

        }

    }

    public function processData($data){
        foreach($data as $val){
            $stages = json_decode($val->stages,true);

            if(!empty($stages)){
                $fetchStages = CrmStages::massData('id',$stages);
                $val->stageAccess = $fetchStages;
                $val->stageArray = $stages;
            }else{
                $val->stageAccess = '';
            }

        }
    }

    public function processItemData($val){
        $stages = json_decode($val->stages,true);

        if(!empty($stages)){
            $fetchStages = CrmStages::massData('id',$stages);
            $val->stageAccess = $fetchStages;
        }else{
            $val->stageAccess = '';
        }

    }

}
