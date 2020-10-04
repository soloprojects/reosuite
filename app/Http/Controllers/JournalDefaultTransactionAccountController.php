<?php

namespace App\Http\Controllers;

use App\model\JournalDefaultTransactionAccount;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\model\Department;
use App\Helpers\Utility;
use App\User;
use App\model\Roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Input;
use Hash;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class JournalDefaultTransactionAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $mainData = JournalDefaultTransactionAccount::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('journal_default_transaction_account.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('journal_default_transaction_account.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),JournalDefaultTransactionAccount::$mainRules);
        if($validator->passes()){

            $countData = JournalDefaultTransactionAccount::countData('name',$request->input('name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }

                $dbDATA = [
                    'name' => $request->input('name'),
                    'default_account_payable' => $request->input('default_account_payable'),
                    'default_account_receivable' => $request->input('default_account_receivable'),
                    'default_sales_tax' => $request->input('default_sales_tax'),
                    'default_discount_allowed' => $request->input('default_discount_allowed'),
                    'default_discount_received' => $request->input('default_discount_received'),
                    'default_payroll_tax' => $request->input('default_payroll_tax'),
                    'default_inventory' => $request->input('default_inventory'),
                    'default_purchase_tax' => $request->input('default_purchase_tax'),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                JournalDefaultTransactionAccount::create($dbDATA);

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

        $JournalDefaultTransactionAccount = JournalDefaultTransactionAccount::firstRow('id',$request->input('dataId'));
        return view::make('journal_default_transaction_account.edit_form')->with('edit',$JournalDefaultTransactionAccount);

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
        $validator = Validator::make($request->all(),JournalDefaultTransactionAccount::$mainRules);
        if($validator->passes()) {
            
            $dbDATA = [
                'name' => $request->input('name'),
                'default_account_payable' => $request->input('default_account_payable'),
                'default_account_receivable' => $request->input('default_account_receivable'),
                'default_sales_tax' => $request->input('default_sales_tax'),
                'default_discount_allowed' => $request->input('default_discount_allowed'),
                'default_discount_received' => $request->input('default_discount_received'),
                'default_payroll_tax' => $request->input('default_payroll_tax'),
                'default_inventory' => $request->input('default_inventory'),
                'default_purchase_tax' => $request->input('default_purchase_tax'),
                'updated_by' => Auth::user()->id
            ];
            $rowData = JournalDefaultTransactionAccount::specialColumns('name', $request->input('name'));
            if(count($rowData) > 2){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    JournalDefaultTransactionAccount::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                JournalDefaultTransactionAccount::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];
        $delete = JournalDefaultTransactionAccount::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

    public function changeStatus(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $status = $request->input('status');
        $checkActive = JournalDefaultTransactionAccount::firstRow('active_status',Utility::STATUS_ACTIVE);

        $dbData = [
            'active_status' => $status
        ];
        if($status == Utility::STATUS_ACTIVE) {
            if (!empty($checkActive)) {
                JournalDefaultTransactionAccount::defaultUpdate('id', $checkActive->id, ['active_status' => Utility::STATUS_DELETED]);
            }
            $changeStatus = JournalDefaultTransactionAccount::defaultUpdate('id',$idArray[0],$dbData);
        }else{
            $changeStatus = JournalDefaultTransactionAccount::massUpdate('id',$idArray,$dbData);
        }


        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
        ]);

    }

}
