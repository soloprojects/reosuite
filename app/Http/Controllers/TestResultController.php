<?php

namespace App\Http\Controllers;

use App\model\Department;
use App\Helpers\Utility;
use App\model\TempUsers;
use App\model\Test;
use App\model\TestQuest;
use App\model\TestQuestAns;
use App\model\TestCategory;
use App\model\TestSession;
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

class TestResultController extends Controller
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
        $mainData = TestSession::getAllData();

        if ($request->ajax()) {

            return \Response::json(view::make('test_result.reload',array('mainData' => $mainData,))->render());

        }else{
            return view::make('test_result.main_view')->with('mainData',$mainData);
        }

    }

    public function testExplanation(Request $request)
    {
        //
        $mainData = [];
        if($request->input('param2') == 'external'){
            $mainData = TestTempUserAns::specialColumns4('test_id',$request->input('dataId'),'session_id',$request->input('param1'),'text_type',1,'user_id',$request->input('userId'));
        }else{
            $mainData = TestUserAns::specialColumns4('test_id',$request->input('dataId'),'session_id',$request->input('param1'),'text_type',1,'user_id',$request->input('userId'));
        }

        return view::make('test_result.text_preview')->with('mainData',$mainData);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * ADD/REMOVE FOR TEST DEPARTMENTS the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchTest(Request $request)
    {
        //
        $searchResultRules = [
            'session' => 'required',
            'participant' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
        ];
        $validator = Validator::make($request->all(),$searchResultRules);
        if($validator->passes()) {

            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');
            $sessionId = $request->input('session');
            $participant = $request->input('participant');

            $session = TestSession::firstRow('id',$sessionId);
            $mainData = Test::firstRow('id',$session->test_id);
            if($participant == 'external'){
                $this->processItemDataExt($mainData,$sessionId,Utility::standardDate($fromDate),Utility::standardDate($toDate));
            }else{
                $this->processItemData($mainData,$sessionId,Utility::standardDate($fromDate),Utility::standardDate($toDate));
            }


            return view::make('test_result.reload')->with('mainData',$mainData)
                ->with('session',$session)->with('type','data')->with('participantType',$participant);

        }else{
            $mainData = $validator->errors();
            return view::make('test_result.reload')->with('mainData',$mainData)->with('type','error');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function processItemData($val,$session,$from,$to){
        $testCategory = json_decode($val->all_category,true);
        $testUsers = TestUserAns::specialColumnsDateDiff4('test_id',$val->id,'session_id',$session,'created_at',$from,$to);
        $usersArr = [];
        foreach($testUsers as $user){
            $usersArr[] = $user->user_id;
        }

        $users = array_unique($usersArr);
        $selectUsers = User::massData('id',$users);
        foreach($selectUsers as $user){
            if(!empty($testCategory)){
                $fetchCat = TestCategory::massData('id',$testCategory);

                $catFree = [];
                $duration = [];
                $getScore = [];
                $scoreAll = [];
                $avgScorePerct = [];
                foreach($fetchCat as $cat){
                    $testAnsTable = 'test_user_ans';
                    $testResult = Utility::countData3($testAnsTable,'session_id',$session,'cat_id',$cat->id,'user_id',Utility::checkAuth('temp_user')->id);
                    $resultCheck = ($testResult >0) ? 1 : 0;
                    $scorePerct = '';
                    $scoreAns = '';
                    $overallAns = '';
                    if($resultCheck == 0){
                        $catFree[] = $cat->id; $duration[] = $cat->duration;
                    }else{
                        $optQuest = Utility::specialColumns5($testAnsTable,'user_id',$user->id,'session_id',$session,'test_id',$val->id,'cat_id',$cat->id,'text_type',0);
                        $correctQuest = Utility::specialColumns6($testAnsTable,'user_id',$user->id,'session_id',$session,'test_id',$val->id,'cat_id',$cat->id,'text_type',0,'correct_status',1);
                        $overallAns = $optQuest->count();
                        $scoreAns = $correctQuest->count();
                        $scorePerct = round(($scoreAns*100)/$overallAns);
                        $getScore[] = $scoreAns;
                        $scoreAll[] = $overallAns;
                        $avgScorePerct[] = $scorePerct;

                    }

                    $cat->overallAns = $overallAns;
                    $cat->scoreAns = $scoreAns;
                    $cat->scorePerct =$scorePerct;

                }
                $user->avgScore = round(array_sum($getScore)/count($getScore));
                $user->avgTotalScore = round(array_sum($scoreAll)/count($scoreAll));
                $user->avgScorePerct = round(array_sum($avgScorePerct)/count($avgScorePerct));
                $user->category = $fetchCat;

            }
        }
        $val->testUsers = $selectUsers;

    }

    public function processItemDataExt($val,$session,$from,$to){
        $testCategory = json_decode($val->all_category,true);
        $testUsers = TestTempUserAns::specialColumnsDateDiff4('test_id',$val->id,'session_id',$session,'created_at',$from,$to);
        $usersArr = [];
        foreach($testUsers as $user){
            $usersArr[] = $user->user_id;
        }

        $users = array_unique($usersArr);
        $selectUsers = TempUsers::massData('id',$users);
        foreach($selectUsers as $user){
            if(!empty($testCategory)){
                $fetchCat = TestCategory::massData('id',$testCategory);

                $catFree = [];
                $duration = [];
                $getScore = [];
                $scoreAll = [];
                $avgScorePerct = [];
                foreach($fetchCat as $cat){
                    $testAnsTable = 'test_temp_user_ans';
                    $testResult = Utility::countData3($testAnsTable,'session_id',$session,'cat_id',$cat->id,'user_id',$user->id);
                    $resultCheck = ($testResult >0) ? 1 : 0;
                    $scorePerct = '';
                    $scoreAns = '';
                    $overallAns = '';
                    if($resultCheck == 0){
                        $catFree[] = $cat->id; $duration[] = $cat->duration;
                    }else{
                        $optQuest = Utility::specialColumns5($testAnsTable,'user_id',$user->id,'session_id',$session,'test_id',$val->id,'cat_id',$cat->id,'text_type',0);
                        $correctQuest = Utility::specialColumns6($testAnsTable,'user_id',$user->id,'session_id',$session,'test_id',$val->id,'cat_id',$cat->id,'text_type',0,'correct_status',1);
                        $overallAns = $optQuest->count();
                        $scoreAns = $correctQuest->count();
                        $scorePerct = round(($scoreAns*100)/$overallAns);
                        $getScore[] = $scoreAns;
                        $scoreAll[] = $overallAns;
                        $avgScorePerct[] = $scorePerct;

                    }

                    $cat->overallAns = $overallAns;
                    $cat->scoreAns = $scoreAns;
                    $cat->scorePerct =$scorePerct;

                }
                $user->avgScore = round(array_sum($getScore)/count($getScore));
                $user->avgTotalScore = round(array_sum($scoreAll)/count($scoreAll));
                $user->avgScorePerct = round(array_sum($avgScorePerct)/count($avgScorePerct));
                $user->category = $fetchCat;

            }
        }
        $val->testUsers = $selectUsers;

    }

}
