<?php

namespace App\Http\Controllers;

use App\model\Inventory;
use App\model\InventoryCategory;
use App\model\Department;
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

class InventoryCategoryController extends Controller
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
        $mainData = InventoryCategory::paginateAllData();
        $hod = Utility::detectHOD(Auth::user()->id);

        if ($request->ajax()) {
            return \Response::json(view::make('inventory_category.reload',array('mainData' => $mainData,
                'hod' => $hod))->render());

        }else{
            if(Utility::detectSelected('inventory_access',Auth::user()->id))
            return view::make('inventory_category.main_view')->with('mainData',$mainData)->with('hod',$hod);
            else
            return '<h2>You do not have access to this module, please see your administrator or navigate to configuration to module access grant to config inventory system access</h2>';
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
        $validator = Validator::make($request->all(),InventoryCategory::$mainRules);
        if($validator->passes()){

            $countData = InventoryCategory::countData('category_name',$request->input('category_name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'category_name' => ucfirst($request->input('category_name')),
                    'cat_desc' => ucfirst($request->input('description')),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                InventoryCategory::create($dbDATA);

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
        $request = InventoryCategory::firstRow('id',$request->input('dataId'));
        return view::make('inventory_category.edit_form')->with('edit',$request);

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
        $validator = Validator::make($request->all(),InventoryCategory::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'category_name' => ucfirst($request->input('category_name')),
                'cat_desc' => ucfirst($request->input('description')),
                'updated_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            $rowData = InventoryCategory::specialColumns('category_name', $request->input('category_name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    InventoryCategory::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                InventoryCategory::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
            $rowDataCategory = Inventory::specialColumns('category_id', $all_id[$i]);
            if(count($rowDataCategory)>0){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }
        $message = (count($unused) > 0) ? ' and '.count($unused).
            ' category(ies) has been used in another module and cannot be deleted' : '';
        if(count($in_use) > 0){
            $delete = InventoryCategory::massUpdate('id',$in_use,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($in_use).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($unused).' category(ies) has been used in another module and cannot be deleted',
                'message' => 'warning'
            ]);

        }


    }

}
