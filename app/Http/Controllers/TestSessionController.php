<?php

namespace App\Http\Controllers;

use App\model\Department;
use App\Helpers\Utility;
use App\model\Test;
use App\model\TestCategory;
use App\model\TestQuest;
use App\model\TestQuestAns;
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

class TestSessionController extends Controller
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
        $mainData = TestSession::paginateAllData();
        $test = Test::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('test_session.reload',array('mainData' => $mainData,
                'test' => $test))->render());

        }else{
            return view::make('test_session.main_view')->with('mainData',$mainData)->with('test',$test);
        }

    }

    public function testList(Request $request)
    {
        //
        //$req = new Request();
        $mainData = TestSession::specialColumns('user_status',Utility::STATUS_ACTIVE);

        return view::make('test_session.list')->with('mainData',$mainData);

    }

    public function testListTemp(Request $request)
    {
        //
        //$req = new Request();
        $mainData = TestSession::specialColumns('temp_user_status',Utility::STATUS_ACTIVE);

        return view::make('test_session.list_temp')->with('mainData',$mainData);

    }

    public function testForm(Request $request, $id, $session)
    {
        //
        //$req = new Request();
        $mainData = Test::firstRow('id',$id);
        $testSession = TestSession::firstRow('id',$session);
        $this->processItemData($mainData,$session);

        return view::make('test_session.test_form')->with('mainData',$mainData)
            ->with('testSession',$testSession);

    }

    public function testFormTemp(Request $request, $id, $session)
    {
        //
        //$req = new Request();
        $mainData = Test::firstRow('id',$id);
        $testSession = TestSession::firstRow('id',$session);
        $this->processItemData($mainData,$session);

        return view::make('test_session.test_form_temp')->with('mainData',$mainData)
            ->with('testSession',$testSession);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),TestSession::$mainRules);
        if($validator->passes()){


            $countData = TestSession::countData('session_name',$request->input('session_name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                $dbDATA = [
                    'session_name' => ucfirst($request->input('session_name')),
                    'test_id' => $request->input('test'),
                    'user_status' => $request->input('internal_participant'),
                    'temp_user_status' => $request->input('external_participant'),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                TestSession::create($dbDATA);

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


    public function submitTestForm(Request $request){

        $countQuest = $request->input('countQuest');
        $test = $request->input('test');
        $session = $request->input('session');
        $category = $request->input('test_category');

        $mainRules = [];
        $checkAns = [];
        for($k=1;$k<=$countQuest;$k++){
            if($request->input('answer' . $k) != ''){
                $checkAns[] = $request->input('answer' . $k);
            }
        }

        //ENSURE THAT ANSWER DOES'NT EXIST ALREADY IN THE DB
        $testResult = (Utility::authColumn('temp_user') == 'temp_user') ? TestTempUserAns::firstRow2('session_id',$session,'user_id',Utility::checkAuth('temp_user')->id) : TestUserAns::firstRow2('session_id',$session,'user_id',Utility::checkAuth('temp_user')->id);

        if(empty($testResult)){

            for ($i = 1; $i <= $countQuest; $i++) {   //DO FOLLOWING IF QUESTION HAVE EXTRA ANSWER OPTIONS
                $ansId = '';
                $correct = 0;
                if($request->input('answer' . $i) != '' && $request->input('text_type' . $i) != 1) {
                    $explodeAnswer = explode('|', $request->input('answer' . $i));
                    $ansId = $explodeAnswer[0];
                    $correct = $explodeAnswer[1];
                }
                $dbDATANEW = [
                    'test_id' => $test,
                    'session_id' => $session,
                    'cat_id' => $category,
                    'quest_id' => $request->input('question' . $i),
                    'text_answer' => $request->input('answer' . $i),
                    'text_type' => $request->input('text_type' . $i),
                    'ans_id' => $ansId,
                    'correct_status' => $correct,
                    'user_id' => Utility::checkAuth('temp_user')->id,
                    'created_by' => Utility::checkAuth('temp_user')->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'status' => Utility::STATUS_ACTIVE
                ];

                $create = Utility::createData(Utility::authTestTable('temp_user'), $dbDATANEW);


            }

        }

            return response()->json([
                'message' => 'good',
                'message2' => 'saved'
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
        $survey = TestSession::firstRow('id',$request->input('dataId'));
        return view::make('test_session.edit_form')->with('edit',$survey);

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
        $validator = Validator::make($request->all(),TestSession::$mainRulesEdit);
        if($validator->passes()) {

            $dbDATA = [
                'session_name' => ucfirst($request->input('session_name')),
                'user_status' => $request->input('internal_participant'),
                'temp_user_status' => $request->input('external_participant'),
                'updated_by' => Auth::user()->id,
            ];
            $rowData = TestSession::specialColumns('session_name', $request->input('session_name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    TestSession::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                TestSession::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
            $request = TestUserAns::firstRow('session_id',$all_id[$i]);
            $requestTemp = TestTempUserAns::firstRow('session_id',$all_id[$i]);
            if(empty($request) && empty($requestTemp)){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }


        $message = (count($in_use) > 0) ? ' and '.count($in_use).
            ' test session(s) has been used to conduct a test session and cannot be deleted' : '';

        $delete = TestSession::destroy($unused);

        return response()->json([
            'message2' => 'deleted',
            'message' => count($unused).' data(s) has been deleted'.$message
        ]);


    }

    public function processItemData($val,$session){
        $testCategory = json_decode($val->all_category,true);
        if(!empty($testCategory)){
            $fetchCat = TestCategory::massData('id',$testCategory);

            $catFree = [];
            $duration = [];
            foreach($fetchCat as $cat){
                $catQuest =  TestQuest::specialColumnsAsc2('test_id',$val->id,'cat_id',$cat->id);
                $questCount = $catQuest->count();
                $testAnsTable = Utility::authTestTable('temp_user');
                $testResult = Utility::countData3($testAnsTable,'session_id',$session,'cat_id',$cat->id,'user_id',Utility::checkAuth('temp_user')->id);
                $resultCheck = ($testResult >0) ? 1 : 0;
                $scorePerct = '';
                $scoreAns = '';
                $overallAns = '';
                if($resultCheck == 0){
                    $catFree[] = $cat->id; $duration[] = $cat->duration;
                }else{
                    $optQuest = Utility::specialColumns5($testAnsTable,'user_id',Utility::checkAuth('temp_user')->id,'session_id',$session,'test_id',$val->id,'cat_id',$cat->id,'text_type',0);
                    $correctQuest = Utility::specialColumns6($testAnsTable,'user_id',Utility::checkAuth('temp_user')->id,'session_id',$session,'test_id',$val->id,'cat_id',$cat->id,'text_type',0,'correct_status',1);
                    $overallAns = $optQuest->count();
                    $scoreAns = $correctQuest->count();
                    $scorePerct = round(($scoreAns*100)/$overallAns);

                }

                $cat->overallAns = $overallAns;
                $cat->scoreAns = $scoreAns;
                $cat->scorePerct =$scorePerct;

                $questNum = 0;
                //LOOP THROUGH QUESTIONS TO GET ANSWERS AND NUMBER OF ADDITIONAL ANSWER COLUMNS NEEDED
                foreach($catQuest as $quest){
                    $questNum++;
                    $quest->quest_number = $questNum;   //GET THE QUESTION NUMBER FOR DISPLAY
                    //LOOP THROUGH ANSWERS AND CHECK FOR ADDITIONAL ANSWER COLUMNS BASED ON TEXT TYPE
                    $questAns = TestQuestAns::specialColumnsAsc('quest_id',$quest->id);

                    if($quest->text_type == 0){
                        //$countAns = TestQuestAns::countData('quest_id', $quest->id);
                        $countAns = $questAns->count();
                        $moreAnsColumnCount = ($countAns > 2) ? 2 : 3;
                        $quest->moreAnsColumnCount = $moreAnsColumnCount;   //ADD TO QUESTION NUMBER OF MORE ANSWER COLUMN OPTIONS
                        $quest->ans = $questAns;    //ADD ANSWERS TO EACH QUESTION
                        $quest->count_ans = $countAns;

                    }else{
                        $quest->ans = '';
                        $quest->moreAnsColumnCount = 0;
                    }
                }

                $cat->resultCheck = $resultCheck;
                $cat->questCount = $questCount;
                $cat->questions = $catQuest;  //ADD SELECTED PROCESSED QUESTIONS TO EACH DEPARTMENT
            }

            $showCat = (count($catFree) >0) ? $catFree[0] : 0;
            $showDuration = (count($duration) >0) ? $duration[0] : 0;
            $val->showDuration = $showDuration;
            $val->showCat = $showCat;
            $val->category = $fetchCat;
        }else{
            $val->category = '';
        }
    }

}
