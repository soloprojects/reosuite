<?php

namespace App\Http\Controllers;

use App\model\Department;
use App\Helpers\Utility;
use App\model\Survey;
use App\model\SurveyAnsCat;
use App\model\SurveyQuest;
use App\model\SurveyQuestAns;
use App\model\SurveyQuestCat;
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

class SurveyQuestController extends Controller
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
        $questCat = SurveyQuestCat::getAllData();
        $ansCat = SurveyAnsCat::getAllData();
        $mainData = Survey::getAllData();

        if ($request->ajax()) {


            return \Response::json(view::make('survey_questions.reload',array('mainData' => $mainData,
                'questCat' => $questCat,'ansCat' => $ansCat))->render());

        }else{
            return view::make('survey_questions.main_view')->with('ansCat',$ansCat)->with('questCat',$questCat)
                ->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),SurveyQuest::$mainRules);
        if($validator->passes()){

            $surveyResultTemp = SurveyTempUserAns::firstRow('survey_id',$request->input('survey'));
            $surveyResult = SurveyUserAns::firstRow('survey_id',$request->input('survey'));
            if(!empty($surveyResult) || !empty($surveyResultTemp)){
                return response()->json([
                    'message' => 'warning',
                    'message2' => 'This survey has already been used and cannot accept more questions'
                ]);
            }

            $dbDATAQUEST = [
                'survey_id' => $request->input('survey'),
                'dept_id' => $request->input('department'),
                'cat_id' => $request->input('question_category'),
                'question' => $request->input('question'),
                'text_type' => $request->input('text_type'),
                'created_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            $saveQuest = SurveyQuest::create($dbDATAQUEST);

            if($request->input('text_type') == '0') {   //DO FOLLOWING IF QUESTION HAVE ANSWER OPTIONS
                for ($i = 0; $i <= 5; $i++) {
                    if ($request->input('answer' . $i) != '') {
                        $dbDATA = [
                            'survey_id' => $request->input('survey'),
                            'dept_id' => $request->input('department'),
                            'quest_id' => $saveQuest->id,
                            'ans_cat_id' => $request->input('answer' . $i),
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];
                        SurveyQuestAns::create($dbDATA);
                    }
                }
            }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $validator = Validator::make($request->all(),SurveyQuestAns::$mainRules);
        if($validator->passes()) {

            $countAns = $request->input('countAns');
            $countExtraAns = $request->input('countExtraAns');
            $survey = $request->input('survey');
            $questionId = $request->input('question_id');
            $textType = $request->input('text_type');
            $dept = $request->input('department');

            $dbDATAQUEST = [
                'cat_id' => $request->input('question_category'),
                'question' => $request->input('question'),
                'updated_by' => Auth::user()->id,
            ];
            $saveQuest = SurveyQuest::defaultUpdate('id', $questionId, $dbDATAQUEST);


            if($textType == '0') {

                for ($i = 0; $i <= $countAns; $i++) {   //DO FOLLOWING FOR EXISTING ANSWER OPTIONS
                    if ($request->input('answer' . $i) != '') {
                        $dbDATA = [
                            'ans_cat_id' => $request->input('answer' . $i),
                            'updated_by' => Auth::user()->id,
                        ];
                        SurveyQuestAns::defaultUpdate('id', $request->input('answer_id' . $i), $dbDATA);
                    }else{
                            SurveyQuestAns::destroy($request->input('answer_id' . $i));
                    }
                }

                for ($i = 0; $i <= $countExtraAns; $i++) {   //DO FOLLOWING IF QUESTION HAVE EXTRA ANSWER OPTIONS
                    if ($request->input('new_answer' . $i) != '') {
                        $dbDATANEW = [
                            'survey_id' => $survey,
                            'dept_id' => $dept,
                            'quest_id' => $request->input('question_id'),
                            'ans_cat_id' => $request->input('new_answer' . $i),
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];
                        SurveyQuestAns::create($dbDATANEW);
                    }
                }
            }

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
     * ADD/REMOVE FOR SURVEY DEPARTMENTS the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchSurvey(Request $request)
    {
        //
        $validator = Validator::make($request->all(),SurveyQuest::$searchRules);
        if($validator->passes()) {

            $surveyId = $request->input('survey');

            $mainData = Survey::firstRow('id',$surveyId);
            $resultCheck = SurveyUserAns::firstRow('survey_id',$surveyId);
            $resultCheckTemp = SurveyTempUserAns::firstRow('survey_id',$surveyId);
            $resultExist = (!empty($resultCheck) || !empty($resultCheckTemp)) ? '1' : '0';
            $this->processItemData($mainData);
            $questCat = SurveyQuestCat::getAllData();
            $ansCat = SurveyAnsCat::getAllData();

            return view::make('survey_questions.reload')->with('mainData',$mainData)
                ->with('type','data')->with('resultCheck',$resultExist)->with('ansCat',$ansCat)
                ->with('questCat',$questCat);

        }else{
            $mainData = $validator->errors();
            return view::make('survey_questions.reload')->with('mainData',$mainData)->with('type','error');
        }

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
            $request = SurveyUserAns::firstRow('quest_id',$all_id[$i]);
            $requestTemp = SurveyTempUserAns::firstRow('quest_id',$all_id[$i]);
            if(empty($request) && empty($requestTemp)){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }


        $message = (count($in_use) > 0) ? ' and '.count($in_use).
            ' question(s) has been used for a survey session and cannot be deleted' : '';

        $delete = SurveyQuestAns::destroy($unused);
        $delete1 = SurveyQuest::destroy($unused);

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

            foreach($fetchDept as $dept){
                $deptQuest =  SurveyQuest::specialColumnsAsc2('survey_id',$val->id,'dept_id',$dept->id);
                $questNum = 0;
                //LOOP THROUGH QUESTIONS TO GET ANSWERS AND NUMBER OF ADDITIONAL ANSWER COLUMNS NEEDED
                foreach($deptQuest as $quest){
                    $questNum++;
                    $quest->quest_number = $questNum;   //GET THE QUESTION NUMBER FOR DISPLAY
                    //LOOP THROUGH ANSWERS AND CHECK FOR ADDITIONAL ANSWER COLUMNS BASED ON TEXT TYPE
                    $questAns = SurveyQuestAns::specialColumnsAsc('quest_id',$quest->id);

                    if($quest->text_type == 0){
                        $countAns = SurveyQuestAns::countData('quest_id', $quest->id);
                        $moreAnsColumnCount = ($countAns > 2) ? 2 : 3;
                        $quest->moreAnsColumnCount = $moreAnsColumnCount;   //ADD TO QUESTION NUMBER OF MORE ANSWER COLUMN OPTIONS
                        $quest->ans = $questAns;    //ADD ANSWERS TO EACH QUESTION
                        $quest->count_ans = $countAns;

                    }else{
                        $quest->ans = '';
                        $quest->moreAnsColumnCount = 0;
                    }
                }
                $dept->questions = $deptQuest;  //ADD SELECTED PROCESSED QUESTIONS TO EACH DEPARTMENT
            }

            $val->dept = $fetchDept;
        }else{
            $val->dept = '';
        }
    }

}
