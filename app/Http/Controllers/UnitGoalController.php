<?php

namespace App\Http\Controllers;

use App\model\Department;
use App\model\UnitGoal;
use App\Helpers\Utility;
use App\model\UnitGoalCat;
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


class UnitGoalController extends Controller
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
        $mainData = (in_array(Auth::user()->id,Utility::HR_MANAGEMENT)) ? UnitGoal::paginateAllData() : UnitGoal::specialColumnsPage('dept_id',Auth::user()->dept_id);
        $unitGoalCat = UnitGoalCat::getAllData();
        $unitGoalSeries = UnitGoalSeries::getAllData();
        $department = Department::getAllData();
        $hod = Utility::appSupervisor('appraisal_supervision',Auth::user()->dept_id,Auth::user()->id);
        $lowerHod = Utility::detectHOD(Auth::user()->id);

        if ($request->ajax()) {
            return \Response::json(view::make('unit_goals.reload',array('mainData' => $mainData,'unitGoalCat' => $unitGoalCat
            ,'unitGoalSeries' => $unitGoalSeries,'hod' => $hod,'loverHod' => $lowerHod,
                'dept' => $department))->render());

        }else{
            return view::make('unit_goals.main_view')->with('mainData',$mainData)->with('unitGoalCat',$unitGoalCat)
                ->with('unitGoalSeries',$unitGoalSeries)->with('hod',$hod)->with('lowerHod',$lowerHod)
                ->with('dept',$department);
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
        $hodId = Utility::appSupervisorId('appraisal_supervision',Auth::user()->dept_id,Auth::user()->id);
        $lowerHodId = Utility::detectHODId(Auth::user()->dept_id);
        $lowerHod = Utility::detectHOD(Auth::user()->id);
        $lowerHodMail = User::firstRow('id',$lowerHodId);
        $hodMail = User::firstRow('id',$hodId);

        $mainUser = ($lowerHod == Utility::HOD_DETECTOR) ? $hodMail : $lowerHodMail;
        if($hodId == 0){
            return response()->json([
                'message' => 'warning',
                'message2' => 'Please, select an appraisal supervisor for this department in the HR section'
            ]);
        }

        $objContent = new \stdClass();
        $objContent->sender_name = Auth::user()->firstname.'&nbsp;'.Auth::user()->lastname;
        $objContent->receiver_name = $mainUser->firstname.'&nbsp;'.$mainUser->lastname;
        $objContent->type = 'Unit Goal';

        $validator = Validator::make($request->all(),UnitGoal::$mainRules);
        if($validator->passes()){

            $stratObj= json_decode($request->input('strat_obj'));
            $measure = json_decode($request->input('measure'));
            $ops = json_decode($request->input('ops'));
            $q1 = json_decode($request->input('q1'));
            $q2 = json_decode($request->input('q2'));
            $q3 = json_decode($request->input('q3'));
            $q4 = json_decode($request->input('q4'));
            $goalSet = $request->input('goal_set');
            $unitGoalCat = $request->input('unit_goal_category');
            $wps = $request->input('wps');
            $program = $request->input('program');

            if (count($stratObj) == count($measure) &&
                count($stratObj) == count($q1) && count($stratObj) == count($q2) &&
                count($stratObj) == count($q3) && count($stratObj) == count($q4)) {


                $dbDATA = [
                    'goal_set_id' => $goalSet,
                    'weight_perf_score' => $wps,
                    'program' => $program,
                    'unit_goal_cat' => $unitGoalCat,
                    'dept_id' => Auth::user()->dept_id,
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                $createUnitGoal = UnitGoal::create($dbDATA);


                for ($i = 0; $i < count($stratObj); $i++) {

                    $dbDATA2 = [
                        'strat_obj' => htmlentities($stratObj[$i]),
                        'measurement' => htmlentities($measure[$i]),
                        //'over_perf_score' => htmlentities($ops[$i]),
                        'unit_goal_id' => $createUnitGoal->id,
                        'q1' => htmlentities($q1[$i]),
                        'q2' => htmlentities($q2[$i]),
                        'q3' => htmlentities($q3[$i]),
                        'q4' => htmlentities($q4[$i]),
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];

                    UnitGoalExt::create($dbDATA2);
                }

                /*$objContent->goal_set = $goalSet;
                   $objContent->comp_type = $unitGoalCat;
                   Notify::appraisalMail('mail.appraisal',$objContent,$mainUser->email);*/

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);


            }else {

                return response()->json([
                    'message' => 'warning',
                    'message2' => 'Please fill in all required fields'
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
        $unitGoal = UnitGoal::firstRow('id',$request->input('dataId'));
        $unitGoalCat = UnitGoalCat::getAllData();
        $unitGoalSeries = UnitGoalSeries::getAllData();
        $hod = Utility::appSupervisor('appraisal_supervision',$unitGoal->dept_id,Auth::user()->id);
        $lowerHod = Utility::detectHOD(Auth::user()->id);

        return view::make('unit_goals.edit_form')->with('edit',$unitGoal)->with('unitGoalCat',$unitGoalCat)
            ->with('hod',$hod)->with('unitGoalSeries',$unitGoalSeries)->with('lowerHod',$lowerHod);

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
        $validator = Validator::make($request->all(),UnitGoal::$mainRules);
        if($validator->passes()) {

            $unitGoalId = $request->input('goal_set_id');
            $countExt = intval($request->input('count_ext'));
            $stratObj= json_decode($request->input('strat_obj'));
            $measure = json_decode($request->input('measure'));
            $ops = json_decode($request->input('ops'));
            $q1 = json_decode($request->input('q1'));
            $q2 = json_decode($request->input('q2'));
            $q3 = json_decode($request->input('q3'));
            $q4 = json_decode($request->input('q4'));
            $goalSet = $request->input('goal_set');
            $unitGoalCat = $request->input('unit_goal_category');
            $wps = $request->input('wps');
            $program = $request->input('program');

            $hod = Utility::appSupervisor('appraisal_supervision',Auth::user()->dept_id,Auth::user()->id);
            $lowerHod = Utility::detectHOD(Auth::user()->id);


            if (count($stratObj) > 0 || count($measure) > 0 ||  count($ops) > 0 ||
                count($q1) > 0 ||  count($q2) > 0 || count($q3) > 0 &&  count($q4) > 0) {

                if($hod == Utility::HOD_DETECTOR){

                    if (count($ops) > 0) {

                        $dbDATA = [
                            'goal_set_id' => $goalSet,
                            'weight_perf_score' => $wps,
                            'program' => $program,
                            'unit_goal_cat' => $unitGoalCat,
                            'dept_id' => Auth::user()->dept_id,
                            'updated_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];
                        UnitGoal::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                        //UPDATE EXISTING DATA


                        for ($i = 0; $i < $countExt; $i++) {
                            $dbDATA2 = [
                                'over_perf_score' => $request->input('ops_edit' . $i),
                                'updated_by' => Auth::user()->id,
                            ];

                            UnitGoalExt::defaultUpdate('id', $request->input('ext_id' . $i), $dbDATA2);
                        }   //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

                        //CREATE NEW DATA
                        for ($i = 0; $i < count($ops); $i++) {

                            $dbDATA2 = [
                                'over_perf_score' => $ops[$i],
                                'unit_goal_id' => $request->input('edit_id'),
                                'updated_by' => Auth::user()->id,
                                'status' => Utility::STATUS_ACTIVE
                            ];

                            UnitGoalExt::create($dbDATA2);
                        }

                        return response()->json([
                            'message' => 'good',
                            'message2' => 'saved'
                        ]);



                    }else{  //END OF IF EVERYTHING IS SUCCESSFUL WITH EXISTING AND EXTRA COLUMNS

                        return response()->json([
                            'message' => 'warning',
                            'message2' => 'Please fill in all required fields'
                        ]);
                    }


                }else{  //END OF IF USER IS THE SUPERVISOR

                    if (count($stratObj) == count($measure) &&
                        count($stratObj) == count($q1) && count($stratObj) == count($q2) &&
                        count($stratObj) == count($q3) && count($stratObj) == count($q4)) {


                        $dbDATA = [
                            'goal_set_id' => $goalSet,
                            'weight_perf_score' => $wps,
                            'program' => $program,
                            'unit_goal_cat' => $unitGoalCat,
                            'dept_id' => Auth::user()->dept_id,
                            'updated_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];
                        UnitGoal::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                        //UPDATE EXISTING DATA


                        for ($i = 0; $i < $countExt; $i++) {
                            $dbDATA2 = [
                                'strat_obj' => $request->input('strat_obj_edit' . $i),
                                'measurement' => $request->input('measure_edit' . $i),
                                'q1' => $request->input('q1_edit' . $i),
                                'q2' => $request->input('q2_edit' . $i),
                                'q3' => $request->input('q3_edit' . $i),
                                'q4' => $request->input('q4_edit' . $i),
                                'updated_by' => Auth::user()->id,
                            ];

                            UnitGoalExt::defaultUpdate('id', $request->input('ext_id' . $i), $dbDATA2);
                        }   //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

                        //CREATE NEW DATA
                        for ($i = 0; $i < count($stratObj); $i++) {

                            $dbDATA2 = [
                                'strat_obj' => $stratObj[$i],
                                'measurement' => $measure[$i],
                                'unit_goal_id' => $request->input('edit_id'),
                                'q1' => $q1[$i],
                                'q2' => $q2[$i],
                                'q3' => $q3[$i],
                                'q4' => $q4[$i],
                                'created_by' => Auth::user()->id,
                                'status' => Utility::STATUS_ACTIVE
                            ];

                            UnitGoalExt::create($dbDATA2);
                        }

                        return response()->json([
                            'message' => 'good',
                            'message2' => 'saved'
                        ]);



                    }else{  //END OF IF EVERYTHING IS SUCCESSFUL WITH EXISTING AND EXTRA COLUMNS

                        return response()->json([
                            'message' => 'warning',
                            'message2' => 'Please fill in all required fields'
                        ]);
                    }


                }


            }else{  //END OF IF $stratObj IS GREATER THAN 0

                if($hod == Utility::HOD_DETECTOR){

                    $dbDATA = [
                        'goal_set_id' => $goalSet,
                        'weight_perf_score' => $wps,
                        'program' => $program,
                        'unit_goal_cat' => $unitGoalCat,
                        'updated_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];
                    UnitGoal::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                    for($i=1; $i<=$countExt;$i++){
                        $dbDATA2 = [

                            'over_perf_score' => $request->input('ops_edit' . $i),
                            'updated_by' => Auth::user()->id,
                        ];

                        UnitGoalExt::defaultUpdate('id', $request->input('ext_id'.$i), $dbDATA2);
                    }

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);


                }
                //END OF UPDATE WITHOUT NEW ENTRIES FOR HOD DETECTOR

                $dbDATA = [
                    'goal_set_id' => $goalSet,
                    'weight_perf_score' => $wps,
                    'program' => $program,
                    'unit_goal_cat' => $unitGoalCat,
                    'updated_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                UnitGoal::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                for($i=1; $i<=$countExt;$i++){
                    $dbDATA2 = [
                        'strat_obj' => $request->input('strat_obj_edit'.$i),
                        'measurement' => $request->input('measure_edit'.$i),
                        'over_perf_score' => $request->input('over_perf_score_edit'.$i),
                        'q1' => $request->input('q1_edit'.$i),
                        'q2' => $request->input('q2_edit'.$i),
                        'q3' => $request->input('q3_edit'.$i),
                        'q4' => $request->input('q4_edit'.$i),
                        'updated_by' => Auth::user()->id,
                    ];

                    UnitGoalExt::defaultUpdate('id', $request->input('ext_id'.$i), $dbDATA2);
                }

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

            }   //END OF IF $stratObj IS NOT GREATER THAN 0

        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchUnitGoal(Request $request)
    {
        //
        $goalSet = $request->input('goal_set');
        $dept = $request->input('department');
        $hod = Utility::appSupervisor('appraisal_supervision',Auth::user()->dept_id,Auth::user()->id);
        $lowerHod = Utility::detectHOD(Auth::user()->id);
        $hodId = Utility::appSupervisorId('appraisal_supervision',Auth::user()->dept_id,Auth::user()->dept_id);
        $lowerHodId = Utility::detectHODId(Auth::user()->dept_id);

        $validator = Validator::make($request->all(),UnitGoal::$searchRules);
        if($validator->passes()) {

            $mainData = UnitGoal::specialColumnsPage2('goal_set_id',$goalSet,'dept_id',$dept);

            return view::make('unit_goals.search_goal')->with('mainData',$mainData)
                ->with('hod',$hod)->with('lowerHod',$lowerHod)->with('hodId',$hodId)
                ->with('lowerHodId',$lowerHodId)->with('type','data');

        }else{
            $mainData = $validator->errors();
            return view::make('unit_goals.search_goal')->with('mainData',$mainData)->with('type','error');
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
        $delete = UnitGoal::massUpdate('id',$idArray,$dbData);

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
        $delete = UnitGoal::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

}
