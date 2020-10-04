<?php

namespace App\Http\Controllers;

use App\Helpers\Notify;
use App\model\ApprovalDept;
use App\model\BehavComp;
use App\model\CompetencyAssess;
use App\model\CompetencyFramework;
use App\model\Department;
use App\model\IndiObjective;
use App\model\SkillCompCat;
use App\model\IndiGoal;
use App\model\UnitGoal;
use App\Helpers\Utility;
use App\model\IndiGoalCat;
use App\model\UnitGoalExt;
use App\model\UnitGoalSeries;
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

class IndiGoalController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $mainData = (in_array(Auth::user()->role,Utility::HR_MANAGEMENT)) ? IndiGoal::paginateAllData() : IndiGoal::specialColumnsPage('user_id',Auth::user()->id);
        $indiGoalCat = IndiGoalCat::getAllData();
        $indiGoalSeries = UnitGoalSeries::getAllData();
        $department = Department::getAllData();
        $compFrame = SkillCompCat::specialColumns2('dept_id',Auth::user()->dept_id,'skill_comp_id',Utility::BEHAV_COMP);
        $techComp = SkillCompCat::specialColumns2('dept_id',Auth::user()->dept_id,'skill_comp_id',Utility::COMP_ASSESS);
        $hod = Utility::appSupervisor('appraisal_supervision',Auth::user()->dept_id,Auth::user()->id);
        $lowerHod = Utility::detectHOD(Auth::user()->id);
        $hodId = Utility::appSupervisorId('appraisal_supervision',Auth::user()->dept_id,Auth::user()->id);
        $lowerHodId = Utility::detectHODId(Auth::user()->dept_id);
        $deptHead = ApprovalDept::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('indi_goals.reload',array('mainData' => $mainData,'indiGoalCat' => $indiGoalCat
            ,'indiGoalSeries' => $indiGoalSeries,'hod' => $hod,'behavComp' => $compFrame,
            'hodId' => $hodId,'lowerHodId' => $lowerHodId,'lowerHod' => $lowerHod,'dept' => $department
            ,'techComp' => $techComp,'deptHead' => $deptHead))->render());

        }else{
            return view::make('indi_goals.main_view')->with('mainData',$mainData)->with('indiGoalCat',$indiGoalCat)
                ->with('indiGoalSeries',$indiGoalSeries)->with('hod',$hod)->with('lowerHod',$lowerHod)
                ->with('behavComp',$compFrame)->with('hodId',$hodId)->with('lowerHodId',$lowerHodId)
                ->with('dept',$department)->with('techComp',$techComp)->with('deptHead',$deptHead);
        }

    }


    //MARK INDIVIDUAL GOALS OF EMPLOYEES
    public function markIndiGoal(Request $request)
    {
        //
        $goalSetId = $request->input('goal_set');
        $deptId = $request->input('department');
        $userId = $request->input('user');
        if($deptId == 0 && $userId != ''){
            $getDept = User::where('id',$userId)->where('status',Utility::STATUS_ACTIVE)->first(['dept_id']);
            $deptId = $getDept->dept_id;

        }
        $dept = Department::getAllData();
        $userDetail = User::firstRow('id',$userId);
        $deptHead = ApprovalDept::getAllData();


        $indiGoal = IndiGoal::specialColumns3('goal_set_id',$goalSetId,'dept_id',$deptId,'user_id',$userId);
        $indiGoalCat = IndiGoalCat::getAllData();
        $indiGoalSeries = UnitGoalSeries::getAllData();
        $hod = Utility::appSupervisor('appraisal_supervision',$deptId,Auth::user()->id);
        $lowerHod = Utility::detectHOD(Auth::user()->id);
        $hodId = Utility::appSupervisorId('appraisal_supervision',$deptId,Auth::user()->dept_id);
        $lowerHodId = Utility::detectHODId(Auth::user()->dept_id);
        $lowerHodDetail = User::firstRow('id',$lowerHodId);
        $hodDetail = User::firstRow('id',$hodId);
        $compFrame = (Auth::user()->dept_id == $deptId) ? SkillCompCat::specialColumns2('dept_id',Auth::user()->dept_id,'skill_comp_id',Utility::BEHAV_COMP):
            SkillCompCat::specialColumns2('dept_id',$deptId,'skill_comp_id',Utility::BEHAV_COMP);
        $techComp = (Auth::user()->dept_id == $deptId) ? SkillCompCat::specialColumns2('dept_id',Auth::user()->dept_id,'skill_comp_id',Utility::COMP_ASSESS):
            SkillCompCat::specialColumns2('dept_id',$deptId,'skill_comp_id',Utility::COMP_ASSESS);
            //print_r($indiGoalCat);exit();
       /* if($goalSetId == '' && $deptId == '' && $userId == '' && count($indiGoal)){
            return 'No match found to your search, please search again';
        }*/

            return view::make('indi_goals.mark_indi_goal')->with('indiGoal',$indiGoal)->with('$IndiGoalCat',$indiGoalCat)
                ->with('hod',$hod)->with('indiGoalSeries',$indiGoalSeries)->with('lowerHod',$lowerHod)
                ->with('behavComp',$compFrame)->with('lowerHodId',$lowerHodId)->with('hodId',$hodId)
                ->with('techComp',$techComp)->with('lowerHodDetail',$lowerHodDetail)->with('hodDetail',$hodDetail)
                ->with('dept',$dept)->with('userDetail',$userDetail)->with('deptHead',$deptHead);




    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $hodId = Utility::appSupervisorId('appraisal_supervision',Auth::user()->dept_id,Auth::user()->id);
        $lowerHodId = Utility::detectHODId(Auth::user()->dept_id);
        $lowerHod = Utility::detectHOD(Auth::user()->id);
        $lowerHodMail = User::firstRow('id',$lowerHodId);
        $hodMail = User::firstRow('id',$hodId);

        $mainUser = ($lowerHod == Utility::HOD_DETECTOR) ? $hodMail : $lowerHodMail;

        $objContent = new \stdClass();
        $objContent->sender_name = Auth::user()->firstname.'&nbsp;'.Auth::user()->lastname;
        $objContent->receiver_name = $mainUser->firstname.'&nbsp;'.$mainUser->lastname;
        $objContent->type = 'Individual Goal';

        $validator = Validator::make($request->all(), IndiGoal::$mainRules);
        if ($validator->passes()) {

            $indiGoalCat = $request->input('competency_type');
            $goalSet = $request->input('goal_set');
            $unitGoalCount = UnitGoal::countData('goal_set_id',$goalSet);

            if($unitGoalCount >= 4){
            if ($indiGoalCat == Utility::APP_OBJ_GOAL) {
                $obj = json_decode($request->input('obj'));
                $level = json_decode($request->input('level'));
                $rev_rate = json_decode($request->input('review'));
                $indiComment = $request->input('individual');

                $reviewerComment = $request->input('reviewer');
                /*return response()->json([
                    'message' => 'warning',
                    'message2' => $request->input('obj')
                ]);*/

                if (count($obj) == count($level)) {

                    $dbDATA = [
                        'goal_set_id' => $goalSet,
                        'indi_comment' => $indiComment,
                        'reviewer_comment' => $reviewerComment,
                        'user_id' => Auth::user()->id,
                        'dept_id' => Auth::user()->dept_id,
                        'indi_goal_cat' => Utility::APP_OBJ_GOAL,
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];

                    $createIndiGoal = IndiGoal::create($dbDATA);


                    for ($i = 0; $i < count($obj); $i++) {

                        $dbDATA2 = [
                            'objectives' => Utility::checkEmptyArrayItem($obj,$i,''),
                            'obj_level' => Utility::checkEmptyArrayItem($level,$i,'None'),
                            'indi_goal_id' => $createIndiGoal->id,
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];

                        IndiObjective::create($dbDATA2);
                    }

                    /*$objContent->goal_set = $goalSet;
                    $objContent->comp_type = 'objectives';
                    Notify::appraisalMail('mail.appraisal',$objContent,$mainUser->email);*/

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);


                } else {

                    return response()->json([
                        'message' => 'warning',
                        'message2' => 'Please fill in all required fields'
                    ]);
                }

            }
            //END OF OBJECTIVES

            if ($indiGoalCat == Utility::COMP_ASSESS) {
                $coreComp = json_decode($request->input('core_comp'));
                $capable = json_decode($request->input('capable'));
                $compLevel = json_decode($request->input('level'));
                $compRevRate = json_decode($request->input('review'));
                $indiComment = $request->input('individual');
                $reviewerComment = $request->input('reviewer');

                if (count($coreComp) == count($capable) || count($coreComp) == count($compLevel)) {

                    $dbDATA = [
                        'goal_set_id' => $goalSet,
                        'indi_comment' => $indiComment,
                        'reviewer_comment' => $reviewerComment,
                        'user_id' => Auth::user()->id,
                        'dept_id' => Auth::user()->dept_id,
                        'indi_goal_cat' => Utility::COMP_ASSESS,
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];

                    $createIndiGoal = IndiGoal::create($dbDATA);


                    for ($i = 0; $i < count($coreComp); $i++) {

                        $dbDATA2 = [
                            'core_comp' => Utility::checkEmptyArrayItem($coreComp,$i,''),
                            'capability' => Utility::checkEmptyArrayItem($capable,$i,''),
                            'indi_goal_id' => $createIndiGoal->id,
                            'level' => Utility::checkEmptyArrayItem($compLevel,$i,'Nil'),
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];

                        CompetencyAssess::create($dbDATA2);
                    }

                    /*$objContent->goal_set = $goalSet;
                   $objContent->comp_type = 'tech_comp';
                   Notify::appraisalMail('mail.appraisal',$objContent,$mainUser->email);*/

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);


                } else {

                    return response()->json([
                        'message' => 'warning',
                        'message2' => 'Please fill in all required fields'
                    ]);
                }

            }
            //END OF COMPETENCY ASSESSMENT

            if ($indiGoalCat == Utility::BEHAV_COMP2) {
                $coreBehavComp = json_decode($request->input('core_comp'));
                $element = json_decode($request->input('element'));
                $compLevel = json_decode($request->input('level'));
                $revRate = json_decode($request->input('review'));
                $indiComment = $request->input('individual');
                $reviewerComment = $request->input('reviewer');

                if (count($coreBehavComp) == count($element) || count($coreBehavComp) == count($compLevel)) {


                    $dbDATA = [
                        'goal_set_id' => $goalSet,
                        'indi_comment' => $indiComment,
                        'reviewer_comment' => $reviewerComment,
                        'user_id' => Auth::user()->id,
                        'dept_id' => Auth::user()->dept_id,
                        'indi_goal_cat' => Utility::BEHAV_COMP2,
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];

                    $createIndiGoal = IndiGoal::create($dbDATA);


                    for ($i = 0; $i < count($coreBehavComp); $i++) {

                        $dbDATA2 = [
                            'core_behav_comp' => Utility::checkEmptyArrayItem($coreBehavComp,$i,''),
                            'element_behav_comp' => Utility::checkEmptyArrayItem($element,$i,''),
                            'indi_goal_id' => $createIndiGoal->id,
                            'level' => Utility::checkEmptyArrayItem($compLevel,$i,'Nil'),
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];

                        BehavComp::create($dbDATA2);
                    }

                    /*$objContent->goal_set = $goalSet;
                   $objContent->comp_type = 'behav_comp';
                   Notify::appraisalMail('mail.appraisal',$objContent,$mainUser->email);*/

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);


                } else {

                    return response()->json([
                        'message' => 'warning',
                        'message2' => 'Please fill in all required fields'
                    ]);
                }

            }
            //END OF BEHAV COMPETENCY

            if ($indiGoalCat == Utility::INDI_REV_COMMENT) {

                $overviewStr = $request->input('overview_str');
                $areaImprove = $request->input('area_improv');
                $sugPpDev = $request->input('sug_pp_dev');
                $overRate = $request->input('over_rate');

                $dbDATA = [
                    'goal_set_id' => $goalSet,
                    'overview_str' => $overviewStr,
                    'area_improv' => $areaImprove,
                    'sug_pp_dev' => $sugPpDev,
                    'final_review' => $overRate,
                    'user_id' => Auth::user()->id,
                    'dept_id' => Auth::user()->dept_id,
                    'indi_goal_cat' => Utility::INDI_REV_COMMENT,
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                $createIndiGoal = IndiGoal::create($dbDATA);

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

            }
            //END OF INDIVIDUAL REVIEWER COMMENT

            if ($indiGoalCat == Utility::EMP_COM_APP_PLAT) {

                $empComment = $request->input('emp_comment');
                $empSign = '';
                $revSign = '';

                $dbDATA = [
                    'goal_set_id' => $goalSet,
                    'emp_comment' => $empComment,
                    'rev_sign' => $revSign,
                    'emp_sign' => $empSign,
                    'user_id' => Auth::user()->id,
                    'dept_id' => Auth::user()->dept_id,
                    'indi_goal_cat' => Utility::EMP_COM_APP_PLAT,
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                $createIndiGoal = IndiGoal::create($dbDATA);

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

            }
            //END OF EMPLOYEE SIGN OFF

        }else{

                return response()->json([
                    'message' => 'warning',
                    'message2' => 'Unit goals must be completed before you can continue this process'
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
        $indiGoal = IndiGoal::firstRow('id',$request->input('dataId'));
        $indiGoalCat = IndiGoalCat::getAllData();
        $indiGoalSeries = UnitGoalSeries::getAllData();
        $hod = Utility::appSupervisor('appraisal_supervision',$indiGoal->dept_id,Auth::user()->id);
        $lowerHod = Utility::detectHOD(Auth::user()->id);
        $hodId = Utility::appSupervisorId('appraisal_supervision',$indiGoal->dept_id,Auth::user()->dept_id);
        $lowerHodId = Utility::detectHODId(Auth::user()->dept_id);
        $lowerHodDetail = User::firstRow('id',$lowerHodId);
        $hodDetail = User::firstRow('id',$hodId);
        $compFrame = (Auth::user()->dept_id == $indiGoal->dept_id) ? SkillCompCat::specialColumns2('dept_id',Auth::user()->dept_id,'skill_comp_id',Utility::BEHAV_COMP):
            SkillCompCat::specialColumns2('dept_id',$indiGoal->dept_id,'skill_comp_id',Utility::BEHAV_COMP);
        $techComp = (Auth::user()->dept_id == $indiGoal->dept_id) ? SkillCompCat::specialColumns2('dept_id',Auth::user()->dept_id,'skill_comp_id',Utility::COMP_ASSESS):
            SkillCompCat::specialColumns2('dept_id',$indiGoal->dept_id,'skill_comp_id',Utility::COMP_ASSESS);

        return view::make('indi_goals.edit_form')->with('edit',$indiGoal)->with('$IndiGoalCat',$indiGoalCat)
            ->with('hod',$hod)->with('indiGoalSeries',$indiGoalSeries)->with('lowerHod',$lowerHod)
            ->with('behavComp',$compFrame)->with('lowerHodId',$lowerHodId)->with('hodId',$hodId)
            ->with('techComp',$techComp)->with('lowerHodDetail',$lowerHodDetail)->with('hodDetail',$hodDetail);

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
        $validator = Validator::make($request->all(),IndiGoal::$mainRules);
        if($validator->passes()) {

            $hod = Utility::appSupervisor('appraisal_supervision',Auth::user()->dept_id,Auth::user()->id);
            $lowerHod = Utility::detectHOD(Auth::user()->id);
            $hodId = Utility::appSupervisorId('appraisal_supervision',Auth::user()->dept_id,Auth::user()->dept_id);
            $lowerHodId = Utility::detectHODId(Auth::user()->dept_id);
            $indiGoalSet = $request->input('goal_set');
            $indiGoalCat = $request->input('indi_goal_cat');
            $editUserId = $request->input('edit_user_id');

            if($indiGoalCat ==Utility::APP_OBJ_GOAL){


                $goalSet = $request->input('goal_set');

                $obj = json_decode($request->input('obj'));
                $level = json_decode($request->input('level'));
                $rev_rate = json_decode($request->input('review'));
                $indiComment = $request->input('individual');
                $reviewerComment = $request->input('reviewer');
                $countExt = intval($request->input('count_ext'));
                /*return response()->json([
                    'message' => 'warning',
                    'message2' => $request->input('level')
                ]);*/

            if (count($obj) > 0 || count($rev_rate)) {

                        //SAVE TO DATABASE PENDING ON WHO IS LOGGED IN

                        if(Auth::user()->id == $editUserId) {

                            if (count($obj) == count($level)){
                            $dbDATA = [
                                'goal_set_id' => $goalSet,
                                'indi_comment' => $indiComment,
                                'updated_by' => Auth::user()->id,
                                'status' => Utility::STATUS_ACTIVE
                            ];
                            IndiGoal::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                            //UPDATE EXISTING DATA
                            for ($i = 1; $i <= $countExt; $i++) {
                                $dbDATA2 = [
                                    'objectives' => $request->input('obj_edit' . $i),
                                    'obj_level' => $request->input('obj_level_edit' . $i),
                                    'updated_by' => Auth::user()->id,
                                ];

                                IndiObjective::defaultUpdate('id', $request->input('ext_id' . $i), $dbDATA2);
                            }   //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

                            //CREATE NEW DATA
                            for ($i = 0; $i < count($obj); $i++) {

                                $dbDATA2 = [
                                    'objectives' => Utility::checkEmptyArrayItem($obj,$i,''),
                                    'obj_level' => Utility::checkEmptyArrayItem($level,$i,'None'),
                                    'indi_goal_id' => $request->input('edit_id'),
                                    'updated_by' => Auth::user()->id,
                                    'status' => Utility::STATUS_ACTIVE
                                ];

                                IndiObjective::create($dbDATA2);
                            }

                                return response()->json([
                                    'message' => 'good',
                                    'message2' => 'saved'
                                ]);

                        } else {  //END OF IF EVERYTHING IS SUCCESSFUL WITH EXISTING AND EXTRA COLUMNS

                            return response()->json([
                                'message' => 'warning',
                                'message2' => 'Please fill in all required fields'
                            ]);
                        }


            }

                        if(Auth::user()->id != $editUserId) {

                            if (count($rev_rate) > 0){
                            $dbDATA = [
                                'goal_set_id' => $goalSet,
                                'reviewer_comment' => $reviewerComment,
                                'updated_by' => Auth::user()->id,
                                'status' => Utility::STATUS_ACTIVE
                            ];
                            IndiGoal::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                            //UPDATE EXISTING DATA
                            for ($i = 1; $i <= $countExt; $i++) {
                                $dbDATA2 = [
                                    'reviewer_rating' => $request->input('rev_rate_edit' . $i),
                                    'updated_by' => Auth::user()->id,
                                ];

                                IndiObjective::defaultUpdate('id', $request->input('ext_id' . $i), $dbDATA2);
                            }   //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

                            //CREATE NEW DATA
                            for ($i = 0; $i < count($rev_rate); $i++) {

                                $dbDATA2 = [
                                    'reviewer_rating' => $rev_rate[$i],
                                    'indi_goal_id' => $request->input('edit_id'),
                                    'updated_by' => Auth::user()->id,
                                    'status' => Utility::STATUS_ACTIVE
                                ];

                                IndiObjective::create($dbDATA2);
                            }

                                return response()->json([
                                    'message' => 'good',
                                    'message2' => 'saved'
                                ]);

                        } else {  //END OF IF EVERYTHING IS SUCCESSFUL WITH EXISTING AND EXTRA COLUMNS

                            return response()->json([
                                'message' => 'warning',
                                'message2' => 'Please fill in all required fields'
                            ]);
                        }


    }
                        //SAVE TO DATABASE PENDING ON WHO IS LOGGED IN


            } else {  //END OF IF $stratObj IS GREATER THAN 0




                    if(Auth::user()->id == $editUserId) {

                        $dbDATA = [
                            'goal_set_id' => $goalSet,
                            'indi_comment' => $indiComment,
                            'updated_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];
                        IndiGoal::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                        for ($i = 1; $i <= $countExt; $i++) {
                            $dbDATA2 = [
                                'objectives' => $request->input('obj_edit' . $i),
                                'obj_level' => $request->input('obj_level_edit' . $i),
                                'updated_by' => Auth::user()->id,
                            ];

                            IndiObjective::defaultUpdate('id', $request->input('ext_id' . $i), $dbDATA2);
                        }
                    }

                    if(Auth::user()->id != $editUserId) {

                        $dbDATA = [
                            'goal_set_id' => $goalSet,
                            'reviewer_comment' => $reviewerComment,
                            'updated_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];
                        IndiGoal::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                        for ($i = 1; $i <= $countExt; $i++) {
                            $dbDATA2 = [
                                'reviewer_rating' => $request->input('rev_rate_edit' . $i),
                                'updated_by' => Auth::user()->id,
                            ];

                            IndiObjective::defaultUpdate('id', $request->input('ext_id' . $i), $dbDATA2);
                        }
                    }
                  //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

            }   //END OF IF $stratObj IS NOT GREATER THAN 0
        }

        //END OF INDIVIDUAL OBJECTIVES

        if($indiGoalCat ==Utility::COMP_ASSESS){

            //$indiGoalCat = $request->input('competency_type');
            $goalSet = $request->input('goal_set');

            $coreComp = json_decode($request->input('core_comp'));
            $capable = json_decode($request->input('capable'));
            $compLevel = json_decode($request->input('level'));
            $compRevRate = json_decode($request->input('review'));
            $indiComment = $request->input('individual');
            $reviewerComment = $request->input('reviewer');
            $countExt = intval($request->input('count_ext'));

            if (count($coreComp) >0 || count($compRevRate) >0 || count($compLevel) >0 || count($capable) >0) {

                    //UPDATE EXISTING DATA

                    if(Auth::user()->id == $editUserId) {

                        if (count($coreComp) == count($capable) || count($coreComp) == count($compLevel)) {

                            $dbDATA = [
                                'goal_set_id' => $goalSet,
                                'indi_comment' => $indiComment,
                                'updated_by' => Auth::user()->id,
                                'status' => Utility::STATUS_ACTIVE
                            ];
                            IndiGoal::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                        for ($i = 1; $i <= $countExt; $i++) {
                            $dbDATA2 = [
                                'core_comp' => $request->input('core_comp_edit' . $i),
                                'capability' => $request->input('capable_edit' . $i),
                                'level' => $request->input('comp_level_edit' . $i),
                                'updated_by' => Auth::user()->id,
                            ];

                            CompetencyAssess::defaultUpdate('id', $request->input('ext_id' . $i), $dbDATA2);
                        }   //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

                        //CREATE NEW DATA
                        for ($i = 0; $i < count($coreComp); $i++) {

                            $dbDATA2 = [
                                'core_comp' => Utility::checkEmptyArrayItem($coreComp,$i,''),
                                'capability' => Utility::checkEmptyArrayItem($capable,$i,''),
                                'level' => Utility::checkEmptyArrayItem($compLevel,$i,'Nil'),
                                'indi_goal_id' => $request->input('edit_id'),
                                'updated_by' => Auth::user()->id,
                                'status' => Utility::STATUS_ACTIVE
                            ];

                            CompetencyAssess::create($dbDATA2);
                        }


                        return response()->json([
                            'message' => 'good',
                            'message2' => 'saved'
                        ]);


                    } else {  //END OF IF EVERYTHING IS SUCCESSFUL WITH EXISTING AND EXTRA COLUMNS

                        return response()->json([
                            'message' => 'warning',
                            'message2' => 'Please fill in all required fields'
                        ]);
                    }


                }

                    if(Auth::user()->id != $editUserId) {

                        if (count($compRevRate) >0){
                            $dbDATA = [
                                'goal_set_id' => $goalSet,
                                'reviewer_comment' => $reviewerComment,
                                'updated_by' => Auth::user()->id,
                                'status' => Utility::STATUS_ACTIVE
                            ];
                            IndiGoal::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                        for ($i = 1; $i <= $countExt; $i++) {
                            $dbDATA2 = [
                                'reviewer_rating' => $request->input('rev_rate_edit' . $i),
                                'updated_by' => Auth::user()->id,
                            ];

                            CompetencyAssess::defaultUpdate('id', $request->input('ext_id' . $i), $dbDATA2);
                        }   //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

                        //CREATE NEW DATA
                        for ($i = 0; $i < count($coreComp); $i++) {

                            $dbDATA2 = [
                                'reviewer_rating' => $compRevRate[$i],
                                'indi_goal_id' => $request->input('edit_id'),
                                'updated_by' => Auth::user()->id,
                                'status' => Utility::STATUS_ACTIVE
                            ];

                            CompetencyAssess::create($dbDATA2);
                        }


                        return response()->json([
                            'message' => 'good',
                            'message2' => 'saved'
                        ]);

                    } else {  //END OF IF EVERYTHING IS SUCCESSFUL WITH EXISTING AND EXTRA COLUMNS

                        return response()->json([
                            'message' => 'warning',
                            'message2' => 'Please fill in all required fields'
                        ]);
                    }

                }


            } else {  //END OF IF $stratObj IS GREATER THAN 0

                //UPDATE EXISTING DATA

                if(Auth::user()->id == $editUserId) {

                    $dbDATA = [
                        'goal_set_id' => $goalSet,
                        'indi_comment' => $indiComment,
                        'updated_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];

                    IndiGoal::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                    for ($i = 1; $i <= $countExt; $i++) {
                        $dbDATA2 = [
                            'core_comp' => $request->input('core_comp_edit' . $i),
                            'capability' => $request->input('capable_edit' . $i),
                            'level' => $request->input('comp_level_edit' . $i),
                            'updated_by' => Auth::user()->id,
                        ];

                        CompetencyAssess::defaultUpdate('id', $request->input('ext_id' . $i), $dbDATA2);
                    }
                }

                if(Auth::user()->id != $editUserId) {

                    $dbDATA = [
                        'goal_set_id' => $goalSet,
                        'reviewer_comment' => $reviewerComment,
                        'updated_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];

                    IndiGoal::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                    for ($i = 1; $i <= $countExt; $i++) {
                        $dbDATA2 = [
                            'reviewer_rating' => $request->input('rev_rate_edit' . $i),
                            'updated_by' => Auth::user()->id,
                        ];

                        CompetencyAssess::defaultUpdate('id', $request->input('ext_id' . $i), $dbDATA2);
                    }
                }
                  //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

            }   //END OF IF $stratObj IS NOT GREATER THAN 0
        }
        //END OF COMP ASSESS

        if($indiGoalCat ==Utility::BEHAV_COMP2){

            $indiGoalCat = $request->input('competency_type');
            $goalSet = $request->input('goal_set');

            $coreBehavComp = json_decode($request->input('core_comp'));
            $element = json_decode($request->input('element'));
            $compLevel = json_decode($request->input('level'));
            $revRate = json_decode($request->input('review'));
            $indiComment = $request->input('individual');
            $reviewerComment = $request->input('reviewer');
            $countExt = intval($request->input('count_ext'));

            if (count($coreBehavComp) >0 || count($revRate) >0 || count($compLevel) >0 || count($element) >0) {

                    //UPDATE EXISTING DATA

                    if(Auth::user()->id == $editUserId) {

                        if (count($coreBehavComp) == count($element) && count($coreBehavComp) == count($compLevel)) {

                            $dbDATA = [
                                'goal_set_id' => $goalSet,
                                'indi_comment' => $indiComment,
                                'updated_by' => Auth::user()->id,
                                'status' => Utility::STATUS_ACTIVE
                            ];
                            IndiGoal::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                        for ($i = 1; $i <= $countExt; $i++) {
                            $dbDATA2 = [
                                'core_behav_comp' => $request->input('core_behav_comp_edit' . $i),
                                'element_behav_comp' => $request->input('element_edit' . $i),
                                'level' => $request->input('behav_level_edit' . $i),
                                'updated_by' => Auth::user()->id,
                            ];

                            BehavComp::defaultUpdate('id', $request->input('ext_id' . $i), $dbDATA2);
                        }   //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

                        //CREATE NEW DATA
                        for ($i = 0; $i < count($coreBehavComp); $i++) {

                            $dbDATA2 = [
                                'core_behav_comp' => Utility::checkEmptyArrayItem($coreBehavComp,$i,''),
                                'element_behav_comp' => Utility::checkEmptyArrayItem($element,$i,''),
                                'level' => Utility::checkEmptyArrayItem($compLevel,$i,'Nil'),
                                'indi_goal_id' => $request->input('edit_id'),
                                'updated_by' => Auth::user()->id,
                                'status' => Utility::STATUS_ACTIVE
                            ];

                            BehavComp::create($dbDATA2);
                        }


                        return response()->json([
                            'message' => 'good',
                            'message2' => 'saved'
                        ]);


                    } else {  //END OF IF EVERYTHING IS SUCCESSFUL WITH EXISTING AND EXTRA COLUMNS

                        return response()->json([
                            'message' => 'warning',
                            'message2' => 'Please fill in all required fields'
                        ]);
                    }


                }

                    if(Auth::user()->id != $editUserId) {

                        if (count($revRate) >0){
                            $dbDATA = [
                                'goal_set_id' => $goalSet,
                                'reviewer_comment' => $reviewerComment,
                                'updated_by' => Auth::user()->id,
                                'status' => Utility::STATUS_ACTIVE
                            ];
                            IndiGoal::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                        for ($i = 1; $i <= $countExt; $i++) {

                            $dbDATA2 = [
                                'reviewer_rating' => $request->input('behav_rev_rate_edit' . $i),
                                'updated_by' => Auth::user()->id,
                            ];

                            BehavComp::defaultUpdate('id', $request->input('ext_id' . $i), $dbDATA2);
                        }   //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

                        //CREATE NEW DATA
                        for ($i = 0; $i < count($coreBehavComp); $i++) {

                            $dbDATA2 = [
                                'reviewer_rating' => $revRate[$i],
                                'indi_goal_id' => $request->input('edit_id'),
                                'updated_by' => Auth::user()->id,
                                'status' => Utility::STATUS_ACTIVE
                            ];

                            BehavComp::create($dbDATA2);
                        }


                        return response()->json([
                            'message' => 'good',
                            'message2' => 'saved'
                        ]);

                    } else {  //END OF IF EVERYTHING IS SUCCESSFUL WITH EXISTING AND EXTRA COLUMNS

                        return response()->json([
                            'message' => 'warning',
                            'message2' => 'Please fill in all required fields'
                        ]);
                    }

                }


            } else {  //END OF IF $BEHAVCOMP IS GREATER THAN 0


                //UPDATE EXISTING DATA

                if(Auth::user()->id == $editUserId) {

                    $dbDATA = [
                        'goal_set_id' => $goalSet,
                        'indi_comment' => $indiComment,
                        'updated_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];

                    IndiGoal::defaultUpdate('id', $request->input('edit_id'), $dbDATA);


                    for ($i = 1; $i <= $countExt; $i++) {
                        $dbDATA2 = [
                            'core_behav_comp' => $request->input('core_behav_comp_edit' . $i),
                            'element_behav_comp' => $request->input('element_edit' . $i),
                            'level' => $request->input('behav_level_edit' . $i),
                            'updated_by' => Auth::user()->id,
                        ];

                        BehavComp::defaultUpdate('id', $request->input('ext_id' . $i), $dbDATA2);
                    }
                }

                if(Auth::user()->id != $editUserId) {

                    $dbDATA = [
                        'goal_set_id' => $goalSet,
                        'reviewer_comment' => $reviewerComment,
                        'updated_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];

                    IndiGoal::defaultUpdate('id', $request->input('edit_id'), $dbDATA);


                    for ($i = 1; $i <= $countExt; $i++) {

                        $dbDATA2 = [
                            'reviewer_rating' => $request->input('behav_rev_rate_edit' . $i),
                            'updated_by' => Auth::user()->id,
                        ];

                        BehavComp::defaultUpdate('id', $request->input('ext_id' . $i), $dbDATA2);
                    }
                }
                  //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

                return response()->json([
                    'message' => 'good2',
                    'message2' => 'saved'
                ]);

            }   //END OF IF $stratObj IS NOT GREATER THAN 0
        }
        //END OF BEHAV COMP

        if($indiGoalCat == Utility::INDI_REV_COMMENT){

            $overviewStr = $request->input('overview_str');
            $areaImprove = $request->input('area_improv');
            $sugPpDev = $request->input('sug_pp_dev');
            $overRate = $request->input('over_rate');

            if($editUserId != Auth::user()->id){
                $dbDATA = [
                    'goal_set_id' => $indiGoalSet,
                    'overview_str' => $overviewStr,
                    'area_improv' => $areaImprove,
                    'sug_pp_dev' => $sugPpDev,
                    'final_review' => $overRate,
                    'updated_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                $updateIndiGoal = IndiGoal::defaultUpdate('id', $request->input('edit_id'), $dbDATA);
            }



            return response()->json([
                'message' => 'good',
                'message2' => 'saved'
            ]);

        }
        //END OF INDIVIDUAL REVIEWER COMMENT

        if($indiGoalCat == Utility::EMP_COM_APP_PLAT){

            $empComment = $request->input('emp_comment');
            $empSign = $request->input('emp_sign');
            $revSign = $request->input('rev_sign');
            $empSign = ($empSign == '') ? '' : IndiGoal::digitalSign('emp_sign');
            $revSign = ($revSign == '') ? '' : IndiGoal::digitalSign('rev_sign');
            $superId = (Auth::user()->id == $lowerHod) ? $hodId : $lowerHodId;
            $supId = ($revSign == '') ? 0 : $superId ;


            if($editUserId == Auth::user()->id){
                $dbDATA = [
                    'goal_set_id' => $indiGoalSet,
                    'emp_comment' => $empComment,
                    'emp_sign' => $empSign,
                    'supervisor_id' => $supId,
                    'updated_by' => Auth::user()->id
                ];
                $updateIndiGoal = IndiGoal::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

            }

            if($editUserId != Auth::user()->id){
                $dbDATA = [
                    'goal_set_id' => $indiGoalSet,
                    'rev_sign' => $revSign,
                    'supervisor_id' => $supId,
                    'updated_by' => Auth::user()->id
                ];
                $updateIndiGoal = IndiGoal::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

            }



            return response()->json([
                'message' => 'good',
                'message2' => 'saved'
            ]);

        }
        //END OF EMPLOYEE SIGN OFF

        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    public function viewUnitHeadComments(Request $request){

        $indiGoalSeries = UnitGoalSeries::getAllData();

        return view::make('indi_goals.review_unit_head_comments')->with('mainData',$indiGoalSeries);

    }

    public function reviewUnitHeadComments(Request $request){

        $goalSet = $request->input('goal_set');
        $deptHeads = ApprovalDept::getAllData();
        $headIdArr = [];
        if(!empty($deptHeads)) {
            foreach ($deptHeads as $id) {
                $headIdArr[] = $id->dept_head;
            }
        }
        $commentReviews = IndiGoal::massDataCondition('user_id',$headIdArr,'goal_set_id',$goalSet);
        if(!empty($commentReviews)) {
            return view::make('indi_goals.review_unit_head_comments_reload')->with('mainData', $commentReviews);
        }else{
            return 'Individual goal is yet to be entered by unit heads';
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchIndiGoal(Request $request)
    {
        //
        $goalSet = $request->input('goal_set');
        $dept = $request->input('department');
        $user = $request->input('user');
        $hod = Utility::appSupervisor('appraisal_supervision',Auth::user()->dept_id,Auth::user()->id);
        $lowerHod = Utility::detectHOD(Auth::user()->id);
        $hodId = Utility::appSupervisorId('appraisal_supervision',Auth::user()->dept_id,Auth::user()->dept_id);
        $lowerHodId = Utility::detectHODId(Auth::user()->dept_id);

        $validator = Validator::make($request->all(),IndiGoal::$searchRules);
        if($validator->passes()) {

            $mainData = IndiGoal::specialColumnsPage3('goal_set_id',$goalSet,'dept_id',$dept,'user_id',$user);

            return view::make('indi_goals.search_goal')->with('mainData',$mainData)
                ->with('hod',$hod)->with('lowerHod',$lowerHod)->with('hodId',$hodId)
                ->with('lowerHodId',$lowerHodId)->with('type','data');

        }else{
            $mainData = $validator->errors();
            return view::make('indi_goals.search_goal')->with('mainData',$mainData)->with('type','error');
        }

    }

    public function statusChange(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $status = $request->input('status');
        $dbData = [
            'appraisal_status' => $status
        ];
        $delete = IndiGoal::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
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
        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];
        $delete = IndiGoal::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }


}
