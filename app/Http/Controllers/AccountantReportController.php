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
use App\model\FinancialYear;
use Hamcrest\Util;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;

class AccountantReportController extends Controller
{
    //

    public function balanceSheet(Request $request)
    {
        //
        //$req = new Request();
        $finYear = FinancialYear::getAllData();
        $transClass = TransClass::getAllData();
        $transLocation = TransLocation::getAllData();

        
            return view::make('accountant_report.balance_sheet')->with('transClass',$transClass)
            ->with('transLocation',$transLocation)->with('finYear',$finYear);
     
    }

    public function balanceSheetReport(Request $request){

        $from = $request->input('from_date'); $to = $request->input('to_date');
        $finYear = $request->input('financial_year');  $accountBasis = $request->input('account_basis');
        $class = $request->input('class');  $location = $request->input('location');
        $liabilityAccounts = ($accountBasis == Utility::STATUS_ACTIVE) ? Finance::cashBasisLiabilityAccounts : Finance::bsLiability;
        $assetAccounts = ($accountBasis == Utility::STATUS_ACTIVE) ? Finance::cashBasisAssetAccounts : Finance::bsAssets;
        //ASSETS = LIABILITY + EQUITY
        $assets = AccountChart::massData('acct_cat_id',$assetAccounts); //DEBIT ACCOUNT
        $equity = AccountChart::massData('acct_cat_id',Finance::bsEquity); //CREDIT ACCOUNT        
        $liability = AccountChart::massData('acct_cat_id',$liabilityAccounts);  //CREDIT ACCOUNT

        $paramObj = new \stdClass();
        $paramObj->from = Utility::standardDate($from);
        $paramObj->to = Utility::standardDate($to);
        $paramObj->finYear = $finYear;
        $paramObj->class = $class;
        $paramObj->location = $location;
        $paramObj->accountBasis = $accountBasis;

        Finance::balanceSheetReport($assets,$paramObj);
        Finance::balanceSheetReport($equity,$paramObj);
        Finance::balanceSheetReport($liability,$paramObj);
        
        $debitSideSum = Utility::roundNum($assets->totalBal);
        $creditSideSum = Utility::roundNum($liability->totalBal + $equity->totalBal);

        return view::make('accountant_report.balance_sheet_reload')->with('assets',$assets)
        ->with('equity',$equity)->with('liability',$liability)->with('from',$from)->with('to',$to)
        ->with('debitSideSum',$debitSideSum)->with('creditSideSum',$creditSideSum);

    }

    public function trialBalance(Request $request)
    {
        //
        //$req = new Request();
        $finYear = FinancialYear::getAllData();
        $transClass = TransClass::getAllData();
        $transLocation = TransLocation::getAllData();

        
            return view::make('accountant_report.trial_balance')->with('transClass',$transClass)
            ->with('transLocation',$transLocation)->with('finYear',$finYear);
     
    }

