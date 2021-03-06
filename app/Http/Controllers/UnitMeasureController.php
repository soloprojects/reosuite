<?php

namespace App\Http\Controllers;

use App\model\UnitMeasure;
use App\Helpers\Utility;
use App\model\Inventory;
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

class UnitMeasureController extends Controller
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
        $mainData = UnitMeasure::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('inv_unit_measure.reload',array('mainData' => $mainData))->render());

        }else{
            if(Utility::detectSelected('inventory_access',Auth::user()->id))
            return view::make('inv_unit_measure.main_view')->with('mainData',$mainData);
            else
                return view::make('errors.403');
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
        $validator = Validator::make($request->all(),UnitMeasure::$mainRules);
        if($validator->passes()){

            $countData = UnitMeasure::countData('unit_name',$request->input('unit_name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'unit_name' => ucfirst($request->input('unit_name')),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                $pro = UnitMeasure::create($dbDATA);

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
        $dept = UnitMeasure::firstRow('id',$request->input('dataId'));
        return view::make('inv_unit_measure.edit_form')->with('edit',$dept);

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
        $validator = Validator::make($request->all(),UnitMeasure::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'unit_name' => ucfirst($request->input('unit_name')),
                'updated_by' => Auth::user()->id
            ];
            $rowData = UnitMeasure::specialColumns('unit_name', $request->input('code_name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    UnitMeasure::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                UnitMeasure::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
            $rowDataSalary = Inventory::specialColumns('unit_measure',$all_id[$i]);
            if(count($rowDataSalary)>0){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }
        $message = (count($unused) > 0) ? ' and '.count($unused).
            ' unit measure has been used in another module and cannot be deleted' : '';
        if(count($in_use) > 0){
            $delete = UnitMeasure::massUpdate('id',$in_use,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($in_use).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => count($unused).' unit measure has been used in another module and cannot be deleted',
                'message' => 'warning'
            ]);

        }


    }

}
