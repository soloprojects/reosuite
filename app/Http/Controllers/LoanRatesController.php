<?php

namespace App\Http\Controllers;

use App\model\LoanRates;
use App\Helpers\Utility;
use App\model\Requisition;
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

class LoanRatesController extends Controller
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
        $mainData = LoanRates::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('loan_rates.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('loan_rates.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),LoanRates::$mainRules);
        if($validator->passes()){

            $countData = LoanRates::countData('loan_name',$request->input('loan_name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'loan_name' => ucfirst($request->input('loan_name')),
                    'interest_rate' => $request->input('interest_rate'),
                    'duration' => $request->input('duration'),
                    'loan_desc' => ucfirst($request->input('leave_description')),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                LoanRates::create($dbDATA);

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
        $loan_rates = LoanRates::firstRow('id',$request->input('dataId'));
        return view::make('loan_rates.edit_form')->with('edit',$loan_rates);

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
        $validator = Validator::make($request->all(),LoanRates::$mainRules);
        if($validator->passes()) {

            //CHECK IF LOAN CONFIG ITEM IS ACTIVELY RUNNING AN EMPLOYEE LOAN
            $checkRequisition = Requisition::firstRow('loan_id',$request->input('edit_id'));
            if(!empty($checkRequisition)){
                if($checkRequisition->loan_balance > 0){
                    return response()->json([
                        'message' => 'warning',
                        'message2' => 'some loans are currently active with this Loan Config, ensure there are no employee loans active'
                    ]);

                }
            }
            $dbDATA = [
                'loan_name' => ucfirst($request->input('loan_name')),
                'interest_rate' => $request->input('interest_rate'),
                'duration' => $request->input('duration'),
                'loan_desc' => ucfirst($request->input('loan_description')),
            ];
            $rowData = LoanRates::specialColumns('loan_name', $request->input('loan_name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    LoanRates::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);

                } else {
                    return response()->json([
                        'message' => 'warning',
                        'message2' => 'Entry already exist, please try another entry'
                    ]);

                }

            } else{
                LoanRates::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

    //CONVERT LOAN TO ACTIVE OR INACTIVE STATUS
    public function changeLoanStatus(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $id = $idArray[0];
        $check = LoanRates::countData2('id', $id, 'loan_status', '0');
        if ($check > 0) {
            $activeLoan = LoanRates::firstRow('loan_status', '1');
            $dbData1 = [
                'loan_status' => '0'
            ];
            $dbData = [
                'loan_status' => Utility::STATUS_ACTIVE,
            ];
            $cancelActive = LoanRates::defaultUpdate('id', $activeLoan->id, $dbData1);
            $update = LoanRates::defaultUpdate('id', $idArray, $dbData);
        }
        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
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
        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];
        $delete = LoanRates::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

}
