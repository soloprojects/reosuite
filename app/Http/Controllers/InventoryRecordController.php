<?php

namespace App\Http\Controllers;

use App\model\Department;
use Illuminate\Http\Request;
use App\model\InventoryRecord;
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

class InventoryRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $mainData = InventoryRecord::paginateAllData();
        $dept = Department::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('inventory_record.reload',array('mainData' => $mainData,
            'dept' => $dept))->render());

        }else{
            if(Utility::detectSelected('inventory_access',Auth::user()->id))
            return view::make('inventory_record.main_view')->with('mainData',$mainData)->with('dept',$dept);
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
        $item = $request->input('item');
        $dept = $request->input('department');
        $item_desc = $request->input('item_description');
        $serial_no = $request->input('serial_no');
        $condition = $request->input('item_condition');
        $warranty = $request->input('warranty_expiry');

        $validator = Validator::make($request->all(),InventoryRecord::$mainRules);
        if($validator->passes()){

                $dbDATA = [
                    'item_id' => $item,
                    'dept_id' => $dept,
                    'item_desc' => $item_desc,
                    'serial_no' => $serial_no,
                    'item_condition' => $condition,
                    'warranty_expiry_date' => $warranty,
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                InventoryRecord::create($dbDATA);

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editForm(Request $request)
    {
        //
        $data = InventoryRecord::firstRow('id',$request->input('dataId'));
        $dept = Department::getAllData();
        return view::make('inventory_record.edit_form')->with('edit',$data)->with('dept',$dept);

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
        $mainRules = [];

        $validator = Validator::make($request->all(),$mainRules);
        if($validator->passes()) {

            $item = $request->input('item');
            $dept= $request->input('department');
            $item_desc = $request->input('item_description');
            $serial_no = $request->input('serial_no');
            $condition = $request->input('item_condition');
            $warranty = $request->input('warranty_expiry');

            $dbDATA = [
                'item_id' => $item,
                'dept_id' => $dept,
                'item_desc' => $item_desc,
                'serial_no' => $serial_no,
                'item_condition' => $condition,
                'warranty_expiry_date' => $warranty,
                'created_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];

            InventoryRecord::defaultUpdate('id',$request->input('edit_id'),$dbDATA);

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

    public function searchInventoryRecord(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = InventoryRecord::searchInventoryRecord($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->id;
        }
        /*for($i=0;$i<count($search);$i++){
            $obtain_array[] = $search[$i]->id;
        }*/
        //print_r($obtain_array); exit();
        $user_ids = array_unique($obtain_array);
        $mainData =  InventoryRecord::massDataPaginate('id', $user_ids);
        //print_r($user_ids); die();
        if (count($user_ids) > 0) {

            return view::make('inventory_record.inventory_search')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
        }

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
        $delete = InventoryRecord::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);
    }
}
