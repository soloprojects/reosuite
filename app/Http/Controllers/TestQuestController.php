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
use App\model\Test;
use App\model\TestCategory;
use App\model\TestQuest;
use App\model\TestQuestAns;
use App\model\TestTempUserAns;
use App\model\TestUserAns;
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

class TestQuestController extends Controller
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
        $questCat = TestCategory::getAllData();
        $mainData = Test::getAllData();

        if ($request->ajax()) {


            return \Response::json(view::make('test_questions.reload',array('mainData' => $mainData,
                'questCat' => $questCat))->render());

        }else{
            return view::make('test_questions.main_view')->with('questCat',$questCat)
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
        $validator = Validator::make($request->all(),TestQuest::$mainRules);
        if($validator->passes()){

            /*$testResultTemp = TestTempUserAns::firstRow('test_id',$request->input('test'));
            $testResult = TestUserAns::firstRow('test_id',$request->input('test'));
            if(!empty($testResult) || !empty($testResultTemp)){
                return response()->json([
                    'message' => 'warning',
                    'message2' => 'This test has already been used and cannot accept more questions'
                ]);
            }*/

            $dbDATAQUEST = [
                'test_id' => $request->input('test'),
                'cat_id' => $request->input('test_category'),
                'question' => $request->input('question'),
                'text_type' => $request->input('text_type'),
                'created_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            $saveQuest = TestQuest::create($dbDATAQUEST);

            if($request->input('text_type') == '0') {   //DO FOLLOWING IF QUESTION HAVE ANSWER OPTIONS
                for ($i = 0; $i <= 5; $i++) {
                    if ($request->input('answer' . $i) != '') {

                        $correct = ($request->input('correct_answer') == $request->input('answer_type'.$i)) ? 1 : 0;
                        $dbDATA = [
                            'test_id' => $request->input('test'),
                            'cat_id' => $request->input('test_category'),
                            'quest_id' => $saveQuest->id,
                            'answer' => $request->input('answer' . $i),
                            'correct_status' => $correct,
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];
                        TestQuestAns::create($dbDATA);
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
        $validator = Validator::make($request->all(),TestQuestAns::$mainRules);
        if($validator->passes()) {

            $countAns = $request->input('countAns');
            $countExtraAns = $request->input('countExtraAns');
            $test = $request->input('test');
            $questionId = $request->input('question_id');
            $textType = $request->input('text_type');
            $category = $request->input('test_category');

            $dbDATAQUEST = [
                'cat_id' => $category,
                'question' => $request->input('question'),
                'updated_by' => Auth::user()->id,
            ];

            $saveQuest = TestQuest::defaultUpdate('id', $questionId, $dbDATAQUEST);


            if($textType == '0') {

                for ($i = 1; $i <= $countAns; $i++) {   //DO FOLLOWING FOR EXISTING ANSWER OPTIONS
                    $correct = ($request->input('correct_answer') == $request->input('answer_type'.$i)) ? 1 : 0;
                    if ($request->input('answer' . $i) != '') {
                        $dbDATA = [
                            'answer' => $request->input('answer' . $i),
                            'correct_status' => $correct,
                            'updated_by' => Auth::user()->id,
                        ];
                        TestQuestAns::defaultUpdate('id', $request->input('answer_id' . $i), ['correct_status' => 0]);
                        TestQuestAns::defaultUpdate('id', $request->input('answer_id' . $i), $dbDATA);
                    }else{
                        TestQuestAns::destroy($request->input('answer_id' . $i));
                    }
                }

                for ($i = 1; $i <= $countExtraAns; $i++) {   //DO FOLLOWING IF QUESTION HAVE EXTRA ANSWER OPTIONS
                    $newNum = $i+$countAns;
                    $correct = ($request->input('correct_answer') == $request->input('answer_type'.$i)) ? 1 : 0;
                    if ($request->input('answer' . $newNum) != '') {
                        $dbDATANEW = [
                            'test_id' => $test,
                            'cat_id' => $category,
                            'quest_id' => $request->input('question_id'),
                            'correct_status' => $correct,
                            'answer' => $request->input('new_answer' . $newNum),
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];
                        TestQuestAns::create($dbDATANEW);
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
    public function searchTest(Request $request)
    {
        //
        $validator = Validator::make($request->all(),TestQuest::$searchRules);
        if($validator->passes()) {

            $testId = $request->input('test');

            $mainData = Test::firstRow('id',$testId);
            $resultCheck = TestUserAns::firstRow('test_id',$testId);
            $resultCheckTemp = TestTempUserAns::firstRow('test_id',$testId);
            $resultExist = (!empty($resultCheck) || !empty($resultCheckTemp)) ? '1' : '0';
            $this->processItemData($mainData);
            $questCat = TestCategory::getAllData();

            return view::make('test_questions.reload')->with('mainData',$mainData)
                ->with('type','data')->with('resultCheck',$resultExist)
                ->with('questCat',$questCat);

        }else{
            $mainData = $validator->errors();
            return view::make('test_questions.reload')->with('mainData',$mainData)->with('type','error');
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
            $request = TestUserAns::firstRow('quest_id',$all_id[$i]);
            $requestTemp = TestTempUserAns::firstRow('quest_id',$all_id[$i]);
            if(empty($request) && empty($requestTemp)){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }


        $message = (count($in_use) > 0) ? ' and '.count($in_use).
            ' question(s) has been used for a test session and cannot be deleted' : '';

        $delete = TestQuestAns::destroy($unused);
        $delete1 = TestQuest::destroy($unused);

        return response()->json([
            'message2' => 'deleted',
            'message' => count($unused).' data(s) has been deleted'.$message
        ]);


    }


    public function processItemData($val){
        $testCategory = json_decode($val->all_category,true);
        if(!empty($testCategory)){
            $fetchCategory = TestCategory::massData('id',$testCategory);

            foreach($fetchCategory as $cat){
                $catQuest =  TestQuest::specialColumnsAsc2('test_id',$val->id,'cat_id',$cat->id);
                $questNum = 0;
                //LOOP THROUGH QUESTIONS TO GET ANSWERS AND NUMBER OF ADDITIONAL ANSWER COLUMNS NEEDED
                foreach($catQuest as $quest){
                    $questNum++;
                    $quest->quest_number = $questNum;   //GET THE QUESTION NUMBER FOR DISPLAY
                    //LOOP THROUGH ANSWERS AND CHECK FOR ADDITIONAL ANSWER COLUMNS BASED ON TEXT TYPE
                    $questAns = TestQuestAns::specialColumnsAsc('quest_id',$quest->id);

                    if($quest->text_type == 0){
                        $countAns = TestQuestAns::countData('quest_id', $quest->id);
                        $moreAnsColumnCount = ($countAns > 2) ? 2 : 3;
                        $quest->moreAnsColumnCount = $moreAnsColumnCount;   //ADD TO QUESTION NUMBER OF MORE ANSWER COLUMN OPTIONS
                        $quest->ans = $questAns;    //ADD ANSWERS TO EACH QUESTION
                        $quest->count_ans = $countAns;

                    }else{
                        $quest->ans = '';
                        $quest->moreAnsColumnCount = 0;
                    }
                }
                $cat->questions = $catQuest;  //ADD SELECTED PROCESSED QUESTIONS TO EACH DEPARTMENT
            }

            $val->category = $fetchCategory;
        }else{
            $val->category = '';
        }
    }

}
