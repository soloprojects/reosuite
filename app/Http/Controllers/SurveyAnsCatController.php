<?php

namespace App\Http\Controllers;

use App\model\RequestCategory;
use App\model\AccountCategory;
use App\model\Department;
use App\Helpers\Utility;
use App\model\Requisition;
use App\model\SurveyAnsCat;
use App\model\SurveyQuestAns;
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

class SurveyAnsCatController extends Controller
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
        $mainData = SurveyAnsCat::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('survey_ans_category.reload',array('mainData' => $mainData,))->render());

        }else{
            return view::make('survey_ans_category.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),SurveyAnsCat::$mainRules);
        if($validator->passes()){


            $countData = SurveyAnsCat::countData('category_name',$request->input('answer_category'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'category_name' => ucfirst($request->input('answer_category')),
                    'rating' => $request->input('rating'),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                SurveyAnsCat::create($dbDATA);

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editForm(Request $request)
    {
        //
        $ansCat = SurveyAnsCat::firstRow('id',$request->input('dataId'));
        return view::make('survey_ans_category.edit_form')->with('edit',$ansCat);

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
        $validator = Validator::make($request->all(),SurveyAnsCat::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'category_name' => ucfirst($request->input('answer_category')),
                'rating' => $request->input('rating'),
                'updated_by' => Auth::user()->id,
            ];
            $rowData = SurveyAnsCat::specialColumns('category_name', $request->input('answer_category'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    SurveyAnsCat::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                SurveyAnsCat::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
        $all_id = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];

        $in_use = [];
        $unused = [];
        for($i=0;$i<count($all_id);$i++){
            $request = SurveyQuestAns::firstRow('ans_cat_id',$all_id[$i]);
            if(empty($request)){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }


        $message = (count($in_use) > 0) ? ' and '.count($in_use).
            ' category(ies) has been used for a survey and cannot be deleted' : '';

            $delete = SurveyAnsCat::massUpdate('id',$unused,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($unused).' data(s) has been deleted'.$message
            ]);


    }

}
