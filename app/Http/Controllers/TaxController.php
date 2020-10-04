<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\SalaryComponent;
use App\model\Tax;
use App\model\SalaryStructure;
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

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $mainData = Tax::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('tax.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('tax.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),Tax::$mainRules);
        if($validator->passes()){

            $taxAgent = json_decode($request->input('tax_agent'));
            $percent= json_decode($request->input('percentage'));
            $comp = json_decode($request->input('component'));
            $compArray = [];

            for($i=0;$i<count($comp);$i++){
                $holdArray = [];
                $holdArray['component'] = $comp[$i];
                $holdArray['tax_agent'] = $taxAgent[$i];
                $holdArray['percentage'] = $percent[$i];
                $compArray[] = $holdArray;

            }
            $encodeCompArray = json_encode($compArray);

            $dbDATA = [
                'tax_name' => ucfirst($request->input('tax_name')),
                'sum_percentage' => $request->input('percentage_sum'),
                'component' => $encodeCompArray,
                'status' => Utility::STATUS_ACTIVE
            ];

            $countData = Tax::countData('tax_name',$request->input('tax_name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                Tax::create($dbDATA);

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
        $tax = Tax::firstRow('id',$request->input('dataId'));
        return view::make('tax.edit_form')->with('edit',$tax);

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
        $validator = Validator::make($request->all(),Tax::$mainRules);
        if($validator->passes()) {

            $taxAgent = json_decode($request->input('tax_agent'));
            $percent= json_decode($request->input('percentage'));
            $comp = json_decode($request->input('component'));
            $compArray = [];

            for($i=0;$i<count($comp);$i++){
                $holdArray = [];
                $holdArray['component'] = $comp[$i];
                $holdArray['tax_agent'] = $taxAgent[$i];
                $holdArray['percentage'] = $percent[$i];
                $compArray[] = $holdArray;

            }
            $encodeCompArray = json_encode($compArray);

            $dbDATA = [
                'tax_name' => ucfirst($request->input('tax_name')),
                'sum_percentage' => $request->input('percentage_sum'),
                'component' => $encodeCompArray
            ];
            $rowData = Tax::specialColumns('tax_name', $request->input('tax_name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    Tax::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                Tax::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
            $rowDataTax = SalaryStructure::specialColumns('id', $all_id[$i]);
            if(count($rowDataTax)>0){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }
        $message = (count($unused) > 0) ? ' and '.count($unused).
            ' tax(es) has been used in another module and cannot be deleted' : '';
        if(count($in_use) > 0){
            $delete = Tax::massUpdate('id',$in_use,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($in_use).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($unused).' tax(es) has been used in another module and cannot be deleted',
                'message' => 'warning'
            ]);

        }


    }
}
