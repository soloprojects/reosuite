<?php

namespace App\Http\Controllers;

use App\model\BinType;
use App\model\PutAwayTemplate;
use App\model\Bin;
use App\model\WhseShipReceipt;
use App\model\Zone;
use App\model\Warehouse;
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

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $mainData = Warehouse::paginateAllData();
        $bin = Bin::getAllData();
        $putAwayTemp = PutAwayTemplate::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('warehouse.reload',array('mainData' => $mainData,'binType' => $bin
            ,'$putAwayTemp' => $bin))->render());

        }else{
            return view::make('warehouse.main_view')->with('mainData',$mainData)->with('binType',$bin)
                ->with('putAwayTemp',$putAwayTemp);
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
        $validator = Validator::make($request->all(),Warehouse::$mainRules);
        if($validator->passes()){

            $putAwayPickLine = ($request->input('put_away_pick_line') == '') ? '' : $request->input('put_away_pick_line');
            $pickLine = ($request->input('pick_line') == '') ? '' : $request->input('pick_line');
            $pickFeffo = ($request->input('pick_feffo') == '') ? '' : $request->input('pick_feffo');
            $breakBulk = ($request->input('break_bulk') == '') ? '' : $request->input('break_bulk');
            $countData = Warehouse::countData('name',$request->input('name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{


                $dbDATA = [
                    'code' => ucfirst($request->input('code')),
                    'name' => ucfirst($request->input('name')),
                    'address' => ucfirst($request->input('address')),
                    'address2' => ucfirst($request->input('address2')),
                    'country' => ucfirst($request->input('country')),
                    'post_code' => $request->input('post_code'),
                    'contact' => ucfirst($request->input('contact')),
                    'phone' => ucfirst($request->input('phone')),
                    'email' => ucfirst($request->input('email')),
                    'fax' => $request->input('fax'),
                    'whse_manager' => $request->input('warehouse_manager'),
                    'receipt_bin_code' => $request->input('receipt_bin'),
                    'ship_bin_code' => $request->input('shipment_bin'),
                    'open_shop_floor_bin_code' => $request->input('open_shop_floor_bin'),
                    'to_prod_bin_code' => $request->input('to_prod_bin'),
                    'from_prod_bin_code' => $request->input('from_prod_bin'),
                    'adjust_bin_code' => $request->input('adjust_code'),
                    'cross_dock_bin_code' => $request->input('cross_dock_bin'),
                    'to_assembly_bin_code' => $request->input('to_assemb_bin'),
                    'from_assembly_bin_code' => $request->input('from_assemb_bin'),
                    'assembly_to_order_ship_bin_code' => $request->input('ass_to_order_ship_bin'),
                    'special_equip' => ucfirst($request->input('special_equip')),
                    'put_away_template_code' => ucfirst($request->input('put_away_temp_code')),
                    'bin_capacity_policy' => ucfirst($request->input('bin_cap_policy')),
                    'put_away_line' => $putAwayPickLine,
                    'pick_line' => $pickLine,
                    'pick_feffo' => $pickFeffo,
                    'allow_break_bulk' => $breakBulk,
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                Warehouse::create($dbDATA);

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

        $warehouse = Warehouse::firstRow('id',$request->input('dataId'));
        $bin = Bin::getAllData();
        $putAwayTemp = PutAwayTemplate::getAllData();
        return view::make('warehouse.edit_form')->with('edit',$warehouse)->with('binType',$bin)
            ->with('putAwayTemp',$putAwayTemp);

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
        $validator = Validator::make($request->all(),Warehouse::$mainRulesEdit);
        if($validator->passes()) {

            $putAwayPickLine = ($request->input('put_away_pick_line') == '') ? '' : $request->input('put_away_pick_line');
            $pickLine = ($request->input('pick_line') == '') ? '' : $request->input('pick_line');
            $pickFeffo = ($request->input('pick_feffo') == '') ? '' : $request->input('pick_feffo');
            $breakBulk = ($request->input('break_bulk') == '') ? '' : $request->input('break_bulk');

            $dbDATA = [
                'code' => ucfirst($request->input('code')),
                'name' => ucfirst($request->input('name')),
                'address' => ucfirst($request->input('address')),
                'address2' => ucfirst($request->input('address2')),
                'country' => ucfirst($request->input('country')),
                'post_code' => $request->input('post_code'),
                'contact' => ucfirst($request->input('contact')),
                'phone' => ucfirst($request->input('phone')),
                'email' => ucfirst($request->input('email')),
                'fax' => $request->input('fax'),
                'whse_manager' => $request->input('warehouse_manager'),
                'receipt_bin_code' => $request->input('receipt_bin'),
                'ship_bin_code' => $request->input('shipment_bin'),
                'open_shop_floor_bin_code' => $request->input('open_shop_floor_bin'),
                'to_prod_bin_code' => $request->input('to_prod_bin'),
                'from_prod_bin_code' => $request->input('from_prod_bin'),
                'adjust_bin_code' => $request->input('adjust_code'),
                'cross_dock_bin_code' => $request->input('cross_dock_bin'),
                'to_assembly_bin_code' => $request->input('to_assemb_bin'),
                'from_assembly_bin_code' => $request->input('from_assemb_bin'),
                'assembly_to_order_ship_bin_code' => $request->input('ass_to_order_ship_bin'),
                'special_equip' => ucfirst($request->input('special_equip')),
                'put_away_template_code' => $request->input('put_away_temp_code'),
                'bin_capacity_policy' => ucfirst($request->input('bin_cap_policy')),
                'put_away_line' => $putAwayPickLine,
                'pick_line' => $pickLine,
                'pick_feffo' => $pickFeffo,
                'allow_break_bulk' => $breakBulk,
                'updated_by' => Auth::user()->id
            ];
            $rowData = Warehouse::specialColumns('name', $request->input('name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    Warehouse::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                Warehouse::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
            $rowDataSalary = WhseShipReceipt::specialColumns('item_id', $all_id[$i]);
            if(count($rowDataSalary)>0){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }
        $message = (count($unused) > 0) ? ' and '.count($unused).
            ' warehouse has been used in another module and cannot be deleted' : '';
        if(count($in_use) > 0){
            $delete = Warehouse::massUpdate('id',$in_use,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($in_use).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($unused).' warehouse has been used in another module and cannot be deleted',
                'message' => 'warning'
            ]);

        }


    }


}
