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

class SalaryStructureController extends Controller
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
        $mainData = SalaryStructure::paginateAllData();
        $salaryComp = SalaryComponent::getAllData();
        $taxSystem = Tax::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('salary_structure.reload',array('mainData' => $mainData,'salaryComp' => $salaryComp
            ,'taxSystem' => $taxSystem))->render());

        }else{
            return view::make('salary_structure.main_view')->with('mainData',$mainData)->with('salaryComp',$salaryComp)
                ->with('taxSystem',$taxSystem);
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
        $validator = Validator::make($request->all(),SalaryStructure::$mainRules);
        if($validator->passes()){

            $amount= json_decode($request->input('amount'));
            $comp = json_decode($request->input('component'));
            $compType = json_decode($request->input('comp_type'));
            $compArray = [];

            for($i=0;$i<count($comp);$i++){
                $holdArray = [];
                $holdArray['component'] = $comp[$i];
                $holdArray['amount'] = $amount[$i];
                $holdArray['component_type'] = $compType[$i];
                $compArray[] = $holdArray;

            }
            $encodeCompArray = json_encode($compArray);

            $dbDATA = [
                'salary_name' => ucfirst($request->input('salary_name')),
                'desc' => ucfirst($request->input('salary_desc')),
                'net_pay' => ucfirst($request->input('net_pay')),
                'gross_pay' => ucfirst($request->input('gross_pay')),
                'tax_id' => ucfirst($request->input('tax_system')),
                'component' => $encodeCompArray,
                'status' => Utility::STATUS_ACTIVE
            ];

            $countData = SalaryStructure::countData('salary_name',$request->input('tax_name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                SalaryStructure::create($dbDATA);

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
        $salaryStructure = SalaryStructure::firstRow('id',$request->input('dataId'));
        $salaryComp = SalaryComponent::getAllData();
        $taxSystem = Tax::getAllData();

        return view::make('salary_structure.edit_form')->with('edit',$salaryStructure)->with('salaryComp',$salaryComp)
            ->with('taxSystem',$taxSystem);

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
        $validator = Validator::make($request->all(),SalaryStructure::$mainRules);
        if($validator->passes()) {

            $amount= json_decode($request->input('amount'));
            $comp = json_decode($request->input('component'));
            $compType = json_decode($request->input('comp_type'));
            $compArray = [];

            for($i=0;$i<count($comp);$i++){
                $holdArray = [];
                $holdArray['component'] = $comp[$i];
                $holdArray['amount'] = $amount[$i];
                $holdArray['component_type'] = $compType[$i];
                $compArray[] = $holdArray;

            }
            $encodeCompArray = json_encode($compArray);

            $dbDATA = [
                'salary_name' => ucfirst($request->input('salary_name')),
                'desc' => ucfirst($request->input('salary_desc')),
                'net_pay' => ucfirst($request->input('net_pay')),
                'gross_pay' => ucfirst($request->input('gross_pay')),
                'tax_id' => ucfirst($request->input('tax_system')),
                'component' => $encodeCompArray
            ];
            $rowData = SalaryStructure::specialColumns('salary_name', $request->input('salary_name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    SalaryStructure::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                SalaryStructure::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

    public function fetchTaxData(Request $request)
    {

        $postDate = $request->input('post_date');
        $searchId = $request->input('tax_id');
        $searchData = Tax::firstRow('id',$searchId);
        $totalPerct = $searchData->sum_percentage;

        return response()->json([

            'perct' => $totalPerct
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
            $rowDataSalary = User::countData('salary_id', $all_id[$i]);
            if($rowDataSalary>0){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }
        $message = (count($unused) > 0) ? ' and '.count($unused).
            ' salary structure(s) has been used in another module and cannot be deleted' : '';
        if(count($in_use) > 0){
            $delete = SalaryStructure::massUpdate('id',$in_use,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($in_use).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($unused).' salary structure(s) has been used in another module and cannot be deleted',
                'message' => 'warning'
            ]);

        }


    }
}
