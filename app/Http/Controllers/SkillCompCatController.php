<?php

namespace App\Http\Controllers;

use App\model\SkillCompCat;
use Illuminate\Http\Request;
use App\model\Department;
use App\model\SkillCompFrame;
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
class SkillCompCatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $mainData = SkillCompCat::paginateAllData();
        $dept = Department::getAllData();
        $compType = SkillCompFrame::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('competency_category.reload',array('mainData' => $mainData,
                'dept' => $dept,'compType' => $compType))->render());

        }else{
            return view::make('competency_category.main_view')->with('mainData',$mainData)
                ->with('dept',$dept)->with('compType',$compType);
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
        $compType = json_decode($request->input('competency_type'));
        $catName= json_decode($request->input('category_name'));
        $dept = json_decode($request->input('department'));
        $desc = json_decode($request->input('desc'));

        $rule = [];
        for($i=0; $i<count($catName);$i++){
            $num = $i+1;
            if($num <=count($catName)) {
                $rule['department' . $num] = 'required';
                $rule['competency_type' . $num] = 'required';
                $rule['category_name' . $num] = 'required';
            }
        }

        $validator = Validator::make($request->all(),$rule);
        if(count($catName) == count($dept) && count($catName) == count($compType)){




            for($i=0;$i<count($catName);$i++){
                $countData = SkillCompCat::countData('category_name',$catName);
                if($countData > 0) {

                    unset($catName[$i]);
                    unset($compType[$i]);
                    unset($dept[$i]);
                    if($i < (count($desc)-1)) {
                        unset($desc[$i]);
                    }
                }

            }
            for($i=0;$i<count($catName);$i++) {
                $mDesc = '';
                if($i < (count($desc)-1)) {
                    $mDesc = $desc[$i];
                }
                $dbDATA = [
                    'category_name' => $catName[$i],
                    'skill_comp_id' => $compType[$i],
                    'dept_id' => $dept[$i],
                    'cat_desc' => $mDesc,
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                SkillCompCat::create($dbDATA);
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
       /* $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);*/


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
        $skill = SkillCompCat::firstRow('id',$request->input('dataId'));
        $dept = Department::getAllData();
        $compType = SkillCompFrame::getAllData();
        return view::make('competency_category.edit_form')->with('edit',$skill)->with('dept',$dept)
            ->with('compType',$compType);

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

        $validator = Validator::make($request->all(),SkillCompCat::$mainRules);
        if($validator->passes()) {


            $dbDATA = [
                'category_name' => ucfirst($request->input('category_name')),
                'skill_comp_id' => $request->input('competency_type'),
                'cat_desc' => $request->input('description'),
                'updated_by' => Auth::user()->id
            ];
            $rowData = SkillCompCat::specialColumns('category_name', $request->input('category_name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    SkillCompCat::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                SkillCompCat::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
        $delete = SkillCompCat::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);
    }
}
