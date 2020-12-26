<?php

namespace App\Http\Controllers;

use App\model\Inventory;
use Illuminate\Http\Request;
use App\model\InventoryAssign;
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

class InventoryAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $mainData = InventoryAssign::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('inventory_assign.reload',array('mainData' => $mainData))->render());

        }else{
            if(Utility::detectSelected('inventory_access',Auth::user()->id))
            return view::make('inventory_assign.main_view')->with('mainData',$mainData);
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
        $item = json_decode($request->input('item'));
        $user= json_decode($request->input('user'));
        $location = json_decode($request->input('location'));
        $qty = json_decode($request->input('qty'));
        $desc = json_decode($request->input('desc'));

        $rule = [];

        if(count($item) <= 0 || count($user) <= 0){
            return response()->json([
                'message' => 'warning',
                'message2' => 'Please select an item to continue'
            ]);
        }

        $validator = Validator::make($request->all(),$rule);
        if(count($item) == count($qty) && count($item) == count($user)){

            for($i=0;$i<count($item);$i++) {
                if(empty($user[$i])) {
                    $user[$i] = '';
                }
                if(empty($location[$i])) {
                    $location[$i] = '';
                }
                if(empty($desc[$i])) {
                    $desc[$i] = '';
                }
                $dbDATA = [
                    'user_id' => $item[$i],
                    'user_id' => $user[$i],
                    'qty' => $qty[$i],
                    'location' => $location[$i],
                    'item_desc' => $desc[$i],
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                InventoryAssign::create($dbDATA);
                /*$itemData = Inventory::firstRow('id',$item[$i]);
                $newQty = $itemData->qty - $qty[$i];
                $dataUpdate = ['qty' => $newQty];
                $itemUpdate = Inventory::defaultUpdate('id',$item[$i],$dataUpdate);*/

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
        $skill = InventoryAssign::firstRow('id',$request->input('dataId'));
        return view::make('inventory_assign.edit_form')->with('edit',$skill);

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

        $validator = Validator::make($request->all(),InventoryAssign::$mainRules);
        if($validator->passes()) {


            $dbDATA = [
                'qty' => $request->input('quantity'),
                'location' => $request->input('location'),
                'item_desc' => $request->input('description'),
                'updated_by' => Auth::user()->id
            ];

                    InventoryAssign::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

    public function search(Request $request)
    {

        $startDate = Utility::standardDate($request->input('start_date'));
        $endDate = Utility::standardDate($request->input('end_date'));
        $user = $request->input('user');
        $inventory = $request->input('inventory');
        $dateArray = [$startDate,$endDate];
        $mainData = [];
        
        $chartObject = new \stdClass();

            //PROCESS SEARCH
            if(!empty($user) && empty($inventory)){
                $mainData = InventoryAssign::specialColumnsDate1('user_id', $user,$dateArray);
            }

            if(empty($user) && !empty($inventory)){
                $mainData = InventoryAssign::specialColumnsDate1('item_id', $inventory, $dateArray);
            }

            if(empty($user) && empty($inventory)){
                $mainData = InventoryAssign::specialColumnsDate($dateArray);
            }

            if(!empty($user) && !empty($inventory)){
                $mainData = InventoryAssign::specialColumnsDate2('item_id', $inventory, 'user_id', $user,$dateArray);
            }

        return view::make('inventory_assign.search')->with('mainData',$mainData);

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
        $delete = InventoryAssign::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);
    }
}
