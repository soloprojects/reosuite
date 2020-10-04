<?php

namespace App\Http\Controllers;

use App\model\Department;
use App\Helpers\Utility;
use App\model\Survey;
use App\model\SurveyAnsCat;
use App\model\SurveyQuest;
use App\model\SurveyQuestAns;
use App\model\SurveyQuestCat;
use App\model\SurveySession;
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

class SurveyResultController extends Controller
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
        $mainData = SurveySession::getAllData();

        if ($request->ajax()) {

            return \Response::json(view::make('survey_result.reload',array('mainData' => $mainData,))->render());

        }else{
            return view::make('survey_result.main_view')->with('mainData',$mainData);
        }

    }

    public function surveyStatements(Request $request)
    {
        //
        $mainData = [];
        if($request->input('param2') == 'temp_user'){
            $mainData = SurveyTempUserAns::specialColumns2('quest_id',$request->input('dataId'),'session_id',$request->input('param1'));
        }else{
            $mainData = SurveyUserAns::specialColumns2('quest_id',$request->input('dataId'),'session_id',$request->input('param1'));
        }

        return view::make('survey_result.text_preview')->with('mainData',$mainData);

    }

    public function surveyParticipants(Request $request)
    {
        //
        $mainData = [];
        if($request->input('param2') == 'temp_user'){
            $mainData = SurveyTempUserAns::specialColumns2('quest_id',$request->input('dataId'),'session_id',$request->input('param1'));
        }else{
            $mainData = SurveyUserAns::specialColumns2('quest_id',$request->input('dataId'),'session_id',$request->input('param1'));
        }

        return view::make('survey_result.participant_preview')->with('mainData',$mainData);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


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
       $searchResultRules = [
            'session' => 'required',
           'participant' => 'required',
    ];
        $validator = Validator::make($request->all(),$searchResultRules);
        if($validator->passes()) {

            $surveyId = $request->input('survey');
            $sessionId = $request->input('session');
            $participant = $request->input('participant');

            $session = SurveySession::firstRow('id',$sessionId);
            $mainData = Survey::firstRow('id',$session->survey_id);
            if($participant == 'external'){
                $this->processItemDataExt($mainData,$sessionId);
            }else{
                $this->processItemData($mainData,$sessionId);
            }


            return view::make('survey_result.reload')->with('mainData',$mainData)
                ->with('type','data');

        }else{
            $mainData = $validator->errors();
            return view::make('survey_result.reload')->with('mainData',$mainData)->with('type','error');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function processItemData($val,$session){
        $surveyDept = json_decode($val->all_dept,true);


        if(!empty($surveyDept)){
            $fetchDept = Department::massData('id',$surveyDept);
            $fetchDept2 = Department::massData('id',$surveyDept);
            $peopleId = [];
            $peopleData = SurveyUserAns::specialColumnsUserId('session_id',$session);
            foreach($peopleData as $p){
                $peopleId[] = $p->user_id;
            }
            $uniqueUserId = array_unique($peopleId);
            $sessionPeople = User::massData('id',$uniqueUserId);

            foreach($fetchDept as $dept){
                $deptTotalScore = [];
                $questCatArr = [];
                $deptQuest =  SurveyQuest::specialColumnsAsc2('survey_id',$val->id,'dept_id',$dept->id);
                foreach($deptQuest as $questCat){
                    $questCatArr[] = $questCat->cat_id;
                }

                $questNum = 0;
                $questCatId = array_unique($questCatArr);
                $questionCategory = SurveyQuestCat::massDataAsc('id',$questCatId);
                foreach($questionCategory as $catId){

                    $ansScoreCatArr = [];
                    $question = SurveyQuest::specialColumnsAsc3('survey_id',$val->id,'cat_id',$catId->id,'dept_id',$dept->id);
                    //LOOP THROUGH QUESTIONS TO GET ANSWERS
                    foreach($question as $quest){

                        $ansScoreArr = [];
                        $questNum++;

                        $quest->quest_number = $questNum;   //GET THE QUESTION NUMBER FOR DISPLAY
                        //LOOP THROUGH ANSWERS AND CHECK FOR ADDITIONAL ANSWER COLUMNS BASED ON TEXT TYPE
                        $questAns = SurveyQuestAns::specialColumnsAsc('quest_id',$quest->id);
                        $leadingScore = '';

                            if($quest->text_type == 0){

                                $people = Utility::countData3('survey_user_ans','session_id',$session,'quest_id',$quest->id,'dept_id',$dept->id);
                                $quest->countPeople = $people;

                                foreach($questAns as $ans){
                                $countUserAns = Utility::countData3('survey_user_ans','ans_id',$ans->id,'session_id',$session,'dept_id',$dept->id);
                                $userAnsPerct = ($people == 0) ? $countUserAns*100 : round(($countUserAns/$people)*100);
                                $ans->userAnsPerct = $userAnsPerct;
                                $ans->countUserAns = $countUserAns;
                                $ans->userAnsRatioToPeople = $countUserAns.'/'.$people;
                                    if($countUserAns >0){
                                        $ansScoreArr[$ans->ansCat->rating] = $userAnsPerct;
                                    }

                                }
                                $leadingScore = Utility::arrHighestScoreSurvey($ansScoreArr);

                            }else{

                            }
                        $ansScoreCatArr [] = $leadingScore;
                        $quest->leadingScore = $leadingScore;
                        $quest->ans = $questAns;    //ADD ANSWERS TO EACH QUESTION

                    }

                    $score = (array_sum($ansScoreCatArr)*100);
                    $catScore = ($score != 0) ? round(($score/(count($ansScoreCatArr)*100))) : 0;
                    $catId->catScore = $catScore;
                    $catId->question = $question;
                    $deptTotalScore[] = round(($catScore*$catId->rating)/100);


                }

                $dept->questionCategory = $questionCategory;  //ADD SELECTED PROCESSED QUESTIONS TO EACH DEPARTMENT
                $dept->totalScore = array_sum($deptTotalScore);

            }

            $val->dept = $fetchDept;
            $val->sessionId = $session;
            $val->participantType = 'user';

            foreach($fetchDept2 as $deptAns){
                $questCatArr2 = [];
                $ansCatArr = [];

                $deptQuest =  SurveyQuestAns::specialColumns2('survey_id',$val->id,'dept_id',$deptAns->id);
                foreach($deptQuest as $questCat){
                    $ansCatArr[] = $questCat->ans_cat_id;
                }
                $deptQuest =  SurveyQuest::specialColumnsAsc2('survey_id',$val->id,'dept_id',$deptAns->id);
                foreach($deptQuest as $questCat){
                    $questCatArr2[] = $questCat->cat_id;
                }

                $questCatId = array_unique($questCatArr2);
                $questionCategory = SurveyQuestCat::massData('id',$questCatId);

                $ansCatId = array_unique($ansCatArr);
                $answerCategory = SurveyAnsCat::massData('id',$ansCatId);
                foreach($questionCategory as $catId){

                    //$question = SurveyQuest::massDataConditionAsc('survey_id',$val->id,'cat_id',$catId->id);
                    //$countQuestCatAns = Utility::countData3(Utility::authSurveyTable('temp_user'),'session_id',$session,'quest_cat_id',$catId->id,'dept_id',$deptAns->id);
                    $countQuestCat = Utility::specialColumns3(Utility::authSurveyTable('temp_user'),'session_id',$session,'quest_cat_id',$catId->id,'dept_id',$deptAns->id);
                    //$countQuestCatAns = $countQuestCat->count();
                    $quCat = [];
                    $quCatOptionType = [];
                    $quOptionType = [];
                    foreach($countQuestCat as $qu){
                        if($qu->text_type == '0'){
                            $quCatOptionType[] = $qu->quest_id;
                        }
                        if($qu->text_type == '0'){
                            $quOptionType[] = $qu->quest_id;
                        }

                        $quCat[] = $qu->quest_id;
                    }
                    $countQuestCatAns = count($quOptionType);  //COUNT ALL ANSWERS FROM USERS FOR THIS QUESTION CATEGORY WITH OPTION TYPE
                    $questCatNum = array_unique($quCat);    //COUNT NUMBER OF QUESTIONS IN CATEGORY
                    $questCatNumOption = array_unique($quCatOptionType);    //COUNT NUMBER OF QUESTIONS WITH OPTIONS IN CATEGORY

                    $catId->questCatNum = count($questCatNum);
                    $catId->questCatNumOption = count($questCatNumOption);
                    $catId->countQuestCatAns = $countQuestCatAns;

                    //LOOP THROUGH QUESTIONS TO GET ANSWERS
                    foreach($answerCategory as $ansCat){
                        $countQuestCatAnsCat = Utility::countData4(Utility::authSurveyTable('temp_user'),'session_id',$session,'quest_cat_id',$catId->id,'dept_id',$deptAns->id,'ans_cat_id',$ansCat->id);

                        $ansCat->ansCatPerct = ($countQuestCatAnsCat == 0) ? 0 : round(($countQuestCatAnsCat/$countQuestCatAns)*100);
                        $ansCat->countQuestCatAnsCat = $countQuestCatAnsCat; //COUNT THE NUMBER OF ANSWER CATEGORY
                    }

                    $catId->answerCategory = $answerCategory;
                }

                $deptAns->questionCategory = $questionCategory;  //ADD SELECTED PROCESSED QUESTION CATEGORIES TO EACH DEPARTMENT
            }
            $val->dept2 = $fetchDept2;
            $val->participants = $sessionPeople;

        }else{
            $val->dept = [];
        }
    }

    public function processItemDataExt($val,$session){
        $surveyDept = json_decode($val->all_dept,true);


        if(!empty($surveyDept)){
            $fetchDept = Department::massData('id',$surveyDept);
            $fetchDept2 = Department::massData('id',$surveyDept);
            $peopleId = [];
            $peopleData = SurveyTempUserAns::specialColumnsUserId('session_id',$session);
            foreach($peopleData as $p){
                $peopleId[] = $p->user_id;
            }
            $uniqueUserId = array_unique($peopleId);
            $sessionPeople = User::massData('id',$uniqueUserId);

            foreach($fetchDept as $dept){
                $deptTotalScore = [];
                $questCatArr = [];
                $deptQuest =  SurveyQuest::specialColumnsAsc2('survey_id',$val->id,'dept_id',$dept->id);
                foreach($deptQuest as $questCat){
                    $questCatArr[] = $questCat->cat_id;
                }

                $questNum = 0;
                $questCatId = array_unique($questCatArr);
                $questionCategory = SurveyQuestCat::massData('id',$questCatId);
                foreach($questionCategory as $catId){

                    $ansScoreCatArr = [];
                    $question = SurveyQuest::specialColumnsAsc3('survey_id',$val->id,'cat_id',$catId->id,'dept_id',$dept->id);
                    //LOOP THROUGH QUESTIONS TO GET ANSWERS
                    foreach($question as $quest){

                        $ansScoreArr = [];
                        $questNum++;

                        $quest->quest_number = $questNum;   //GET THE QUESTION NUMBER FOR DISPLAY
                        //LOOP THROUGH ANSWERS AND CHECK FOR ADDITIONAL ANSWER COLUMNS BASED ON TEXT TYPE
                        $questAns = SurveyQuestAns::specialColumnsAsc('quest_id',$quest->id);
                        $leadingScore = '';

                        if($quest->text_type == 0){

                            $people = Utility::countData3('survey_temp_user_ans','session_id',$session,'quest_id',$quest->id,'dept_id',$dept->id);
                            $quest->countPeople = $people;

                            foreach($questAns as $ans){
                                $countUserAns = Utility::countData3('survey_temp_user_ans','ans_id',$ans->id,'session_id',$session,'dept_id',$dept->id);
                                $userAnsPerct = ($people == 0) ? $countUserAns*100 : round(($countUserAns/$people)*100);
                                $ans->userAnsPerct = $userAnsPerct;
                                $ans->countUserAns = $countUserAns;
                                $ans->userAnsRatioToPeople = $countUserAns.'/'.$people;
                                if($countUserAns >0){
                                    $ansScoreArr[$ans->ansCat->rating] = $userAnsPerct;
                                }

                            }
                            $leadingScore = Utility::arrHighestScoreSurvey($ansScoreArr);

                        }else{

                        }
                        $ansScoreCatArr [] = $leadingScore;
                        $quest->leadingScore = $leadingScore;
                        $quest->ans = $questAns;    //ADD ANSWERS TO EACH QUESTION

                    }

                    $score = (array_sum($ansScoreCatArr)*100);
                    $catScore = ($score != 0) ? round(($score/(count($ansScoreCatArr)*100))) : 0;
                    $catId->catScore = $catScore;
                    $catId->question = $question;
                    $deptTotalScore[] = round(($catScore*$catId->rating)/100);


                }

                $dept->questionCategory = $questionCategory;  //ADD SELECTED PROCESSED QUESTIONS TO EACH DEPARTMENT
                $dept->totalScore = array_sum($deptTotalScore);

            }

            $val->dept = $fetchDept;
            $val->sessionId = $session;
            $val->participantType = 'temp_user';

            foreach($fetchDept2 as $deptAns){
                $questCatArr2 = [];
                $ansCatArr = [];

                $deptQuest =  SurveyQuestAns::specialColumns2('survey_id',$val->id,'dept_id',$deptAns->id);
                foreach($deptQuest as $questCat){
                    $ansCatArr[] = $questCat->ans_cat_id;
                }
                $deptQuest =  SurveyQuest::specialColumnsAsc2('survey_id',$val->id,'dept_id',$deptAns->id);
                foreach($deptQuest as $questCat){
                    $questCatArr2[] = $questCat->cat_id;
                }

                $questCatId = array_unique($questCatArr2);
                $questionCategory = SurveyQuestCat::massData('id',$questCatId);

                $ansCatId = array_unique($ansCatArr);
                $answerCategory = SurveyAnsCat::massData('id',$ansCatId);
                foreach($questionCategory as $catId){

                    //$question = SurveyQuest::massDataConditionAsc('survey_id',$val->id,'cat_id',$catId->id);
                    //$countQuestCatAns = Utility::countData3(Utility::authSurveyTable('temp_user'),'session_id',$session,'quest_cat_id',$catId->id,'dept_id',$deptAns->id);
                    $countQuestCat = Utility::specialColumns3('survey_temp_user_ans','session_id',$session,'quest_cat_id',$catId->id,'dept_id',$deptAns->id);
                    //$countQuestCatAns = $countQuestCat->count();
                    $quCat = [];
                    $quCatOptionType = [];
                    $quOptionType = [];
                    foreach($countQuestCat as $qu){
                        if($qu->text_type == '0'){
                            $quCatOptionType[] = $qu->quest_id;
                        }
                        if($qu->text_type == '0'){
                            $quOptionType[] = $qu->quest_id;
                        }

                        $quCat[] = $qu->quest_id;
                    }
                    $countQuestCatAns = count($quOptionType);  //COUNT ALL ANSWERS FROM USERS FOR THIS QUESTION CATEGORY WITH OPTION TYPE
                    $questCatNum = array_unique($quCat);    //COUNT NUMBER OF QUESTIONS IN CATEGORY
                    $questCatNumOption = array_unique($quCatOptionType);    //COUNT NUMBER OF QUESTIONS WITH OPTIONS IN CATEGORY

                    $catId->questCatNum = count($questCatNum);
                    $catId->questCatNumOption = count($questCatNumOption);
                    $catId->countQuestCatAns = $countQuestCatAns;

                    //LOOP THROUGH QUESTIONS TO GET ANSWERS
                    foreach($answerCategory as $ansCat){
                        $countQuestCatAnsCat = Utility::countData4('survey_temp_user_ans','session_id',$session,'quest_cat_id',$catId->id,'dept_id',$deptAns->id,'ans_cat_id',$ansCat->id);

                        $ansCat->ansCatPerct = ($countQuestCatAnsCat == 0) ? 0 : round(($countQuestCatAnsCat/$countQuestCatAns)*100);
                        $ansCat->countQuestCatAnsCat = $countQuestCatAnsCat; //COUNT THE NUMBER OF ANSWER CATEGORY
                    }

                    $catId->answerCategory = $answerCategory;
                }

                $deptAns->questionCategory = $questionCategory;  //ADD SELECTED PROCESSED QUESTION CATEGORIES TO EACH DEPARTMENT
            }
            $val->dept2 = $fetchDept2;
            $val->participants = $sessionPeople;

        }else{
            $val->dept = [];
        }
    }

}
