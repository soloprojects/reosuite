<?php

namespace App\Http\Controllers;

use App\model\Department;
use App\Helpers\Utility;
use App\model\Survey;
use App\model\SurveyTempUserAns;
use App\model\SurveyUserAns;
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

class SurveyController extends Controller
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
        $mainData = Survey::paginateAllData();
        $dept = Department::getAllData();
        $this->processData($mainData);

        if ($request->ajax()) {
            return \Response::json(view::make('survey.reload',array('mainData' => $mainData,
                'dept' => $dept))->render());

        }else{
            return view::make('survey.main_view')->with('mainData',$mainData)->with('dept',$dept);
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
        $validator = Validator::make($request->all(),Survey::$mainRules);
        if($validator->passes()){

            $deptArr = [];
            $allDept = $request->input('department');
            foreach($allDept as $dept){
                $deptArr[] = $dept;
            }
            $countData = Survey::countData('survey_name',$request->input('survey_name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                $dbDATA = [
                    'survey_name' => ucfirst($request->input('survey_name')),
                    'survey_desc' => ucfirst($request->input('survey_details')),
                    'all_dept' => json_encode($deptArr),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                Survey::create($dbDATA);

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
        $survey = Survey::firstRow('id',$request->input('dataId'));
        return view::make('survey.edit_form')->with('edit',$survey);

    }

    public function editDeptForm(Request $request)
    {
        //
        $survey = Survey::firstRow('id',$request->input('dataId'));
        $this->processItemData($survey);
        return view::make('survey.dept_form')->with('edit',$survey);

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
        $validator = Validator::make($request->all(),Survey::$mainRulesEdit);
        if($validator->passes()) {

            $dbDATA = [
                'survey_name' => ucfirst($request->input('survey_name')),
                'survey_desc' => ucfirst($request->input('survey_details')),
                'updated_by' => Auth::user()->id,
            ];
            $rowData = Survey::specialColumns('survey_name', $request->input('survey_name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    Survey::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                Survey::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
     * ADD/REMOVE FOR SURVEY DEPARTMENTS the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function modifyDept(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $status = $request->input('status');
        $editId = $request->input('param');
        $survey = Survey::firstRow('id',$editId);
        $surveyDept = json_decode($survey->all_dept,true);

        $newDept = ($status == '1') ? array_merge($surveyDept,$idArray) : array_diff($surveyDept,$idArray);

        $dbData = [
            'all_dept' => json_encode($newDept),
            'updated_by' => Auth::user()->id,
        ];
        $delete = Survey::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message2' => 'department(s) modified Successfully',
            'message' => 'saved'
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
            $request = SurveyUserAns::firstRow('survey_id',$all_id[$i]);
            $requestTemp = SurveyTempUserAns::firstRow('survey_id',$all_id[$i]);
            if(empty($request) && empty($requestTemp)){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }


        $message = (count($in_use) > 0) ? ' and '.count($in_use).
            ' survey(s) has been used for a survey session and cannot be deleted' : '';

        $delete = Survey::massUpdate('id',$unused,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => count($unused).' data(s) has been deleted'.$message
        ]);


    }

    public function processData($data){
        foreach($data as $val){
            $allDept = json_decode($val->all_dept,true);
            if(!empty($allDept)){
                $fetchDept = Department::massData('id',$allDept);
                $val->dept = $fetchDept;
            }else{
                $val->dept = '';
            }
        }
    }

    public function processItemData($val){
        $surveyDept = json_decode($val->all_dept,true);
        if(!empty($surveyDept)){
            $fetchDept = Department::massData('id',$surveyDept);
            $val->dept = $fetchDept;

            $allDept = Department::getAllData();
            $uniqueDept = Utility::arrayDiff($allDept,$surveyDept);
            $extraDept = Department::massData('id',$uniqueDept);
            $val->extra_dept = $extraDept;
        }else{
            $val->dept = '';
        }
    }

}
