<?php

namespace App\Http\Controllers;

use App\model\CompetencyMap;
use App\model\SkillCompFrame;
use App\model\SkillCompCat;
use Illuminate\Http\Request;
use App\model\Department;
use App\model\Position;
use App\Helpers\Utility;
use App\User;
use Auth;
use View;
use Validator;
use Input;
use Hash;
use DB;
use Intervention\Image\Facades\Image;
use App\Http\Requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class CompetencyMapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $techCompCat = SkillCompCat::specialColumns('skill_comp_id',Utility::TECH_COMP);
        $behavCompCat = SkillCompCat::specialColumns('skill_comp_id',Utility::BEHAV_COMP);
        $mainData = CompetencyMap::paginateAllData();
        $dept = Department::getAllData();
        $compType = SkillCompFrame::getAllData();
        $position = Position::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('competency_map.reload',array('mainData' => $mainData,
                'dept' => $dept,'compType' => $compType,'position' => $position,'techCompCat' => $techCompCat
            ,'behavCompCat' => $behavCompCat))->render());

        }else{
            return view::make('competency_map.main_view')->with('mainData',$mainData)
                ->with('dept',$dept)->with('compType',$compType)->with('position',$position)
                ->with('techCompCat',$techCompCat)->with('behavCompCat',$behavCompCat);
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

        $compType = $request->input('competency_type');
        $userId = $request->input('user');

        $validator = Validator::make($request->all(),CompetencyMap::$mainRules);
        if($validator->passes()) {
            if ($compType == Utility::PRO_QUAL) {

                $min_aca_qual = json_decode($request->input('min_aca_qual'));
                $dept = json_decode($request->input('department'));
                $position = json_decode($request->input('position'));
                $pro_qual = json_decode($request->input('pro_qual'));
                $cog_exp = json_decode($request->input('cog_exp'));
                $yr_post_cert = json_decode($request->input('yr_post_cert'));

                if (!empty($compCat) && !empty($position) && !empty($dept)) {


                    for ($i = 0; $i < count($dept); $i++) {

                        $dbDATA = [
                            'dept_id' => Utility::checkEmptyArrayItem($dept,$i,0),
                            'position_id' => Utility::checkEmptyArrayItem($position,$i,0),
                            'min_aca_qual' => Utility::checkEmptyArrayItem($min_aca_qual,$i,0),
                            'comp_category' => $compType,
                            'pro_qual' =>Utility::checkEmptyArrayItem($pro_qual,$i,''),
                            'cog_exp' => Utility::checkEmptyArrayItem($cog_exp,$i,0),
                            'user_id' => $userId,
                            'yr_post_cert' => Utility::checkEmptyArrayItem($yr_post_cert,$i,0),
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];

                        CompetencyMap::create($dbDATA);
                    }

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);


                }

                return response()->json([
                    'message' => 'warning',
                    'message2' => 'Please fill in all required fields'
                ]);

            }

            if ($compType == Utility::TECH_COMP) {

                $compCat = json_decode($request->input('competency_category'));
                $dept = json_decode($request->input('department'));
                $position = json_decode($request->input('position'));
                $level = json_decode($request->input('level'));
                $techDesc = json_decode($request->input('tech_desc'));
                //$techDesc1 = explode(',',$request->input('tech_desc'));
                /*return response()->json([
                    'message' => 'warning',
                    'message2' => count($techDesc).$request->input('tech_desc')
                ]);*/
                if (!empty($compCat) && !empty($position) && !empty($dept)) {


                    for ($i = 0; $i < count($dept); $i++) {

                        $dbDATA = [
                            'dept_id' => Utility::checkEmptyArrayItem($dept,$i,0),
                            'position_id' => Utility::checkEmptyArrayItem($position,$i,0),
                            'comp_category' => $compType,
                            'sub_comp_cat' => Utility::checkEmptyArrayItem($compCat,$i,0),
                            'comp_level' => Utility::checkEmptyArrayItem($level,$i,0),
                            'item_desc' => Utility::checkEmptyArrayItem($techDesc,$i,''),
                            'user_id' => $userId,
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];

                        CompetencyMap::create($dbDATA);
                    }

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);


                }

                return response()->json([
                    'message' => 'warning',
                    'message2' => 'Please fill in all required fields'
                ]);

            }

            if ($compType == Utility::BEHAV_COMP) {

                $compCat = json_decode($request->input('competency_category'));
                $catDesc = json_decode($request->input('category_desc'));
                $dept = json_decode($request->input('department'));
                $position = json_decode($request->input('position'));
                $level = json_decode($request->input('level'));

                if (!empty($compCat) && !empty($position) && !empty($dept)) {


                    for ($i = 0; $i < count($dept); $i++) {

                        $dbDATA = [
                            'dept_id' => Utility::checkEmptyArrayItem($dept,$i,0),
                            'position_id' => Utility::checkEmptyArrayItem($position,$i,0),
                            'comp_category' => $compType,
                            'sub_comp_cat' => Utility::checkEmptyArrayItem($compCat,$i,0),
                            'comp_level' => Utility::checkEmptyArrayItem($level,$i,0),
                            'item_desc' => Utility::checkEmptyArrayItem($catDesc,$i,''),
                            'user_id' => $userId,
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];

                        CompetencyMap::create($dbDATA);
                    }

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);


                }

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
        $skill = CompetencyMap::firstRow('id',$request->input('dataId'));
        $techCompCat = SkillCompCat::specialColumns('skill_comp_id',Utility::TECH_COMP);
        $behavCompCat = SkillCompCat::specialColumns('skill_comp_id',Utility::BEHAV_COMP);
        $dept = Department::getAllData();
        $position = Position::getAllData();
        return view::make('competency_map.edit_form')->with('edit',$skill)->with('dept',$dept)
            ->with('techCompCat',$techCompCat)->with('behavCompCat',$behavCompCat)->with('position',$position);

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

        $validator = Validator::make($request->all(),CompetencyMap::$editRules);
        if($validator->passes()) {

            $compType = $request->input('comp_type');
            $dbDATA = [];

            if($compType == Utility::PRO_QUAL) {

                $min_aca_qual= $request->input('min_aca_qual');
                $dept = $request->input('department');
                $position = $request->input('position');
                $pro_qual = $request->input('pro_qual');
                $cog_exp = $request->input('cog_exp');
                $yr_post_cert = $request->input('yr_post_cert');

                $dbDATA = [
                    'dept_id' => $dept,
                    'position_id' => $position,
                    'min_aca_qual' => $min_aca_qual,
                    'pro_qual' => $pro_qual,
                    'cog_exp' => $cog_exp,
                    'yr_post_cert' => $yr_post_cert,
                    'updated_by' => Auth::user()->id
                ];
            }

            if($compType == Utility::TECH_COMP) {

                $compCat = $request->input('competency_category');
                $dept = $request->input('department');
                $position = $request->input('position');
                $level = $request->input('tech_level');
                $catDesc = $request->input('cat_desc');

                $dbDATA = [
                    'dept_id' => $dept,
                    'position_id' => $position,
                    'sub_comp_cat' => $compCat,
                    'comp_level' => $level,
                    'item_desc' => $catDesc,
                    'updated_by' => Auth::user()->id
                ];
            }

            if($compType == Utility::BEHAV_COMP) {

                $compCat = $request->input('competency_category');
                $catDesc= $request->input('category_desc');
                $dept = $request->input('department');
                $position = $request->input('position');
                $level = $request->input('behav_level');

                $dbDATA = [
                    'dept_id' => $dept,
                    'position_id' => $position,
                    'sub_comp_cat' => $compCat,
                    'comp_level' => $level,
                    'item_desc' => $catDesc,
                    'updated_by' => Auth::user()->id
                ];
            }

            CompetencyMap::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchFrame(Request $request)
    {
        //
        $compCat = $request->input('competency_category');
        $compType = $request->input('competency_type');
        $dept = $request->input('department');
        $user = $request->input('user');

        $validator = Validator::make($request->all(),CompetencyMap::$searchRules);
        if($validator->passes()) {


            if ($compType == Utility::PRO_QUAL) {
                $mainData = CompetencyMap::specialColumns3('dept_id', $dept, 'user_id', $user, 'comp_category', $compType);
                return view::make('competency_map.search_frame')->with('mainData', $mainData)->with('type', Utility::PRO_QUAL);

            }
            if($compType == Utility::TECH_COMP) {
                $mainData = CompetencyMap::specialColumns3('dept_id', $dept, 'user_id', $user, 'comp_category', $compType);
                return view::make('competency_map.search_frame')->with('mainData', $mainData)->with('type', Utility::TECH_COMP);

            }
            if($compType == Utility::BEHAV_COMP) {
                $mainData = CompetencyMap::specialColumns3('dept_id', $dept, 'user_id', $user, 'comp_category', $compType);
                return view::make('competency_map.search_frame')->with('mainData', $mainData)->with('type', Utility::BEHAV_COMP);

            }

        }else{
            $mainData = $validator->errors();
            return view::make('competency_map.search_frame')->with('mainData',$mainData)->with('type','error');
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
        $delete = CompetencyMap::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);
    }
}
