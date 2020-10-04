<?php

namespace App\Http\Controllers;

use App\Helpers\Finance;
use App\Helpers\Utility;
use App\Helpers\Notify;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Input;
use Hash;
use DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\model\AccountJournal;
use App\model\JournalExtension;
use App\model\TransClass;
use App\model\TransLocation;
use App\model\AccountChart;
use App\model\BankReconciliation;
use App\model\FinancialYear;
use Hamcrest\Util;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;

class BankReconciliationController extends Controller
{
    //

    public function index(Request $request)
    {
        //              
        $reconciledAccounts = BankReconciliation::paginateAllData();
        $this->reconciliationChanges($reconciledAccounts);
        $finYear = FinancialYear::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('bank_reconciliation.reload',array('mainData' => $reconciledAccounts))->render());

        }else{
            return view::make('bank_reconciliation.main_view')->with('mainData',$reconciledAccounts)
            ->with('finYear',$finYear);
        }
     
    }

    public function createReconciliation(Request $request)
    {
        //
        $allCheckedId = json_decode($request->input('dataId'));

        $unclearedPayments = json_decode($request->input('unclearedPayments'));
        $unclearedDeposits = json_decode($request->input('unclearedDeposits'));
        $unclearedPayments = (!empty($unClearedPayments)) ? array_sum($unclearedPayments) : 0.00;
        $unclearedDeposits = (!empty($unclearedDeposits)) ? array_sum($unclearedDeposits) : 0.00;

        $countUnclearedPayments = $request->input('countUnclearedPayments');
        $countUnclearedDeposits = $request->input('countUnclearedDeposits');

        $clearedPayments = $request->input('payments');
        $clearedDeposits = $request->input('deposits');
        $countClearedPayments = $request->input('payment_num');
        $countClearedDeposits = $request->input('deposit_num');

        $clearedBalance = $request->input('cleared_balance');
        $differenceBalance = $request->input('difference_balance');
        $beginingBalance = $request->input('begining_balance');
        $endingBalance = $request->input('ending_balance');

        $beginingDate = $request->input('begining_date');
        $endingDate = $request->input('ending_date');
        $accountId = $request->input('account_id');
        $accountCategory = $request->input('account_category');

        $accountData = AccountChart::firstRow('id',$accountId);


        if($countClearedDeposits > 0 || $countClearedPayments > 0){
            
                $dbDATA = [
                    'account_id' => $accountId,
                    'acct_cat_id' => $accountCategory,
                    'bank_balance' => $accountData->bank_balance,
                    'register_balance' => $accountData->virtual_balance_trans,
                    'begining_balance' => $beginingBalance,
                    'ending_balance' => $endingBalance,
                    'begining_date' => $beginingDate,
                    'ending_date' => $endingDate,
                    'cleared_balance' => $clearedBalance,
                    'deposits_cleared' => $clearedDeposits,
                    'uncleared_deposits' => $unclearedDeposits,
                    'uncleared_payments' => $unclearedPayments,
                    'payments_cleared' => $clearedPayments,
                    'difference' => $differenceBalance,
                    'count_cleared_payments' => $countClearedPayments,
                    'count_cleared_deposits' => $countClearedDeposits,
                    'count_uncleared_payments' => $countUnclearedPayments,
                    'count_uncleared_deposits' => $countUnclearedDeposits,
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                $reconcileId = '';
                if(!empty($request->input('update_status'))){
                    $reconcileId = $request->input('edit_id');
                    BankReconciliation::defaultUpdate('id',$reconcileId,$dbDATA);
                }else{
                    $create = BankReconciliation::create($dbDATA);
                    $reconcileId = $create->id;
                }
                

                $dbDataUpdate = [
                    'reconcile_status' => Finance::reconciled,
                    'reconcile_id' => $reconcileId
                ];
    
                    AccountJournal::massUpdate('id',$allCheckedId,$dbDataUpdate);

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

        }
        
        return response()->json([
            'message2' => 'fail',
            'message' => 'Please ensure to checkbox a payment or deposit'
        ]);


    }

    //FETCH ACCOUNT TRANSACTIONS FROM ACCOUNT JOURNAL TABLE FOR RECONCILIATION
    public function reconcile(Request $request){

       $validator = Validator::make($request->all(),BankReconciliation::$reconcileRules);

        if($validator->passes()){

            $accountId = $request->input('account');
             $endingDate = Utility::standardDate($request->input('ending_date'));
            $beginingBalance = 0.00;    $endingBalance = $request->input('ending_balance');  $clearedBalance = 0.00;
            $deposit = ''; $payment = '';  $balanceDifference = 0.00;
            $reconcilePayments = [];   $reconcileDeposits = [];
            $accountData = AccountChart::firstRow('id',$accountId);
            $categoryId = $accountData->acct_cat_id;
            $finYearObj = Finance::defaultFinYearObj();
            $finYear = (!empty($request->input('financial_year'))) ? $request->input('financial_year') : $finYearObj->fin_year;
            $beginingDate = $finYear;
            //PROCESS IF ACCOUNT IS A BALANCE SHEET ACCOUNT AND A FINANCIAL YEAR IS ACTIVE
            if(in_array($categoryId,Utility::BALANCE_SHEET_ACCOUNTS) && !empty($finYear)){
                
                if(in_array($categoryId,Utility::DEBIT_ACCOUNTS)){
                    $deposit = Utility::DEBIT_TABLE_ID;
                    $payment = Utility::CREDIT_TABLE_ID;
                }

                if(in_array($categoryId,Utility::CREDIT_ACCOUNTS)){
                    $deposit = Utility::CREDIT_TABLE_ID;
                    $payment = Utility::DEBIT_TABLE_ID;
                }

                $lastReconciledData = BankReconciliation::firstRow('account_id',$accountId);

                if(!empty($lastReconciledData)){
                    //$beginingDate = Utility::addDaysToPostDate('1',$lastReconciledData->ending_date);
                    
                    $dateArray = [$beginingDate,$endingDate];                    
                    
                    $reconcilePayments = AccountJournal::specialColumnsDate22('chart_id',$accountId,'debit_credit',$payment,$dateArray);
                    $reconcileDeposits = AccountJournal::specialColumnsDate22('chart_id',$accountId,'debit_credit',$deposit,$dateArray);
                    $balanceDifference= $endingBalance - $lastReconciledData->ending_balance;                 

                }else{
                    
                    //$beginingDate = $finYear;
                    $dateArray = [$beginingDate,$endingDate];                    
                    
                    $reconcilePayments = AccountJournal::specialColumnsDate22('chart_id',$accountId,'debit_credit',$payment,$dateArray);
                    $reconcileDeposits = AccountJournal::specialColumnsDate22('chart_id',$accountId,'debit_credit',$deposit,$dateArray);
                    
                   
                    $beginingBalance = 0.00;
                    $balanceDifference= $endingBalance - $beginingBalance;

                } 
                $clearedBalance = $beginingBalance;
                


                return view::make('bank_reconciliation.reconcile')->with('payments',$reconcilePayments)
                ->with('deposits',$reconcileDeposits)->with('beginingBalance',$beginingBalance)
                ->with('endingBalance',$endingBalance)->with('clearedBalance',$clearedBalance)
                ->with('balanceDifference',$balanceDifference)->with('endingDate',$endingDate)
                ->with('beginingDate',$beginingDate)->with('accountData',$accountData);

            }else{
                return 'Please select a balance sheet account and ensure a fiscal/financial year is active to continue';
            }

        }

        return 'Please enter ending balance and ending date to continue';

    }

    public function reconciliationChanges($accountData){

        foreach($accountData as $data){
            $accountId = $data->account_id;

            $lastReconciledData = BankReconciliation::firstRow('account_id',$accountId);
            $beginingBalance = 0.00;    $endingBalance = 0.00;
            $deposit = ''; $payment = '';   $balanceChanges = 0.00;
            $currReconciledAmount = 0.00;   $reconciledAmount = 0.00;

            $categoryId = $lastReconciledData->acct_cat_id;
            if(in_array($categoryId,Utility::DEBIT_ACCOUNTS)){
                $deposit = Utility::DEBIT_TABLE_ID;
                $payment = Utility::CREDIT_TABLE_ID;
            }

            if(in_array($categoryId,Utility::CREDIT_ACCOUNTS)){
                $deposit = Utility::CREDIT_TABLE_ID;
                $payment = Utility::DEBIT_TABLE_ID;
            }
            $reconciledPayments = AccountJournal::specialColumnsSum3('reconcile_id',$data->id,'chart_id',$accountId,'debit_credit',$payment);
            $reconciledDeposits = AccountJournal::specialColumnsSum3('reconcile_id',$data->id,'chart_id',$accountId,'debit_credit',$deposit);
        
            $currReconciledAmount = $reconciledDeposits - $reconciledPayments;  //CALCULATIONS FROM EXISTING DATA IN THE DB
            $reconciledAmount = $data->deposits_cleared - $data->payments_cleared;  //RECORDED RECONCILED AMOUNT ON RECONCILIATION TABLE
            
            $endingBalance = $data->ending_balance;

            $balanceChanges = $reconciledAmount - $currReconciledAmount;    //DIFFERENCE BETWEEN RECORDED RECONCILED BALANCE AND THAT EXISTING IN JOURNAL IN CASE OF CHANGES FROM THE JOURNAL
            
            $data->balanceChanges = Utility::roundNum($balanceChanges);

        }

    }

    //FETCH BEGINING BALANCE WHEN AN ACCOUNT IS BEING SELECTED
    public function fetchBeginingBalance(Request $request)
    {
        //
        $accountId = $request->input('pickedVal');

        $lastReconciledData = BankReconciliation::firstRow('account_id',$accountId);
        $beginingBalance = 0.00;    $endingBalance = 0.00;
        $deposit = ''; $payment = '';   $balanceChanges = 0.00;
        $currReconciledAmount = 0.00;   $reconciledAmount = 0.00;

        if(!empty($lastReconciledData)){
            $categoryId = $lastReconciledData->acct_cat_id;
            if(in_array($categoryId,Utility::DEBIT_ACCOUNTS)){
                $deposit = Utility::DEBIT_TABLE_ID;
                $payment = Utility::CREDIT_TABLE_ID;
            }

            if(in_array($categoryId,Utility::CREDIT_ACCOUNTS)){
                $deposit = Utility::CREDIT_TABLE_ID;
                $payment = Utility::DEBIT_TABLE_ID;
            }
            $reconciledPayments = AccountJournal::specialColumnsSum3('reconcile_id',$lastReconciledData->id,'chart_id',$accountId,'debit_credit',$payment);
            $reconciledDeposits = AccountJournal::specialColumnsSum3('reconcile_id',$lastReconciledData->id,'chart_id',$accountId,'debit_credit',$deposit);
        
            $currReconciledAmount = $reconciledDeposits - $reconciledPayments;  //CALCULATIONS FROM EXISTING DATA IN THE DB
            $reconciledAmount = $lastReconciledData->deposits_cleared - $lastReconciledData->payments_cleared;  //RECORDED RECONCILED AMOUNT ON RECONCILIATION TABLE
            
            $endingBalance = $lastReconciledData->ending_balance;

        }        

            $balanceChanges = $reconciledAmount - $currReconciledAmount;
            $beginingBalance = $endingBalance - $balanceChanges;
        
            return Utility::roundNum($beginingBalance);
     
    }

    public function search(Request $request){

        $from = Utility::standardDate($request->input('from_date')); $to = Utility::standardDate($request->input('to_date'));
        $dateArray = [$from,$to];
        $accountId = $request->input('account');
        $validator = Validator::make($request->all(),BankReconciliation::$searchRules);

        if($validator->passes()){

            $reconciledAccounts = BankReconciliation::specialColumnsDate('account_id',$accountId,$dateArray);
            
            if($reconciledAccounts->count() > 0){
                
                $this->reconciliationChanges($reconciledAccounts);

                return view::make('bank_reconciliation.search')->with('mainData',$reconciledAccounts);
            }else{
                return 'No records found';
            }
           

        }else{
            return 'please select accounts and enter dates to continue';
        }

        
    }

    public function singleReport(Request $request, $id)
    {
        //
        {

            $data = BankReconciliation::firstRow('id',$id);
            $from = $data->begining_date; $to = $data->ending_date;
            $dateArray = [$from,$to];   $deposit = ''; $payment = '';
            $categoryId = $data->acct_cat_id;   $accountId = $data->account_id;
            $accountData = AccountChart::firstRow('id',$accountId);
            
            if(in_array($categoryId,Utility::DEBIT_ACCOUNTS)){
                $deposit = Utility::DEBIT_TABLE_ID;
                $payment = Utility::CREDIT_TABLE_ID;
            }
    
            if(in_array($categoryId,Utility::CREDIT_ACCOUNTS)){
                $deposit = Utility::CREDIT_TABLE_ID;
                $payment = Utility::DEBIT_TABLE_ID;
            }
    
            $reconcilePayments = AccountJournal::specialColumnsDate22('chart_id',$accountId,'debit_credit',$payment,$dateArray);
            $reconcileDeposits = AccountJournal::specialColumnsDate22('chart_id',$accountId,'debit_credit',$deposit,$dateArray);
          
            return view::make('bank_reconciliation.single_report')->with('payments',$reconcilePayments)
                    ->with('deposits',$reconcileDeposits)->with('beginingBalance',$data->begining_balance)
                    ->with('endingBalance',$data->ending_balance)->with('clearedBalance',$data->cleared_balance)
                    ->with('balanceDifference',$data->difference)->with('endingDate',$data->ending_date)
                    ->with('beginingDate',$data->begining_date)->with('accountData',$accountData)
                    ->with('edit',$data);
    
    
        }
     
    }

    public function redoBankReconciliation(Request $request, $id){

        $data = BankReconciliation::firstRow('id',$id);
        $from = $data->begining_date; $to = $data->ending_date;
        $dateArray = [$from,$to];   $deposit = ''; $payment = '';
        $categoryId = $data->acct_cat_id;   $accountId = $data->account_id;
        $accountData = AccountChart::firstRow('id',$accountId);
        
        if(in_array($categoryId,Utility::DEBIT_ACCOUNTS)){
            $deposit = Utility::DEBIT_TABLE_ID;
            $payment = Utility::CREDIT_TABLE_ID;
        }

        if(in_array($categoryId,Utility::CREDIT_ACCOUNTS)){
            $deposit = Utility::CREDIT_TABLE_ID;
            $payment = Utility::DEBIT_TABLE_ID;
        }

        $reconcilePayments = AccountJournal::specialColumnsDate22('chart_id',$accountId,'debit_credit',$payment,$dateArray);
        $reconcileDeposits = AccountJournal::specialColumnsDate22('chart_id',$accountId,'debit_credit',$deposit,$dateArray);
      
        return view::make('bank_reconciliation.redo_reconciliation')->with('payments',$reconcilePayments)
                ->with('deposits',$reconcileDeposits)->with('beginingBalance',$data->begining_balance)
                ->with('endingBalance',$data->ending_balance)->with('clearedBalance',$data->cleared_balance)
                ->with('balanceDifference',$data->difference)->with('endingDate',$data->ending_date)
                ->with('beginingDate',$data->begining_date)->with('accountData',$accountData)
                ->with('edit',$data);


    }

    public function destroy(Request $request){

        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];
        $journalDbData = [
            'reconcile_status' => Finance::uncleared
        ];
        $delete = BankReconciliation::massUpdate('id',$idArray,$dbData);
        //$updateJournal = AccountJournal::massUpdate('reconcile_id',$idArray,$journalDbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

}