    public function trialBalanceReport(Request $request){

        $from = $request->input('from_date'); $to = $request->input('to_date');
        $finYear = $request->input('financial_year');  $accountBasis = $request->input('account_basis');
        $class = $request->input('class');  $location = $request->input('location');
        $liabilityAccounts = Finance::bsLiability;
        $assetAccounts = Finance::bsAssets;
        $otherDebitCategory = [13,14,15];   //ID FROM ACCOUNT_CATEGORY DB TABLE
        $otherCreditCategory = [11,12];  //ID FROM ACCOUNT_CATEGORY DB TABLE
        //ASSETS = LIABILITY + EQUITY
        $assets = AccountChart::massData('acct_cat_id',$assetAccounts); //DEBIT ACCOUNT
        $equity = AccountChart::massData('acct_cat_id',Finance::bsEquity); //CREDIT ACCOUNT        
        $liability = AccountChart::massData('acct_cat_id',$liabilityAccounts);  //CREDIT ACCOUNT
        $otherDebitAccounts = AccountChart::massData('acct_cat_id',$otherDebitCategory); //OTHER DEBIT ACCOUNT        
        $otherCreditAccounts = AccountChart::massData('acct_cat_id',$otherCreditCategory);  //OTHER CREDIT ACCOUNT

        $paramObj = new \stdClass();
        $paramObj->from = Utility::standardDate($from);
        $paramObj->to = Utility::standardDate($to);
        $paramObj->finYear = $finYear;
        $paramObj->class = $class;
        $paramObj->location = $location;
        $paramObj->accountBasis = $accountBasis;

        Finance::trialBalanceReport($assets,$paramObj);
        Finance::trialBalanceReport($equity,$paramObj);
        Finance::trialBalanceReport($liability,$paramObj);
        Finance::trialBalanceReport($otherDebitAccounts,$paramObj);
        Finance::trialBalanceReport($otherCreditAccounts,$paramObj);
        
        $debitSideSum = $assets->totalBal + $otherDebitAccounts->totalBal;
        $creditSideSum = $liability->totalBal + $equity->totalBal + $otherCreditAccounts->totalBal;

        return view::make('accountant_report.trial_balance_reload')->with('assets',$assets)
        ->with('equity',$equity)->with('liability',$liability)->with('from',$from)->with('to',$to)
        ->with('debitSideSum',$debitSideSum)->with('creditSideSum',$creditSideSum)
        ->with('otherDebitAccounts',$otherDebitAccounts)->with('otherCreditAccounts',$otherCreditAccounts);

    }

    public function incomeStatement(Request $request)
    {
        //
        //$req = new Request();
        $finYear = FinancialYear::getAllData();
        $transClass = TransClass::getAllData();
        $transLocation = TransLocation::getAllData();

        
            return view::make('accountant_report.income_statement')->with('transClass',$transClass)
            ->with('transLocation',$transLocation)->with('finYear',$finYear);
     
    }

    public function incomeStatementReport(Request $request){

        $from = $request->input('from_date'); $to = $request->input('to_date');
        $finYear = $request->input('financial_year');  $accountBasis = $request->input('account_basis');
        $class = $request->input('class');  $location = $request->input('location');
        
        //ASSETS = LIABILITY + EQUITY
        $income = AccountChart::specialColumns('acct_cat_id',Finance::incomeAccountCategory); 
        $COG = AccountChart::specialColumns('acct_cat_id',Finance::COGAccountCategory); 
        $expenses = AccountChart::specialColumns('acct_cat_id',Finance::expenseAccountCategory);  
        $otherIncome = AccountChart::specialColumns('acct_cat_id',Finance::otherIncomeAccountCategory); 
        $otherExpenses = AccountChart::specialColumns('acct_cat_id',Finance::otherExpenseAccountCategory); 

        $paramObj = new \stdClass();
        $paramObj->from = Utility::standardDate($from);
        $paramObj->to = Utility::standardDate($to);
        $paramObj->finYear = $finYear;
        $paramObj->class = $class;
        $paramObj->location = $location;
        $paramObj->accountBasis = $accountBasis;

        Finance::incomeStatementReport($income,$paramObj);
        Finance::incomeStatementReport($COG,$paramObj);
        Finance::incomeStatementReport($expenses,$paramObj);
        Finance::incomeStatementReport($otherIncome,$paramObj);
        Finance::incomeStatementReport($otherExpenses,$paramObj);

        $grossProfit = $income->totalBal - $COG->totalBal;
        $netOperatingIncome = $grossProfit - $expenses->totalBal;
        $netOtherIncome = $otherIncome->totalBal - $otherExpenses->totalBal;
        $netIncome = $netOperatingIncome + $netOtherIncome;

        return view::make('accountant_report.income_statement_reload')->with('income',$income)
        ->with('COG',$COG)->with('expenses',$expenses)->with('from',$from)->with('to',$to)
        ->with('otherIncome',$otherIncome)->with('otherExpenses',$otherExpenses)
        ->with('grossProfit',$grossProfit)->with('netOperatingIncome',$netOperatingIncome)
        ->with('netOtherIncome',$netOtherIncome)->with('netIncome',$netIncome);

    }

}
