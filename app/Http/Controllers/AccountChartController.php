<?php

namespace App\Http\Controllers;

use App\Helpers\Finance;
use App\model\AccountChart;
use App\Http\Controllers\Controller;
use App\model\ExchangeRate;
use App\model\FinancialYear;
use App\model\JournalExtension;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\model\AccountCategory;
use App\model\AccountJournal;
use App\model\Currency;
use App\model\AccountDetailType;
use App\Helpers\Utility;
use App\User;
use App\model\Roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Validator;
use Input;
use Hash;
use DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;

class AccountChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $mainData = AccountChart::paginateAllData();
        $currency = Currency::getAllData();
        $accountCat = AccountCategory::getAllData();
        
        if ($request->ajax()) {
            return \Response::json(view::make('account_chart.reload',array('mainData' => $mainData,
                'currency' => $currency,'accountCat' => $accountCat))->render());

        }
            return view::make('account_chart.main_view')->with('mainData',$mainData)->with('currency',$currency)
                ->with('accountCat',$accountCat);

    }


    public function accountRegister(Request $request, $id)
    {

        $accountData = AccountChart::firstRow('id',$id);
        $mainData = AccountJournal::specialColumnsDatePage('chart_id',$id);
        $debit = ''; $credit = '';
       
        if($mainData->count() > 0){
        $this->processAccountRegister($accountData,$mainData);
        }
        
        if(in_array($accountData->acct_cat_id,Utility::CREDIT_ACCOUNTS)){
            $credit = 'Credit';   $debit = 'Debit';
        }
        if(in_array($accountData->acct_cat_id,Utility::DEBIT_ACCOUNTS)){
            $credit = 'Payment';   $debit = 'Deposit';
        }
       
            return view::make('account_chart.account_register')->with('mainData',$mainData)
            ->with('accountData',$accountData)->with('debit',$debit)->with('credit',$credit);

    }

    // FROM(2ND LOOP) SUBTRACT/ADD (AMOUNT AND REMAINING BALANCE) BASED ON THE DEBITCREDIT TYPE OF THE PREVIOUS LOOP
    //(IF DEBITCREDIT TYPE FROM PREVIOUS LOOP IS POSITIVE, DO SUBTRACTION, IF NEGATIVE, DO ADDITION)
    public function processAccountRegister($accountData,$dataObj){

        $remBal = !empty($accountData->virtual_balance_trans) ? $accountData->virtual_balance_trans : 0.00;
        $lastId = $dataObj[0]->id; //LAST MEANS LAST ID FOR ACCOUNT IN THE TABLE (AS DATA WAS SELECTED IN DESC ORDER) THE LAST SHALL BE THE FIRST DATA TO SHOW

        $num = 0;
        $count = $dataObj->count();
        foreach($dataObj as $data){
            
            if($data->id == $lastId){
                $data->balanceUpdate = $remBal;
            }

            if($data->id != $lastId){
                $num++;
                $index = ($num >($count-1)) ? $num+1 : $num-1;  // GET PREVIOUS LOOP TRANS_TOTAL IN TERMS OF INDEX OF THE DATA

                $balanceUpdate = $this->calcCreditDebitType($accountData->acct_cat_id,$dataObj[$index]->debit_credit,$remBal,$dataObj[$index]->trans_total);
                $data->balanceUpdate = $balanceUpdate;
                $remBal = $balanceUpdate;
            }

            

            

        }

    }

    public function calcCreditDebitType($acctCategory,$type,$remBal,$amount){
        $newBal = 0;

        //REVERSE SUPPOSED ADDITION TO SUBTRACTION AND SUBTRACTION TO ADDITION TO ACHIEVE ALGORITHM
         //THE NORM SHOULD BE $remBal + $amount IF ITS A CREDIT ACCOUNT, BUT ITS REVERSED TO ACHIEVE ALGORITHM
         if(in_array($acctCategory,Utility::CREDIT_ACCOUNTS)){
            $newBal = ($type == Utility::CREDIT_TABLE_ID) ? $remBal-$amount : $remBal + $amount;
         }

         //REVERSE SUPPOSED ADDITION TO SUBTRACTION AND SUBTRACTION TO ADDITION TO ACHIEVE ALGORITHM
         //THE NORM SHOULD BE $remBal + $amount IF ITS A DEBIT ACCOUNT, BUT ITS REVERSED TO ACHIEVE ALGORITHM
         if(in_array($acctCategory,Utility::DEBIT_ACCOUNTS)){
            $newBal = ($type == Utility::DEBIT_TABLE_ID) ? $remBal-$amount : $remBal + $amount;
         }
         
         return $newBal;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),AccountChart::$mainRules);
        if($validator->passes()){
            $accountCat = $request->input('account_category');

            $countData = AccountChart::countData('acct_name',$request->input('account_name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                Utility::checkCurrencyActiveStatus();   //CHECK IF THERE IS AN ACTIVE CURRENCY
                Utility::checkFinYearActiveStatus();    //CHECK IF THERE IS AN ACTIVE FINANCIAL YEAR

                $password = $request->input('password');
                if(Utility::checkClosingBook($request->input('cost_date'),$password) == Utility::ZERO || Utility::checkClosingBook($request->input('depreciation_date'),$password) == Utility::ZERO){
                    return response()->json([
                        'message2' => 'Transaction of this date and below have been closed, or enter a correct password to get access',
                        'message' => 'warning'
                    ]);
                }

                $dbDATA = [
                    'acct_cat_id' => $request->input('account_category'),
                    'detail_id' => $request->input('detail_type'),
                    'acct_no' => $request->input('account_number'),
                    'acct_name' => ucfirst($request->input('account_name')),
                    'curr_id' => $request->input('currency'),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                
                $currCurrencyCode  = session('currency')['code'];
                $currCurrencyId  = session('currency')['id'];
                $newCurr = Currency::firstRow('id',$request->input('currency'));
                $virtualBalanceTrans = $request->input('original_cost');

                if(in_array($accountCat,Utility::NO_DEPRECIATION_ACCOUNT_CAT_DB_ID) || $accountCat == Utility::FIXED_ASSET_DB_ID){
                    
                    if($accountCat == Utility::FIXED_ASSET_DB_ID){  
                        if(!empty($request->input('original_cost'))){   //IF ORIGINAL COST IS NOT EMPTY ENTER BALANCE
                        //IF DEPRECIATION IS BEEN TRACKED THEN REMOVE DEPRECIATED AMOUNT FROM ORIGINAL COST BELOW
                        $accountChartBalance = (!empty($request->input('depreciation'))) ? $request->input('original_cost') - $request->input('depreciation') : $request->input('original_cost');
                        $dbDATA['original_cost'] = $request->input('original_cost');
                        $dbDATA['virtual_balance_trans'] = $accountChartBalance;
                        $dbDATA['virtual_balance'] = Utility::convertAmount($currCurrencyCode,$newCurr->code,$accountChartBalance);
                        }
                    }
                
                }

                $createChart = AccountChart::create($dbDATA);



                if(in_array($accountCat,Utility::NO_DEPRECIATION_ACCOUNT_CAT_DB_ID) || $accountCat == Utility::FIXED_ASSET_DB_ID){



                    if(empty($request->input('original_cost'))){        //IF ORIGINAL COST IS EMPTY, SAVE DATA AND EXIT PROCESSING OF LEDGER ENTRY BELOW
                        return response()->json([
                            'message' => 'good',
                            'message2' => 'saved'
                        ]);
                    }

                    $finYear = FinancialYear::firstRow('active_status',Utility::STATUS_ACTIVE);
                    $secondAccountCurr = Currency::firstRow('id',Utility::checkDefaultAccountChartCurrency(Utility::OPENING_BALANCE_EQUITY_CHART_ID));
                    $latestExRate = ExchangeRate::where('status',Utility::STATUS_ACTIVE)->OrderBy('id','DESC')->first();
                    $uid = Utility::generateUID('account_journal');

                    
                    $extData = [
                        'uid' => $uid,
                        'trans_total' => $virtualBalanceTrans,
                        'sum_total' => Utility::convertAmount($currCurrencyCode,$newCurr->code,$virtualBalanceTrans),
                        'post_date' => Utility::standardDate($request->input('cost_date')),
                        'ex_rate' => $latestExRate->rates,
                        'created_by' => Auth::user()->id,
                        'journal_status' => Utility::CLOSED_ACCOUNT_STATUS,
                        'transaction_type' => Finance::journalEntry,
                        'balance_status' => Utility::ZERO,
                        'status' => Utility::STATUS_ACTIVE
                    ];

                    $journalExt = JournalExtension::create($extData);

                    $journalDbDATA = [
                        'uid' => $uid,
                        'acct_cat_id' => $request->input('account_category'),
                        'detail_id' => $request->input('detail_type'),
                        'chart_id' => $createChart->id,
                        'account_id' => $createChart->id,
                        'extension_id' => $journalExt->id,
                        'fin_year' => $finYear->id,
                        'trans_desc' => 'Opening Balance',
                        'extended_amount_trans' => $virtualBalanceTrans,
                        'extended_amount' => Utility::convertAmount($currCurrencyCode,$newCurr->code,$virtualBalanceTrans),
                        'trans_total' => $virtualBalanceTrans,
                        'total' => Utility::convertAmount($currCurrencyCode,$newCurr->code,$virtualBalanceTrans),
                        'default_curr' => $currCurrencyId,
                        'trans_curr' => $request->input('currency'),
                        'post_date' => Utility::standardDate($request->input('cost_date')),
                        'trans_date' => Utility::standardDate($request->input('cost_date')),
                        'debit_credit' => Utility::openingBalanceCreditDebit($accountCat),
                        'ex_rate' => $latestExRate->rates,
                        'transaction_type' => Finance::journalEntry,
                        'main_trans' => Utility::STATUS_ACTIVE,
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE


                    ];
                    $create1 = AccountJournal::create($journalDbDATA);
                    $openingBalanceCreditDebit = (Utility::openingBalanceCreditDebit($accountCat) == Utility::DEBIT_TABLE_ID) ? Utility::CREDIT_TABLE_ID : Utility::DEBIT_TABLE_ID;

                    //SECOND JOURNAL ENTRY STARTS FROM HERE COULD BE THE DEBIT OR CREDIT SIDE AND ALSO A NEW OR UPDATE IN THE ACCOUNT BALANCE
                    $secondDebitCredit = (Utility::openingBalanceCreditDebit($accountCat) == Utility::DEBIT_TABLE_ID) ? Utility::CREDIT_TABLE_ID : Utility::DEBIT_TABLE_ID;
                    $openingBalDetails = Utility::openingBalanceObject($accountCat);
                    $virtualBalance = Utility::convertAmount($currCurrencyCode,$openingBalDetails->secondCurrCode,$virtualBalanceTrans);
                    Utility::updateAccountBalance($openingBalDetails->acctChartId,$request->input('original_cost'),$secondDebitCredit);

                    $journalOpenBalanceDbDATA = [
                        'uid' => $uid,
                        'acct_cat_id' => $openingBalDetails->acctCategoryId,
                        'detail_id' =>  $openingBalDetails->acctDetailId,
                        'chart_id' =>  $openingBalDetails->acctChartId,
                        'account_id' => $createChart->id,
                        'extension_id' => $journalExt->id,
                        'fin_year' => $finYear->id,
                        'trans_desc' => 'Opening Balance for '.$request->input('account_name'),
                        'extended_amount_trans' => $virtualBalanceTrans,
                        'extended_amount' => $virtualBalance,
                        'trans_total' => $virtualBalanceTrans,
                        'total' => $virtualBalance,
                        'default_curr' => $currCurrencyId,
                        'trans_curr' => $secondAccountCurr->id,
                        'post_date' => Utility::standardDate($request->input('cost_date')),
                        'trans_date' => Utility::standardDate($request->input('cost_date')),
                        'debit_credit' =>  $secondDebitCredit,
                        'ex_rate' => $latestExRate->rates,
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE,
                        'transaction_type' => Finance::journalEntry,

                    ];
                    
                    $create2 = AccountJournal::create($journalOpenBalanceDbDATA);
                    $selectOpenBalEquity = AccountChart::firstRow('id',Utility::OPENING_BALANCE_EQUITY_CHART_ID);
                    if($selectOpenBalEquity->curr_id == ''){
                        $update = AccountChart::defaultUpdate('id',Utility::OPENING_BALANCE_EQUITY_CHART_ID,['curr_id' => $secondAccountCurr->id]);
                    }

                    //DO THE FOLLOWING IF DEPRECIATION IS CHECKED
                    if($request->input('track_depreciation') == 'checked'){

                        if(empty($request->input('depreciation'))) {        //IF DEPRECIATION AMOUNT IS EMPTY, SAVE DATA AND EXIT PROCESSING OF LEDGER ENTRY BELOW
                            return response()->json([
                                'message' => 'good',
                                'message2' => 'saved'
                            ]);
                        }

                        $depreciationAmount = $request->input('depreciation');
                        $dbDATA = [
                            'acct_cat_id' => $request->input('account_category'),
                            'detail_id' => $request->input('detail_type'),
                            'acct_no' => $request->input('account_number'),
                            'acct_name' => ucfirst($request->input('account_name')).' (Depreciation)',
                            'curr_id' => $request->input('currency'),
                            'original_cost' => $request->input('original_cost'),
                            'virtual_balance_trans' => '-'.$depreciationAmount,
                            'virtual_balance' => '-'.Utility::convertAmount($currCurrencyCode,$newCurr->code,$depreciationAmount),
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];
                        $createChart2 = AccountChart::create($dbDATA);
                        $uid2 = Utility::generateUID('account_journal');

                        $extData = [
                            'uid' => $uid2,
                            'trans_total' => $depreciationAmount,
                            'sum_total' => Utility::convertAmount($currCurrencyCode,$newCurr->code,$depreciationAmount),
                            'post_date' => Utility::standardDate($request->input('cost_date')),
                            'ex_rate' => $newCurr->rates,
                            'created_by' => Auth::user()->id,
                            'journal_status' => Utility::CLOSED_ACCOUNT_STATUS,
                            'transaction_type' => Finance::journalEntry,
                            'balance_status' => Utility::ZERO,
                            'status' => Utility::STATUS_ACTIVE
                        ];

                        $journalExt2 = JournalExtension::create($extData);

                        $journalDbDATA = [
                            'uid' => $uid2,
                            'acct_cat_id' => $request->input('account_category'),
                            'detail_id' => $request->input('detail_type'),
                            'chart_id' => $createChart2->id,
                            'account_id' => $createChart2->id,
                            'extension_id' => $journalExt2->id,
                            'fin_year' => $finYear->id,
                            'trans_desc' => 'Opening Balance',
                            'extended_amount_trans' => $depreciationAmount,
                            'extended_amount' => Utility::convertAmount($currCurrencyCode,$newCurr->code,$depreciationAmount),
                            'trans_total' => $request->input('depreciation'),
                            'total' => Utility::convertAmount($currCurrencyCode,$newCurr->code,$depreciationAmount),
                            'default_curr' => $currCurrencyId,
                            'trans_curr' => $request->input('currency'),
                            'trans_date' => Utility::standardDate($request->input('cost_date')),
                            'post_date' => Utility::standardDate($request->input('cost_date')),
                            'debit_credit' => Utility::CREDIT_TABLE_ID, // ASSET IS CREDITED BECAUSE DEPRECIATION IS A CONTRA-ASSET ACCOUNT, AN ASSET IS BY DEFAULT DEBIT BUT BECAUSE OF DEPRECIATION IT WILL BE CREDITED
                            'ex_rate' => $latestExRate->rates,
                            'depreciation_status' => Utility::STATUS_ACTIVE,
                            'main_trans' => Utility::STATUS_ACTIVE,
                            'transaction_type' => Finance::journalEntry,
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE


                        ];
                        $create1 = AccountJournal::create($journalDbDATA);
                    
                        $secondDebitCredit = (Utility::openingBalanceCreditDebit($accountCat) == Utility::DEBIT_TABLE_ID) ? Utility::CREDIT_TABLE_ID : Utility::DEBIT_TABLE_ID;
                    Utility::updateAccountBalance(Utility::OPENING_BALANCE_EQUITY_CHART_ID,$depreciationAmount,Utility::DEBIT_TABLE_ID);

                        $journalOpenBalanceDbDATA = [
                            'uid' => $uid2,
                            'acct_cat_id' => Utility::OPENING_BALANCE_ACCOUNT_CATEGORY_ID,
                            'detail_id' => Utility::OPENING_BALANCE_DETAIL_ID,
                            'chart_id' => Utility::OPENING_BALANCE_EQUITY_CHART_ID,
                            'account_id' => Utility::OPENING_BALANCE_EQUITY_CHART_ID,
                            'extension_id' => $journalExt2->id,
                            'fin_year' => $finYear->id,
                            'trans_desc' => 'Opening Balance for '.$request->input('account_name'). '(Depreciation)',
                            'extended_amount_trans' => $depreciationAmount,
                            'extended_amount' => Utility::convertAmount($currCurrencyCode,$secondAccountCurr->code,$depreciationAmount),
                            'trans_total' => $depreciationAmount,
                            'total' => Utility::convertAmount($currCurrencyCode,$secondAccountCurr->code,$depreciationAmount),
                            'default_curr' => $currCurrencyId,
                            'trans_curr' => $request->input('currency'),
                            'trans_date' => Utility::standardDate($request->input('depreciation_date')),
                            'post_date' => Utility::standardDate($request->input('depreciation_date')),
                            'debit_credit' => Utility::DEBIT_TABLE_ID,
                            'ex_rate' => $latestExRate->rates,
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE,
                            'transaction_type' => Finance::journalEntry,

                        ];
                        
                        $create2 = AccountJournal::create($journalOpenBalanceDbDATA);

                    }
                    //END OF DEPRECIATION PROCESS


                }

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
        $mainData = AccountChart::firstRow('id',$request->input('dataId'));
        $currency = Currency::getAllData();
        return view::make('account_chart.edit_form')->with('edit',$mainData)->with('currency',$currency);

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

        $validator = Validator::make($request->all(),AccountChart::$mainRulesEdit);
        if($validator->passes()) {

            $checkCurrency = AccountJournal::firstRow('chart_id',$request->input('edit_id'));

            if(!empty($checkCurrency) && $request->input('currency') != $request->input('current_currency_id') ){

                return response()->json([
                    'message2' => 'Currency cannot be changed as this account has already recorded transactions in the general ledger',
                    'message' => 'warning'
                ]);

            }

            $dbDATA = [
                'acct_no' => $request->input('account_number'),
                'acct_name' => $request->input('account_name'),
                'bank_balance' => $request->input('bank_balance'),
                'curr_id' => $request->input('currency'),
                'updated_by' => Auth::user()->id
            ];

            if(in_array($request->input('edit_id'),Utility::DEFAULT_ACCOUNT_CHART)){

                $dbDATA = [
                    'acct_no' => $request->input('account_number'),
                    'bank_balance' => $request->input('bank_balance'),
                    'curr_id' => $request->input('currency'),
                    'updated_by' => Auth::user()->id
                ];

                if(Utility::DEFAULT_BANK_ID_ACCOUNT_CHART == $request->input('account_category_id')){   //ABILITY TO CHANGE DEFAULT BANK ACCOUNT
                    $dbDATA['acct_name'] = $request->input('account_name');
                }
                /*return response()->json([
                    'message2' => 'Default chart of accounts cannot be modified',
                    'message' => 'warning'
                ]);*/

            }



            AccountChart::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
     * Search the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $input
     * @return \Illuminate\Http\Response
     */
    public function searchAccount(Request $request)
    {
        //
        $searchVal = $_GET['searchVar'];
        if($searchVal != '') {
            $search = AccountChart::searchAccount($searchVal);

            $obtain_array = [];

            foreach ($search as $data) {

                $obtain_array[] = $data->id;
            }

            $account_ids = array_unique($obtain_array);
            //print_r($account_ids); exit();
            $fetchData =  AccountChart::massDataCondition('id', $account_ids, 'active_status', Utility::STATUS_ACTIVE);
            return view::make('account_chart.search')->with('mainData',$fetchData);
        }else{
            return 'No match found';
        }

        

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

        if(Utility::checkArraySimilarity($all_id,Utility::DEFAULT_ACCOUNT_CHART) == true){
            return response()->json([
                'message2' => 'You cannot delete any selected default account, please deselect default accounts to continue this process',
                'message' => 'warning'
            ]);
        }

        $password = $request->input('input_text');

        $in_use = [];
        $unused = [];
        for($i=0;$i<count($all_id);$i++){
            $checkJournal = AccountJournal::where('chart_id',$all_id[$i])->orderBy('id','DESC')->first();
            //dd($checkJournal); exit();
            if(!empty($checkJournal)){
                if(Utility::checkClosingBook($checkJournal->trans_date,$password) == Utility::ZERO){
                    $unused[$i] = $all_id[$i];
                }else{
                    $in_use[$i] = $all_id[$i];
                }

            }else{
                $in_use[$i] = $all_id[$i];
            }
        }
        $message = (count($unused) > 0) ? ' and '.count($unused).
            ' account(s) last transaction is dated before or on the date of closing book and cannot be deleted. You can enter a correct password to these accounts' : '';
        if(count($in_use) > 0){
            $delete = AccountChart::massUpdate('id',$in_use,$dbData);

            return response()->json([
                'message' => 'deleted',
                'message2' => count($in_use).' data(s) has been deleted '.$message
            ]);

        }else{
            return  response()->json([
                'message2' => count($unused).' account(s) last transaction is dated before or on the date of closing book and cannot be deleted You can enter a correct password to these accounts',
                'message' => 'warning'
            ]);

        }
    }

    public function changeStatus(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $status = $request->input('status');
        $dbData = [
            'active_status' => $status
        ];
        $delete = AccountChart::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
        ]);

    }


}
