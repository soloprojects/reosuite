<?php

namespace App\Http\Controllers;

use App\model\Department;
use App\Helpers\Utility;
use App\model\Test;
use App\model\TestCategory;
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

class TestController extends Controller
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
        $mainData = Test::paginateAllData();
        $dept = Department::getAllData();
        $testCategory = TestCategory::getAllData();
        $this->processData($mainData);

        if ($request->ajax()) {
            return \Response::json(view::make('test.reload',array('mainData' => $mainData,
                'dept' => $dept,'testCategory' => $testCategory))->render());

        }else{
            return view::make('test.main_view')->with('mainData',$mainData)->with('dept',$dept)
                ->with('testCategory',$testCategory);
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
        $validator = Validator::make($request->all(),Test::$mainRules);
        if($validator->passes()){

            $deptArr = [];
            $categoryArr = [];
            $allDept = $request->input('department');
            $allCategory = $request->input('test_category');
            foreach($allDept as $dept){
                $deptArr[] = $dept;
            }

            foreach($allCategory as $cat){
                $categoryArr[] = $cat;
            }
            $countData = Test::countData('test_name',$request->input('test_name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                $dbDATA = [
                    'test_name' => ucfirst($request->input('test_name')),
                    'test_desc' => ucfirst($request->input('test_details')),
                    'all_dept' => json_encode($deptArr),
                    'all_category' => json_encode($categoryArr),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                Test::create($dbDATA);

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
        $test = Test::firstRow('id',$request->input('dataId'));
        return view::make('test.edit_form')->with('edit',$test);

    }

    public function editDeptForm(Request $request)
    {
        //
        $test = Test::firstRow('id',$request->input('dataId'));
        $this->processItemData($test);
        return view::make('test.dept_form')->with('edit',$test);

    }

    public function editCatForm(Request $request)
    {
        //
        $test = Test::firstRow('id',$request->input('dataId'));
        $this->processItemData($test);
        return view::make('test.cat_form')->with('edit',$test);

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
        $validator = Validator::make($request->all(),Test::$mainRulesEdit);
        if($validator->passes()) {

            $dbDATA = [
                'test_name' => ucfirst($request->input('test_name')),
                'test_desc' => ucfirst($request->input('test_details')),
                'updated_by' => Auth::user()->id,
            ];
            $rowData = Test::specialColumns('test_name', $request->input('test_name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    Test::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                Test::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
     * ADD/REMOVE FOR TEST DEPARTMENTS the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function modifyDept(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $status = $request->input('status');
        $editId = $request->input('param');
        $test = Test::firstRow('id',$editId);
        $testDept = json_decode($test->all_dept,true);

        $newDept = ($status == '1') ? array_merge($testDept,$idArray) : array_diff($testDept,$idArray);

        $dbData = [
            'all_dept' => json_encode($newDept),
            'updated_by' => Auth::user()->id,
        ];
        $delete = Test::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message2' => 'department(s) modified Successfully',
            'message' => 'saved'
        ]);

    }

    public function modifyCat(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $status = $request->input('status');
        $editId = $request->input('param');
        $test = Test::firstRow('id',$editId);
        $testCat = json_decode($test->all_category,true);

        $newCat = ($status == '1') ? array_merge($testCat,$idArray) : array_diff($testCat,$idArray);

        $dbData = [
            'all_category' => json_encode($newCat),
            'updated_by' => Auth::user()->id,
        ];
        $delete = Test::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message2' => 'department(s) modified Successfully',
            'message' => 'saved'
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
            $request = TestUserAns::firstRow('test_id',$all_id[$i]);
            $requestTemp = TestTempUserAns::firstRow('test_id',$all_id[$i]);
            if(empty($request) && empty($requestTemp)){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }


        $message = (count($in_use) > 0) ? ' and '.count($in_use).
            ' test(s) has been used for a test session and cannot be deleted' : '';

        $delete = Test::massUpdate('id',$unused,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => count($unused).' data(s) has been deleted'.$message
        ]);


    }

    public function processData($data){
        foreach($data as $val){
            $allDept = json_decode($val->all_dept,true);
            $allCategory = json_decode($val->all_category,true);
            if(!empty($allDept)){
                $fetchDept = Department::massData('id',$allDept);
                $val->dept = $fetchDept;
            }else{
                $val->dept = '';
            }

            if(!empty($allCategory)){
                $fetchCategory = TestCategory::massData('id',$allCategory);
                $val->testCategory = $fetchCategory;
            }else{
                $val->testCategory = '';
            }

        }
    }

    public function processItemData($val){
        $testDept = json_decode($val->all_dept,true);
        $testCategory = json_decode($val->all_category,true);
        if(!empty($testDept)){
            $fetchDept = Department::massData('id',$testDept);
            $val->dept = $fetchDept;

            $allDept = Department::getAllData();
            $uniqueDept = Utility::arrayDiff($allDept,$testDept);
            $extraDept = Department::massData('id',$uniqueDept);
            $val->extra_dept = $extraDept;
        }else{
            $val->dept = '';
        }

        if(!empty($testCategory)){
            $fetchCategory = TestCategory::massData('id',$testCategory);
            $val->testCategory = $fetchCategory;

            $allCategory = TestCategory::getAllData();
            $uniqueCategory = Utility::arrayDiff($allCategory,$testCategory);
            $extraCategory = TestCategory::massData('id',$uniqueCategory);
            $val->extra_category = $extraCategory;
        }else{
            $val->extra_category = '';
        }

    }

}
