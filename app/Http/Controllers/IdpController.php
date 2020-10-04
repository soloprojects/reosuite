<?php

namespace App\Http\Controllers;

use App\Helpers\Notify;
use App\model\IdpCompetency;
use App\model\Idp;
use App\model\SkillCompCat;
use App\Helpers\Utility;
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

class IdpController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $mainData = (in_array(Auth::user()->role,Utility::HR_MANAGEMENT)) ? Idp::paginateAllData() : Idp::specialColumnsPage('user_id',Auth::user()->id);
        $coachData = Idp::specialColumns('coach_id',Auth::user()->id);
        $techComp = SkillCompCat::specialColumns2('dept_id',Auth::user()->dept_id,'skill_comp_id',Utility::COMP_ASSESS);

        if ($request->ajax()) {
            return \Response::json(view::make('idp.reload',array('mainData' => $mainData,'coachData' => $coachData
            ,'techComp' => $techComp))->render());

        }else{
            return view::make('idp.main_view')->with('mainData',$mainData)->with('coachData',$coachData)
                ->with('techComp',$techComp);
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
        $validator = Validator::make($request->all(), Idp::$mainRules);
        if ($validator->passes()) {

            $coachId = $request->input('user');
            $coach = User::firstRow('id',$coachId);

            $objContent = new \stdClass();
            $objContent->sender_name = Auth::user()->firstname.'&nbsp;'.Auth::user()->lastname;
            $objContent->receiver_name = $coach->firstname.'&nbsp;'.$coach->lastname;
            $objContent->type = 'Individual Development Plan';

                    $coreComp = json_decode($request->input('core_comp'));
                    $capable = json_decode($request->input('capable'));
                    $compLevel = json_decode($request->input('level'));

                    if (count($coreComp) == count($capable)) {

                        $dbDATA = [
                            'coach_id' => $coachId,
                            'short_term' => $request->input('short_term'),
                            'long_term' => $request->input('long_term'),
                            'user_id' => Auth::user()->id,
                            'user_competency' => Auth::user()->dept_id,
                            'dev_obj' => $request->input('dev_obj'),
                            'dev_assign' => $request->input('dev_assign'),
                            'other_act' => $request->input('other_acts'),
                            'remarks' => $request->input('remarks'),
                            'formal_training' => $request->input('short_term'),
                            'target_comp_date' => Utility::standardDate($request->input('target_completed_date')),
                            'actual_comp_date' => Utility::standardDate($request->input('actual_completed_date')),
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];

                        $createIndiDev = Idp::create($dbDATA);


                        for ($i = 0; $i < count($coreComp); $i++) {

                            $dbDATA2 = [
                                'core_comp' => $coreComp[$i],
                                'capability' => $capable[$i],
                                'idp_id' => $createIndiDev->id,
                                'level' => $compLevel[$i],
                                'created_by' => Auth::user()->id,
                                'status' => Utility::STATUS_ACTIVE
                            ];

                            IdpCompetency::create($dbDATA2);
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
        $indiDev = Idp::firstRow('id',$request->input('dataId'));

        $techComp = SkillCompCat::specialColumns2('dept_id',Auth::user()->dept_id,'skill_comp_id',Utility::COMP_ASSESS);

        return view::make('idp.edit_form')->with('edit',$indiDev)->with('techComp',$techComp);


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
        $validator = Validator::make($request->all(),Idp::$mainRules);
        if($validator->passes()) {


            $editUserId = $request->input('edit_user_id');

                $coreComp = json_decode($request->input('core_comp'));
                $capable = json_decode($request->input('capable'));
                $compLevel = json_decode($request->input('level'));
                $countExt = intval($request->input('count_ext'));

                if (count($coreComp) >0 || count($capable) >0) {

                    //UPDATE EXISTING DATA

                    if(Auth::user()->id == $editUserId) {

                        if (count($coreComp) == count($capable) || count($coreComp) == count($compLevel)) {

                            $dbDATA = [
                                'coach_id' => $request->input('user'),
                                'short_term' => $request->input('short_term'),
                                'long_term' => $request->input('long_term'),
                                'dev_obj' => $request->input('dev_obj'),
                                'dev_assign' => $request->input('dev_assign'),
                                'other_act' => $request->input('other_activities'),
                                'remarks' => $request->input('remarks'),
                                'formal_training' => $request->input('formal_training'),
                                'target_comp_date' => Utility::standardDate($request->input('target_completed_date')),
                                'actual_comp_date' => Utility::standardDate($request->input('actual_completed_date')),
                                'created_by' => Auth::user()->id,
                                'status' => Utility::STATUS_ACTIVE
                            ];
                            Idp::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                            for ($i = 1; $i <= $countExt; $i++) {
                                $dbDATA2 = [
                                    'core_comp' => $request->input('core_comp_edit' . $i),
                                    'capability' => $request->input('capable_edit' . $i),
                                    'level' => $request->input('comp_level_edit' . $i),
                                    'updated_by' => Auth::user()->id,
                                ];

                                IdpCompetency::defaultUpdate('id', $request->input('ext_id' . $i), $dbDATA2);
                            }   //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

                            //CREATE NEW DATA
                            for ($i = 0; $i < count($coreComp); $i++) {

                                $dbDATA2 = [
                                    'core_comp' => $coreComp[$i],
                                    'capability' => $capable[$i],
                                    'level' => $compLevel[$i],
                                    'idp_id' => $request->input('edit_id'),
                                    'created_by' => Auth::user()->id,
                                    'status' => Utility::STATUS_ACTIVE
                                ];

                                IdpCompetency::create($dbDATA2);
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

                    $dbDATA = [
                        'coach_id' => $request->input('user'),
                        'short_term' => $request->input('short_term'),
                        'long_term' => $request->input('long_term'),
                        'dev_obj' => $request->input('dev_obj'),
                        'dev_assign' => $request->input('dev_assign'),
                        'other_act' => $request->input('other_activities'),
                        'remarks' => $request->input('remarks'),
                        'formal_training' => $request->input('formal_training'),
                        'target_comp_date' => Utility::standardDate($request->input('target_completed_date')),
                        'actual_comp_date' => Utility::standardDate($request->input('actual_completed_date')),
                        'updated_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];


                    Idp::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                    //UPDATE EXISTING DATA

                        for ($i = 1; $i <= $countExt; $i++) {
                            $dbDATA2 = [
                                'core_comp' => $request->input('core_comp_edit' . $i),
                                'capability' => $request->input('capable_edit' . $i),
                                'level' => $request->input('comp_level_edit' . $i),
                                'updated_by' => Auth::user()->id,
                            ];

                            IdpCompetency::defaultUpdate('id', $request->input('ext_id' . $i), $dbDATA2);
                        }


                    //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

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
    public function searchIndiGoal(Request $request)
    {
        //

        $user = $request->input('user');


        $validator = Validator::make($request->all(),Idp::$searchRules);
        if($validator->passes()) {

            $mainData = Idp::specialColumnsPage('user_id',$user);

            return view::make('idp.search_goal')->with('mainData',$mainData)->with('type','data');

        }else{
            $mainData = $validator->errors();
            return view::make('idp.search_goal')->with('mainData',$mainData)->with('type','error');
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
        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];
        $delete = Idp::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }


}
