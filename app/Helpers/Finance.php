<?php
/**
 * Created by PhpStorm.
 * User: snweze
 * Date: 3/8/2018
 * Time: 9:22 AM
 */

namespace App\Helpers;
use App\model\VehicleFleetAccess;
use Illuminate\Http\Request;
use App\model\AccountJournal;
use App\model\JournalExtension;
use App\model\Currency;
use App\model\VendorCustomer;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;
use view;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Psy\Exception\ErrorException;
use Illuminate\Support\Facades\Storage;
use App\Mail\DemoMail;
use App\model\AccountChart;
use App\model\ExchangeRate;
use App\model\FinancialYear;
use App\model\Inventory;
use App\model\JournalDefaultTransactionAccount;

class Finance
{

    protected static $currDateRates;
    protected static $defaultCurrAmount;

    //CUSTOMER TRANSACTIONS................
    const cashPaymentReceipt = 1;
    const invoicePaymentReceipt = 2;
    const invoice = 3;
    const creditMemo = 4;
    const refundReceipt = 5;

    //VENDOR TANSACTIONS...................
    const expenses = 6;
    const bill = 7;
    const cashBillPayment = 8;
    const existingBillCashPayment = 9;
    const vendorCredit = 10;
    const payroll = 11;

    //OTHER TRANSACTIONS.................
    const journalEntry = 12;
    const BankDeposit = 13;

    //FOR REPORTING
    const accrualBasis = 1, cashBasis = 2;
    const cashBasisAssetAccounts = [3,4,2,5], cashBasisLiabilityAccounts = [7,8,9];
    const bsAssets = [1,2,3,4,5], bsLiability = [6,7,8,9], bsEquity = [10];  // BS (BALANCE SHEET)
    
    const accrualBasisTransactions = [
        self::cashPaymentReceipt,
        self::invoicePaymentReceipt,
        self::refundReceipt,
        self::expenses,
        self::cashBillPayment,
        self::existingBillCashPayment,
        self::vendorCredit,
        self::creditMemo,
        self::invoice,
        self::bill,
        self::journalEntry
    ];

    const cashBasisTransactions = [
        self::cashPaymentReceipt,
        self::refundReceipt,
        self::expenses,
        self::cashBillPayment,
        self::existingBillCashPayment,
    ];

    const vendorTransactions = [
        self::expenses,
        self::existingBillCashPayment,
        self::vendorCredit,
        self::bill,
        self::journalEntry
    ];

    const customerTransactions = [
        self::cashPaymentReceipt,
        self::invoicePaymentReceipt,
        self::refundReceipt,
        self::creditMemo,
        self::invoice,
        self::journalEntry
    ];

    const defaultOpenTransactions = [
        self::vendorCredit,
        self::creditMemo,
        self::invoice,
        self::bill
    ];

    const incomeAccountCategory = 11;
    const COGAccountCategory = 13;
    const expenseAccountCategory = 14;
    const otherIncomeAccountCategory = 12;
    const otherExpenseAccountCategory = 15;
    const inventoryReport = 1, accountReport = 2, transactionReport = 3;


    //FOR RECORDING TRANSACTIONS
    const incomeAccount = 1, ExpenseAccount = 2;    
    const discountAllowedTransactions = [self::invoicePaymentReceipt,self::cashPaymentReceipt,self::refundReceipt,self::creditMemo];
    const inventoryDiscountTranscations = [self::existingBillCashPayment,self::vendorCredit,self::cashBillPayment];
    const discountReceivedTransactions = [self::expenses];  // OCCASIONALLY CASHBILLPAYMENT AND CASHPAYMENT CAN BE DICSOUNT RECEIVED
    const COGTransactions = [self::cashPaymentReceipt,self::invoice,self::creditMemo,self::refundReceipt]; //COST OF GOOD SOLD TRANSACTIONS 
    const inventoryTransactions = [self::expenses,self::cashBillPayment,self::bill,self::vendorCredit]; //EXPENSE SOMETIMES MIGHT NOT HAVE AN INVENTORY IN THE TRANSACTION
    const debitAccountChart = [self::refundReceipt,self::creditMemo,self::expenses,self::cashBillPayment,self::bill];
    const creditAccountChart = [self::cashPaymentReceipt,self::invoice,self::vendorCredit];

    const reconciled = 1, cleared = 2, uncleared = 3;

    public static function convertAmountToDate($currCurrencyCode,$newCurrencyCode,$amount,$postDate){

        $defaultAmount = self::$defaultCurrAmount;
        if(!empty($defaultAmount)){
            $defaultCurr = $defaultAmount;
            $converted = ($currCurrencyCode == $newCurrencyCode) ? $amount : $amount/$defaultCurr;
            return Utility::roundNum($converted,2);
        }
        $dateRates = self::$currDateRates;

        $curr = 'USD'.$currCurrencyCode;
        $rates = json_decode($dateRates,true);
        $currRate = $rates['quotes'][$curr];
        $dollarAmt = $amount/$currRate;
        $new = 'USD'.$newCurrencyCode;
        $newRate = $rates['quotes'][$new];
        $converted = $dollarAmt*$newRate;
        
        return Utility::roundNum($converted,2);        

    }

    public static function defaultCurrObj(){
        return Currency::firstRow('active_status',Utility::STATUS_ACTIVE);
    }

    public static function defaultFinYearObj(){
        return FinancialYear::firstRow('active_status',Utility::STATUS_ACTIVE);
    }

    public static function latestExchangeRate(){
        return ExchangeRate::where('status',Utility::STATUS_ACTIVE)->OrderBy('id','DESC')->first();
    }

    //GETS DEFAULT TRANSACTION ACCOUNTS
    public static function defaultTransactionAccounts(){
        return JournalDefaultTransactionAccount::where('status',Utility::STATUS_ACTIVE)->where('active_status',Utility::STATUS_ACTIVE)->OrderBy('id','DESC')->first();
    }

    //ALLOWS DISPLAY OF TRANSACTION TYPE DETAIL BY PASSING THE TRANSACTON TYPE PARAMETER
    public static function transType($transactionType){
        $status = '';        

        switch ($transactionType) {
            case self::cashPaymentReceipt:
                $status = 'Sales Receipt';
                break;
            case self::invoicePaymentReceipt:
                $status = 'Invoice Payment Receipt';
                break;
            case self::refundReceipt:
                $status = 'Refund Receipt';
                break;
            case self::expenses:
                $status = 'Expense';
                break;
            case self::cashBillPayment:
                $status = 'Direct Bill Payment';
                break;
            case self::existingBillCashPayment:
                $status = 'Existing Bill Payment';
                break;
            case self::vendorCredit:
                $status = 'Vendor Credit';
                break;
            case self::creditMemo:
                $status = 'Credit Memo';
                break;
            case self::invoice:
                $status = 'Invoice';
                break;
            case self::bill:
                $status = 'Bill';
                break; 
            case self::journalEntry:
                $status = 'Journal Entry';
                break;    

            default:
                $status = '';
                break;
        }
        return $status;
    }

    //ALLOWS DISPLAY OF TRANSACTION TYPE DETAIL BY PASSING THE TRANSACTON TYPE PARAMETER
    public static function reconcileStatus($reconcileStatus){
        $status = '';        

        switch ($reconcileStatus) {
            case self::uncleared:
                $status = 'Uncleared';
                break;
            case self::cleared:
                $status = 'Cleared';
                break;
            case self::reconciled:
                $status = 'Reconciled';
                break;            
            default:
                $status = '';
                break;
        }
        return $status;
    }

    //STORE RECONCILED ACCOUNTS AND SOME DETAILS FOR CHANGES THAT MIGHT OCCURRED DURING UPDATE
    public static function assembleTransDetails(&$arrStore,$dbData){

        if($dbData->count() > 0){
            foreach($dbData as $data){
                if(!empty($data->item_id)){
                    $arrStore[] = [$data->chart_id,$data->trans_total,$data->post_date,$data->item_id,$data->reconcile_id];   //[ACCOUNT_ID,AMOUNT,ITEM_ID]
                }else{
                    $arrStore[] = [$data->chart_id,$data->trans_total,$data->post_date,$data->reconcile_id];   //[ACCOUNT_ID,AMOUNT]   
                }
            }
        }

    }

     //DETECT IF THERE IS A CHANGE IN FORMER TRANSACTION TO DETERMINE THE RECONCILE STATUS DURING EDITIING TRANSACTION
     public static function detectTransChange(&$virtualObj,$chartId,$amount,$postDate,$itemId = ''){
        $arrStore = $virtualObj->reconcileArr;
        if(count($arrStore)>0){
            foreach($arrStore as $key => $data){    //$data IS CONTAINS [ACCOUNT_ID,AMOUNT,POST_DATE,ITEM_ID];
                if(!empty($item_id)){
                    //IF ACCOUNT/CHART ID, AMOUNT AND ITEM ID REMAINS THE SAM
                   if($chartId == $data[0] && $amount == $data[1] && $postDate == $data[2] && $itemId == $data[3]){
                       $virtualObj->reconcileStatus = self::reconciled;
                       $virtualObj->reconcileId = $data[4];
                       unset($arrStore[$key]);
                   }else{
                       $virtualObj->reconcileStatus = self::uncleared;
                   }
                break;
                }
                
                if(empty($itemId)){
                    if($chartId == $data[0] && $amount == $data[1] && $postDate == $data[2]){
                        $virtualObj->reconcileStatus = self::reconciled;
                        $virtualObj->reconcileId = $data[3];
                        unset($arrStore[$key]); //REMOVE ARRAY ITEM ID THERE WAS NO CHANGE
                    }else{
                        $virtualObj->reconcileStatus = self::uncleared;
                    } 
                break;
                }
            }
        }

    }

    public static function cashPaymentReceipt($request){

        //SUM TOTAL FOR DEBIT/CREDIT SIDE SHOULD BE (SUM TOTAL AFTER TAX)
        //DEBIT CASH (AS RECEIVED FROM CUSTOMER),COG(EXPENSE ACCOUNT I.E UNIT COST)
        //CREDIT INCOME ACCOUNT(SUM TOTAL AFTER), INVENTORY (ASSET ACCOUNT UNIT COST)

        //GENERAL VARIABLES
        $postingDate = $request->input('posting_date'); $prefCustomer = $request->input('pref_customer');

        $fileNo = $request->input('file_no');
        $paymentReceiptAccount = $request->input('receipt_account');    $password = $request->input('password'); 
        $employeeId = $request->input('employee');  $transactionFormat = $request->input('payment_method');
        $billingAddress = $request->input('billing_address'); $transactionClass = $request->input('transaction_class');
        $location = $request->input('location'); $updateStatus = $request->input('update_status');
        $convertStatus = $request->input('convert_status');

         $grandTotalForeignCurr = $request->input('grand_total'); //THIS VARIABLE IS ACTUALLY THE FOREIGN CURRENCY SO DON'T BE CONFUSED ABOUT THE NAMES
        $grandTotal = $request->input('grand_total_vendor_curr');   // THIS IS ACTUALLY THE DEFAULT CURRENCY SO DON'T BE CONFUSED ABOUT THE NAMES
        $mailOption = $request->input('mail_option'); $emails = $request->input('emails'); $file = $request->input('file');
        $message = Utility::urlDecode($request->input('mail_message'));  $oneTimePerct = $request->input('one_time_perct');
        
        $oneTimeTax = (($updateStatus == 1 && $convertStatus == 1) || $updateStatus == 1) ? $request->input('one_time_tax_amount_edit') : $request->input('one_time_tax_amount');
        $oneTimeTaxAmount = (!empty($oneTimeTax)) ? $oneTimeTax : 0.00;

        $oneTimeDiscountAmount = (($updateStatus == 1 && $convertStatus == 1) || $updateStatus == 1) ? $request->input('one_time_discount_amount_edit') : $request->input('one_time_discount_amount');
         $taxType = $request->input('tax_type');
        $discountType = $request->input('discount_type'); $oneTimeTaxPerct = $request->input('one_time_tax_perct');
        $mailCopy = $request->input('mail_copy'); $journalStatus = Utility::CLOSED_ACCOUNT_STATUS;
        $oneTimeDiscount = (!empty($oneTimeDiscountAmount)) ? $oneTimeDiscountAmount : 0.00;
        $amountExclTax = $grandTotal - $oneTimeTaxAmount;    //INCLUDING DISCOUNT IF THERE IS ANY BUT EXCLUDING TAX
                

        $files = $request->file('file');
        $attachment = [];
        $mailFiles = [];
            
        self::validateFinanceTransaction($postingDate,$password);  //ENSURE THAT EVERYTHING IS SET BEFORE A TRANSACTION CAN ENTER THE JOURNAL
        
        $contact = $prefCustomer;
        $contactType = Utility::CUSTOMER;
        $contactData = VendorCustomer::firstRow('id',$contact);
        $currCode = $contactData->currency->code;
        $currId = $contactData->currency_id;
        $employeeId = '';
        $latestExRate = self::latestExchangeRate();
        if(empty($prefCustomer)){
            $contact = '';
            $contactType = '';
            $currCode = Utility::currencyArrayItem('code');
            $currId = Utility::currencyArrayItem('id');
            $employeeId = $request->input('employee');
        }


        $uid = Utility::generateUID('journal_extention');

        $virtualObj = new \stdClass();
        $virtualObj->uid = $uid;
        $virtualObj->contact = $contact;
        $virtualObj->contactType = $contactType;
        $virtualObj->currId = $currId;
        $virtualObj->currCode = $currCode;
        $virtualObj->employeeId = $employeeId;
        $virtualObj->transactionType = self::cashPaymentReceipt;
        $virtualObj->mailFiles = $mailFiles;
        $virtualObj->transactionClass = $transactionClass;
        $virtualObj->location = $location;
        $virtualObj->postDate = Utility::standardDate($postingDate);
        $virtualObj->reconcileId = '';
        $virtualObj->reconcileArr = [];
        $virtualObj->reconcileStatus = self::uncleared;
        $virtualObj->finYear = self::defaultFinYearObj()->id;        
        $virtualObj->cashStatus = Utility::STATUS_ACTIVE;
        
        //DEBIT ACCOUNTS
        $virtualObj->cashReceived = $grandTotal;
        $virtualObj->COG = 0; //CANT BE ZERO, TO BE OBTAINED FROM THE EACH INVENTORY IN A LOOP
        $virtualObj->discountAllowed = $oneTimeDiscount;    //SEE AUTO DISCOUNT METHOD/FUNCTION FOR FURTHER EXPLANATION

         //DEBIT ACCOUNT TYPE
         $virtualObj->cashReceiptAccount = Utility::DEBIT_TABLE_ID;
         $virtualObj->COGAccount = Utility::DEBIT_TABLE_ID;
         $virtualObj->discountAllowedAccount = Utility::DEBIT_TABLE_ID; //SEE AUTO DISCOUNT METHOD FOR FURTHER EXPLANATION

        //CREDIT ACCOUNTS
        $virtualObj->income =  0; //CANT BE ZERO, TO BE OBTAINED FROM EACH RATE*QUANTITY(IF QUANTITY EXISTS) IN A LOOP
        $virtualObj->inventory = 0; //IF EXISTS, CANT BE ZERO, TO BE OBTAINED FROM EACH INVENTORY UNIT COST ITEM IN A LOOP
        $virtualObj->tax = $oneTimeTaxAmount;
        $virtualObj->discountInventoryAccount = $oneTimeDiscount;   //SEE AUTO DISCOUNT METHOD FOR FURTHER EXPLANATION

        //CREDIT ACCOUNT TYPE
        $virtualObj->incomeAccount = Utility::CREDIT_TABLE_ID;
        $virtualObj->inventoryAccount = Utility::CREDIT_TABLE_ID;
        $virtualObj->taxAccount = Utility::CREDIT_TABLE_ID;
        $virtualObj->discountInventoryAccount = Utility::CREDIT_TABLE_ID;   ////SEE AUTO DISCOUNT METHOD FOR FURTHER EXPLANATION


        //UPLOAD FILE IF IT EXISTS
        if($files != ''){
            foreach($files as $file){
                //return$file;
                $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                //array_push($cdn_images,$file_name);
                $attachment[] =  $file_name;
                $mailFiles[] = Utility::FILE_URL($file_name);

                $file->move(
                    Utility::FILE_URL(), $file_name
                );

            }
        }

         //SELECT FROM DB DEFAULT EXCHANGE RATE
         $defaultCurrSelect = Utility::firstRow2('currency','default_curr_status',Utility::STATUS_ACTIVE,'code',$virtualObj->currCode);
         $defaultCurrAmount = (!empty($defaultCurrSelect)) ? $defaultCurrSelect->default_currency : '';

         $getCurrRates = Utility::ratesBasedOnDateData($virtualObj->postDate);  //SELECT LATEST CURRENCY RATE IN CASE THERE IS NO DEFAULT FOR SELECTED CURRENCY
                 
         self::$defaultCurrAmount = $defaultCurrAmount;  //USED IN convertAmountToDate method for conversion to default exchange rate       
         self::$currDateRates = $getCurrRates->rates;   //USED IN convertAmountToDate method for conversion to exchange rate from web

        $extData = [
            'uid' => $uid,
            'file_no' => $fileNo,
            'sum_total' => $grandTotalForeignCurr,
            'trans_total' => $grandTotal,
            'balance' => $grandTotalForeignCurr,
            'balance_trans' => $grandTotal,
            'total_excl_tax' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$amountExclTax,$postingDate),
            'total_excl_tax_trans' => $amountExclTax,
            'balance_paid' => $grandTotalForeignCurr,
            'balance_paid_trans' => $grandTotal,
            'balance_status' => Utility::ZERO,
            'discount_total' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$oneTimeDiscount,$postingDate),
            'discount_trans' => $oneTimeDiscount,
            'discount_perct' => $oneTimePerct,
            'discount_type' => $discountType,                
            'tax_total' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$oneTimeTaxAmount,$postingDate),
            'tax_trans' => $oneTimeTaxAmount,
            'tax_perct' => $oneTimeTaxPerct,
            'tax_type' => $taxType,
            'message' => $message,
            'mails' => $emails,
            'mail_copy' => $mailCopy,
            'attachment' => json_encode($attachment,true),
            'default_curr' => Utility::currencyArrayItem('id'),
            'trans_curr' => $virtualObj->currId,
            'vendor_customer' => $virtualObj->contact,
            'post_date' => Utility::standardDate($postingDate),
            'ex_rate' => $latestExRate->rates,
            'created_by' => Auth::user()->id,
            'fin_year' => $virtualObj->finYear,
            'journal_status' => $journalStatus,
            'transaction_type' => $virtualObj->transactionType,
            'transaction_format' => $transactionFormat,
            'class_id' => $transactionClass,
            'location_id' => $location,
            'billing_address' => $billingAddress,
            'contact_type' => $virtualObj->contactType,
            'print_status' => $request->input('print_status'),
            'created_by' => Auth::user()->id,
            'status' => Utility::STATUS_ACTIVE,
            'cash_status' => $virtualObj->cashStatus
        ];

        $updateId = $request->input('edit_id');
         if(!empty($updateId)){
            $journalAccounts = AccountJournal::specialColumnsCustom2('extension_id',$updateId,'reconcile_status',self::reconciled,['chart_id','trans_total','post_date','item_id','reconcile_id']);
            
            //STORE RECONCILED ACCOUNTS AND SOME DETAILS FOR CHANGES OCCURRED DURING UPDATE            
            self::assembleTransDetails($virtualObj->reconcileArr,$journalAccounts);
            
        }

        

        self::autoTransaction($request,$extData,$virtualObj); //CREATE DETAILS TO JOURNAL
        
        if(!empty($virtualObj->reconcileArr)){
            //DETECT IF THERE IS A CHANGE IN FORMER TRANSACTION TO DETERMINE THE RECONCILE STATUS DURING EDITIING TRANSACTION
            self::detectTransChange($virtualObj,$paymentReceiptAccount,$virtualObj->cashReceived,$virtualObj->postDate);
        }

        //SAVE CASH AMOUNT TRANSACTION TO JOURNAL
        self::virtualTransaction($paymentReceiptAccount,$request,$virtualObj,$virtualObj->cashReceived,$virtualObj->cashReceiptAccount);
                
        $defaultTransactionAccounts = self::defaultTransactionAccounts();

        if(!empty($virtualObj->reconcileArr)){
            //DETECT IF THERE IS A CHANGE IN FORMER TRANSACTION TO DETERMINE THE RECONCILE STATUS DURING EDITIING TRANSACTION
            self::detectTransChange($virtualObj,$defaultTransactionAccounts->default_sales_tax,$virtualObj->tax,$virtualObj->postDate);
        }
        //SAVE TAX AMOUNT TRANSACTION TO JOURNAL IF THERE IS TAX
        if(!empty($oneTimeTaxAmount) && $oneTimeTaxAmount > 0){
            self::virtualTransaction($defaultTransactionAccounts->default_sales_tax,$request,$virtualObj,$virtualObj->tax,$virtualObj->taxAccount);
        }

    }

    public static function invoice($request){

        //SUM TOTAL FOR DEBIT/CREDIT SIDE SHOULD BE (SUM TOTAL)
        //DEBIT ACCOUNT RECEIVABLE ,COG(EXPENSE ACCOUNT I.E UNIT COST)
        //CREDIT INCOME ACCOUNT(SUM TOTAL), INVENTORY (UNIT COST OF ITEM)
        
        //GENERAL VARIABLES
        $postingDate = $request->input('posting_date'); $prefCustomer = $request->input('pref_customer');

        $fileNo = $request->input('file_no');  $password = $request->input('password'); 
        $employeeId = $request->input('employee');   $transactionTerms = $request->input('terms');
        $billingAddress = $request->input('billing_address'); $transactionClass = $request->input('transaction_class');
        $location = $request->input('location');    $updateStatus = $request->input('update_status');
        $convertStatus = $request->input('convert_status');
        
         $grandTotalForeignCurr = $request->input('grand_total'); //THIS VARIABLE IS ACTUALLY THE FOREIGN CURRENCY SO DON'T BE CONFUSED ABOUT THE NAMES
        $grandTotal = $request->input('grand_total_vendor_curr');   // THIS IS ACTUALLY THE DEFAULT CURRENCY SO DON'T BE CONFUSED ABOUT THE NAMES
        $mailOption = $request->input('mail_option'); $emails = $request->input('emails'); $file = $request->input('file');
        $message = Utility::urlDecode($request->input('mail_message'));  $oneTimePerct = $request->input('one_time_perct');
        
        $oneTimeTax = (($updateStatus == 1 && $convertStatus == 1) || $updateStatus == 1) ? $request->input('one_time_tax_amount_edit') : $request->input('one_time_tax_amount');
        $oneTimeTaxAmount = (!empty($oneTimeTax)) ? $oneTimeTax : 0.00;

        $oneTimeDiscountAmount = (($updateStatus == 1 && $convertStatus == 1) || $updateStatus == 1) ? $request->input('one_time_discount_amount_edit') : $request->input('one_time_discount_amount');
         $taxType = $request->input('tax_type');
        $discountType = $request->input('discount_type'); $oneTimeTaxPerct = $request->input('one_time_tax_perct');
        $mailCopy = $request->input('mail_copy'); $journalStatus = $request->input('status');
        $oneTimeDiscount = (!empty($oneTimeDiscountAmount)) ? $oneTimeDiscountAmount : 0.00;
        $amountExclTax = Utility::roundNum($grandTotal-$oneTimeTaxAmount,2);    //INCLUDING DISCOUNT IF THERE IS ANY BUT EXCLUDING TAX
                
        $files = $request->file('file');
        $attachment = [];
        $mailFiles = [];
            
        self::validateFinanceTransaction($postingDate,$password);  //ENSURE THAT EVERYTHING IS SET BEFORE A TRANSACTION CAN ENTER THE JOURNAL
        
        $contact = $prefCustomer;
        $contactType = Utility::CUSTOMER;
        $contactData = VendorCustomer::firstRow('id',$contact);
        $currCode = $contactData->currency->code;
        $currId = $contactData->currency_id;
        $employeeId = '';
        $defaultCurrObj = self::defaultCurrObj();
        $latestExRate = self::latestExchangeRate();
        if(empty($prefCustomer)){
            $contact = '';
            $contactType = '';
            $currCode = Utility::currencyArrayItem('code');
            $currId = Utility::currencyArrayItem('id');
            $employeeId = $request->input('employee');
        }


        $uid = Utility::generateUID('journal_extention');

        $virtualObj = new \stdClass();
        $virtualObj->uid = $uid;
        $virtualObj->contact = $contact;
        $virtualObj->contactType = $contactType;
        $virtualObj->currId = $currId;
        $virtualObj->currCode = $currCode;
        $virtualObj->employeeId = $employeeId;
        $virtualObj->transactionType = self::invoice;
        $virtualObj->mailFiles = $mailFiles;
        $virtualObj->transactionClass = $transactionClass;
        $virtualObj->location = $location;
        $virtualObj->postDate = Utility::standardDate($postingDate);
        $virtualObj->reconcileId = '';
        $virtualObj->reconcileArr = [];
        $virtualObj->reconcileStatus = self::uncleared;
        $virtualObj->finYear = self::defaultFinYearObj()->id;      
        $virtualObj->cashStatus = Utility::ZERO;
        
        //DEBIT ACCOUNTS
        $virtualObj->accountReceivable = $grandTotal; //AMOUNT INCLUDING TAX
        $virtualObj->COG = 0; //CANT BE ZERO, TO BE OBTAINED FROM THE EACH INVENTORY IN A LOOP

         //DEBIT ACCOUNT TYPE
         $virtualObj->accountReceivableAccount = Utility::DEBIT_TABLE_ID;
         $virtualObj->COGAccount = Utility::DEBIT_TABLE_ID;

        //CREDIT ACCOUNTS
        $virtualObj->income =  0; //CANT BE ZERO, TO BE OBTAINED FROM EACH RATE*QUANTITY(IF QUANTITY EXISTS) IN A LOOP
        $virtualObj->inventory = 0; //IF EXISTS, CANT BE ZERO, TO BE OBTAINED FROM EACH INVENTORY UNIT COST ITEM IN A LOOP
        $virtualObj->tax = $oneTimeTaxAmount;

        //CREDIT ACCOUNT TYPE
        $virtualObj->incomeAccount = Utility::CREDIT_TABLE_ID;
        $virtualObj->inventoryAccount = Utility::CREDIT_TABLE_ID; 
        $virtualObj->taxAccount = Utility::CREDIT_TABLE_ID; 

        //UPLOAD FILE IF IT EXISTS
        if($files != ''){
            foreach($files as $file){
                //return$file;
                $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                //array_push($cdn_images,$file_name);
                $attachment[] =  $file_name;
                $mailFiles[] = Utility::FILE_URL($file_name);

                $file->move(
                    Utility::FILE_URL(), $file_name
                );

            }
        }

         //SELECT FROM DB DEFAULT EXCHANGE RATE
         $defaultCurrSelect = Utility::firstRow2('currency','default_curr_status',Utility::STATUS_ACTIVE,'code',$virtualObj->currCode);
         $defaultCurrAmount = (!empty($defaultCurrSelect)) ? $defaultCurrSelect->default_currency : '';

         $getCurrRates = Utility::ratesBasedOnDateData($virtualObj->postDate);  //SELECT LATEST CURRENCY RATE IN CASE THERE IS NO DEFAULT FOR SELECTED CURRENCY
                 
         self::$defaultCurrAmount = $defaultCurrAmount;  //USED IN convertAmountToDate method for conversion to default exchange rate       
         self::$currDateRates = $getCurrRates->rates;   //USED IN convertAmountToDate method for conversion to exchange rate from web

        $extData = [
            'uid' => $uid,
            'file_no' => $fileNo,
            'sum_total' => $grandTotalForeignCurr,
            'trans_total' => $grandTotal,
            'total_excl_tax' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$amountExclTax,$postingDate),
            'total_excl_tax_trans' => $amountExclTax,
            'discount_total' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$oneTimeDiscount,$postingDate),
            'discount_trans' => $oneTimeDiscount,
            'discount_perct' => $oneTimePerct,
            'discount_type' => $discountType,                
            'tax_total' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$oneTimeTaxAmount,$postingDate),
            'tax_trans' => $oneTimeTaxAmount,
            'tax_perct' => $oneTimeTaxPerct,
            'tax_type' => $taxType,
            'message' => $message,
            'mails' => $emails,
            'mail_copy' => $mailCopy,
            'attachment' => json_encode($attachment,true),
            'default_curr' => Utility::currencyArrayItem('id'),
            'trans_curr' => $virtualObj->currId,
            'vendor_customer' => $virtualObj->contact,
            'post_date' => Utility::standardDate($postingDate),
            'default_curr' => Utility::currencyArrayItem('id'),
            'post_date' => Utility::standardDate($request->input('posting_date')),
            'ex_rate' => $latestExRate->rates,
            'created_by' => Auth::user()->id,
            'fin_year' => $virtualObj->finYear,
            'journal_status' => $journalStatus,
            'transaction_type' => $virtualObj->transactionType,
            'terms' => $transactionTerms,
            'due_date' => Utility::termsToDueDate($transactionTerms,$virtualObj->postDate),
            'billing_address' => $billingAddress,
            'class_id' => $transactionClass,
            'location_id' => $location,
            'contact_type' => $virtualObj->contactType,
            'print_status' => $request->input('print_status'),
            'created_by' => Auth::user()->id,
            'status' => Utility::STATUS_ACTIVE
        ];       

        $updateId = $request->input('edit_id');

        if(empty($updateId)){
            $extData['balance_trans'] = $grandTotal;
            $extData['balance'] = $grandTotalForeignCurr;
            $extData['balance_status'] = Utility::STATUS_ACTIVE;
        }
       
         if(!empty($updateId)){
            $journalAccounts = AccountJournal::specialColumnsCustom2('extension_id',$updateId,'reconcile_status',self::reconciled,['chart_id','trans_total','post_date','item_id','reconcile_id']);
            
            //STORE RECONCILED ACCOUNTS AND SOME DETAILS FOR CHANGES OCCURRED DURING UPDATE            
            self::assembleTransDetails($virtualObj->reconcileArr,$journalAccounts);
        }

        self::autoTransaction($request,$extData,$virtualObj); //CREATE DETAILS TO JOURNAL

        $defaultTransactionAccounts = self::defaultTransactionAccounts();

        if(!empty($virtualObj->reconcileArr)){
            //DETECT IF THERE IS A CHANGE IN FORMER TRANSACTION TO DETERMINE THE RECONCILE STATUS DURING EDITIING TRANSACTION
            self::detectTransChange($virtualObj,$defaultTransactionAccounts->default_account_receivable,$virtualObj->accountReceivable,$virtualObj->postDate);
        }

        //SAVE ACCOUNT RECEIVABLE AMOUNT TRANSACTION TO JOURNAL
        self::virtualTransaction($defaultTransactionAccounts->default_account_receivable,$request,$virtualObj,$virtualObj->accountReceivable,$virtualObj->accountReceivableAccount);

        if(!empty($virtualObj->reconcileArr)){
            //DETECT IF THERE IS A CHANGE IN FORMER TRANSACTION TO DETERMINE THE RECONCILE STATUS DURING EDITIING TRANSACTION
            self::detectTransChange($virtualObj,$defaultTransactionAccounts->default_sales_tax,$virtualObj->tax,$virtualObj->postDate);
        }

        //SAVE TAX AMOUNT TRANSACTION TO JOURNAL IF THERE IS TAX
        if(!empty($oneTimeTaxAmount) && $oneTimeTaxAmount > 0){
            self::virtualTransaction($defaultTransactionAccounts->default_sales_tax,$request,$virtualObj,$virtualObj->tax,$virtualObj->taxAccount);
        }
        
    }

    public static function expenses($request){

        //SUM TOTAL FOR DEBIT/CREDIT SIDE SHOULD BE (SUM TOTAL)
        //DEBIT EXPENSE ACCOUNT AND/OR INVENTORY (SUM TOTAL)
        //CREDIT CASH (AS PAID TO VENDOR)

        //GENERAL VARIABLES
        $postingDate = $request->input('posting_date'); $prefVendor = $request->input('pref_vendor');

        $fileNo = $request->input('file_no');
        $paymentAccount = $request->input('payment_account');    $password = $request->input('password'); 
        $employeeId = $request->input('employee');  $transactionFormat = $request->input('payment_method');
        $transactionClass = $request->input('transaction_class');    $location = $request->input('location');
        $updateStatus = $request->input('update_status');  $convertStatus = $request->input('convert_status');
        $vendorAddress = $request->input('vendor_address');

         $grandTotalForeignCurr = $request->input('grand_total'); //THIS VARIABLE IS ACTUALLY THE FOREIGN CURRENCY SO DON'T BE CONFUSED ABOUT THE NAMES
        $grandTotal = $request->input('grand_total_vendor_curr');   // THIS IS ACTUALLY THE DEFAULT CURRENCY SO DON'T BE CONFUSED ABOUT THE NAMES
        $mailOption = $request->input('mail_option'); $emails = $request->input('emails'); $file = $request->input('file');
        $message = Utility::urlDecode($request->input('mail_message'));  $oneTimePerct = $request->input('one_time_perct');
        
        $oneTimeTax = (($updateStatus == 1 && $convertStatus == 1) || $updateStatus == 1) ? $request->input('one_time_tax_amount_edit') : $request->input('one_time_tax_amount');
        $oneTimeTaxAmount = (!empty($oneTimeTax)) ? $oneTimeTax : 0.00;

        $oneTimeDiscountAmount = (($updateStatus == 1 && $convertStatus == 1) || $updateStatus == 1) ? $request->input('one_time_discount_amount_edit') : $request->input('one_time_discount_amount');
         $taxType = $request->input('tax_type');
        $discountType = $request->input('discount_type'); $oneTimeTaxPerct = $request->input('one_time_tax_perct');
        $mailCopy = $request->input('mail_copy'); $journalStatus = Utility::CLOSED_ACCOUNT_STATUS;
        $oneTimeDiscount = (!empty($oneTimeDiscountAmount)) ? $oneTimeDiscountAmount : 0.00;
        $amountExclTax = $grandTotal - $oneTimeTaxAmount;    //INCLUDING DISCOUNT IF THERE IS ANY BUT EXCLUDING TAX

        $files = $request->file('file');
        $attachment = [];
        $mailFiles = [];
            
        self::validateFinanceTransaction($postingDate,$password);  //ENSURE THAT EVERYTHING IS SET BEFORE A TRANSACTION CAN ENTER THE JOURNAL
        
        $contact = $prefVendor;
        $contactType = Utility::VENDOR;
        $contactData = VendorCustomer::firstRow('id',$contact);
        $currCode = $contactData->currency->code;
        $currId = $contactData->currency_id;
        $employeeId = '';
        $defaultCurrObj = self::defaultCurrObj();
        $latestExRate = self::latestExchangeRate();
        if(empty($prefVendor)){
            $contact = '';
            $contactType = '';
            $currCode = Utility::currencyArrayItem('code');
            $currId = Utility::currencyArrayItem('id');
            $employeeId = $request->input('employee');
        }


        $uid = Utility::generateUID('journal_extention');

        $virtualObj = new \stdClass();
        $virtualObj->uid = $uid;
        $virtualObj->contact = $contact;
        $virtualObj->contactType = $contactType;
        $virtualObj->currId = $currId;
        $virtualObj->currCode = $currCode;
        $virtualObj->employeeId = $employeeId;
        $virtualObj->transactionType = self::expenses;
        $virtualObj->mailFiles = $mailFiles;
        $virtualObj->transactionClass = $transactionClass;
        $virtualObj->location = $location;
       $virtualObj->postDate = Utility::standardDate($postingDate);
        $virtualObj->reconcileId = '';
        $virtualObj->reconcileArr = [];
        $virtualObj->reconcileStatus = self::uncleared;
        $virtualObj->finYear = self::defaultFinYearObj()->id;      
        $virtualObj->cashStatus = Utility::STATUS_ACTIVE;
        
        //DEBIT ACCOUNTS
        $virtualObj->inventory = 0; //IF EXISTS, CANT BE ZERO, TO BE OBTAINED FROM EACH INVENTORY UNIT COST ITEM IN A LOOP
        $virtualObj->tax = $oneTimeTaxAmount;

         //DEBIT ACCOUNT TYPE
        $virtualObj->inventoryAccount = Utility::DEBIT_TABLE_ID;
        $virtualObj->taxAccount = Utility::DEBIT_TABLE_ID;

        //CREDIT ACCOUNTS
        $virtualObj->amountPaid = $grandTotal;
        $virtualObj->discountInventoryAccount = $oneTimeDiscount;   //SEE AUTO DISCOUNT METHOD FOR FURTHER EXPLANATION
        $virtualObj->discountReceived = $oneTimeDiscount;    //SEE AUTO DISCOUNT METHOD/FUNCTION FOR FURTHER EXPLANATION

        //CREDIT ACCOUNT TYPE
        $virtualObj->amountPaidAccount = Utility::CREDIT_TABLE_ID;
        $virtualObj->discountInventoryAccount = Utility::CREDIT_TABLE_ID;   ////SEE AUTO DISCOUNT METHOD FOR FURTHER EXPLANATION
        $virtualObj->discountReceivedAccount = Utility::CREDIT_TABLE_ID; //SEE AUTO DISCOUNT METHOD FOR FURTHER EXPLANATION


        //UPLOAD FILE IF IT EXISTS
        if($files != ''){
            foreach($files as $file){
                //return$file;
                $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                //array_push($cdn_images,$file_name);
                $attachment[] =  $file_name;
                $mailFiles[] = Utility::FILE_URL($file_name);

                $file->move(
                    Utility::FILE_URL(), $file_name
                );

            }
        }

         //SELECT FROM DB DEFAULT EXCHANGE RATE
         $defaultCurrSelect = Utility::firstRow2('currency','default_curr_status',Utility::STATUS_ACTIVE,'code',$virtualObj->currCode);
         $defaultCurrAmount = (!empty($defaultCurrSelect)) ? $defaultCurrSelect->default_currency : '';

         $getCurrRates = Utility::ratesBasedOnDateData($virtualObj->postDate);  //SELECT LATEST CURRENCY RATE IN CASE THERE IS NO DEFAULT FOR SELECTED CURRENCY
                 
         self::$defaultCurrAmount = $defaultCurrAmount;  //USED IN convertAmountToDate method for conversion to default exchange rate       
         self::$currDateRates = $getCurrRates->rates;   //USED IN convertAmountToDate method for conversion to exchange rate from web

        $extData = [
            'uid' => $uid,
            'file_no' => $fileNo,
            'sum_total' => $grandTotalForeignCurr,
            'trans_total' => $grandTotal,
            'balance' => $grandTotalForeignCurr,
            'balance_trans' => $grandTotal,
            'total_excl_tax' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$amountExclTax,$postingDate),
            'total_excl_tax_trans' => $amountExclTax,
            'balance_paid' => $grandTotalForeignCurr,
            'balance_paid_trans' => $grandTotal,
            'balance_status' => Utility::ZERO,
            'discount_total' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$oneTimeDiscount,$postingDate),
            'discount_trans' => $oneTimeDiscount,
            'discount_perct' => $oneTimePerct,
            'discount_type' => $discountType,                
            'tax_total' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$oneTimeTaxAmount,$postingDate),
            'tax_trans' => $oneTimeTaxAmount,
            'tax_perct' => $oneTimeTaxPerct,
            'tax_type' => $taxType,
            'message' => $message,
            'mails' => $emails,
            'mail_copy' => $mailCopy,
            'attachment' => json_encode($attachment,true),
            'default_curr' => Utility::currencyArrayItem('id'),
            'trans_curr' => $virtualObj->currId,
            'vendor_customer' => $virtualObj->contact,
            'employee_id' => $virtualObj->employeeId,
            'post_date' => Utility::standardDate($postingDate),
            'default_curr' => Utility::currencyArrayItem('id'),
            'post_date' => Utility::standardDate($request->input('posting_date')),
            'ex_rate' => $latestExRate->rates,
            'created_by' => Auth::user()->id,
            'fin_year' => $virtualObj->finYear,
            'journal_status' => $journalStatus,
            'transaction_format' => $transactionFormat,
            'transaction_type' => $virtualObj->transactionType,
            'contact_type' => $virtualObj->contactType,
            'class_id' => $transactionClass,
            'location_id' => $location,
            'billing_address' => $vendorAddress,
            'print_status' => $request->input('print_status'),
            'created_by' => Auth::user()->id,
            'status' => Utility::STATUS_ACTIVE,
            'cash_status' => $virtualObj->cashStatus
        ];

        //Log::info($extData['tax_total']); exit();
        $updateId = $request->input('edit_id');
         if(!empty($updateId)){
            $journalAccounts = AccountJournal::specialColumnsCustom2('extension_id',$updateId,'reconcile_status',self::reconciled,['chart_id','trans_total','post_date','item_id','reconcile_id']);
            
            //STORE RECONCILED ACCOUNTS AND SOME DETAILS FOR CHANGES OCCURRED DURING UPDATE            
            self::assembleTransDetails($virtualObj->reconcileArr,$journalAccounts);
        }

        self::autoTransaction($request,$extData,$virtualObj); //CREATE DETAILS TO JOURNAL
        
        if(!empty($virtualObj->reconcileArr)){
            //DETECT IF THERE IS A CHANGE IN FORMER TRANSACTION TO DETERMINE THE RECONCILE STATUS DURING EDITIING TRANSACTION
            self::detectTransChange($virtualObj,$paymentAccount,$virtualObj->amountPaid,$virtualObj->postDate);
        }
        //SAVE CASH AMOUNT TRANSACTION TO JOURNAL
        self::virtualTransaction($paymentAccount,$request,$virtualObj,$virtualObj->amountPaid,$virtualObj->amountPaidAccount);
      
        $defaultTransactionAccounts = self::defaultTransactionAccounts();

        if(!empty($virtualObj->reconcileArr)){
            //DETECT IF THERE IS A CHANGE IN FORMER TRANSACTION TO DETERMINE THE RECONCILE STATUS DURING EDITIING TRANSACTION
            self::detectTransChange($virtualObj,$defaultTransactionAccounts->default_purchase_tax,$virtualObj->tax,$virtualObj->postDate);
        }
        //SAVE TAX AMOUNT TRANSACTION TO JOURNAL IF THERE IS TAX
        if(!empty($oneTimeTaxAmount) && $oneTimeTaxAmount > 0){
            self::virtualTransaction($defaultTransactionAccounts->default_purchase_tax,$request,$virtualObj,$virtualObj->tax,$virtualObj->taxAccount);
        }
        
    }

    public static function bill($request){

        //SUM TOTAL FOR DEBIT/CREDIT SIDE SHOULD BE (SUM TOTAL)
        //DEBIT INVENTORY (SUM TOTAL)
        //CREDIT ACCOUNT PAYABLE
        
        //GENERAL VARIABLES
        $postingDate = $request->input('posting_date'); $prefVendor = $request->input('pref_vendor');

        $fileNo = $request->input('file_no');  $password = $request->input('password'); 
        $employeeId = $request->input('employee');  $transactionTerms = $request->input('terms');
        $transactionClass = $request->input('transaction_class');   $location = $request->input('location');
        $updateStatus = $request->input('update_status'); $convertStatus = $request->input('convert_status');
        $vendorAddress = $request->input('vendor_address');
        
         $grandTotalForeignCurr = $request->input('grand_total'); //THIS VARIABLE IS ACTUALLY THE FOREIGN CURRENCY SO DON'T BE CONFUSED ABOUT THE NAMES
        $grandTotal = $request->input('grand_total_vendor_curr');   // THIS IS ACTUALLY THE DEFAULT CURRENCY SO DON'T BE CONFUSED ABOUT THE NAMES
        $mailOption = $request->input('mail_option'); $emails = $request->input('emails'); $file = $request->input('file');
        $message = Utility::urlDecode($request->input('mail_message'));  $oneTimePerct = $request->input('one_time_perct');
        
        $oneTimeTax = (($updateStatus == 1 && $convertStatus == 1) || $updateStatus == 1) ? $request->input('one_time_tax_amount_edit') : $request->input('one_time_tax_amount');
        $oneTimeTaxAmount = (!empty($oneTimeTax)) ? $oneTimeTax : 0.00;

        $oneTimeDiscountAmount = (($updateStatus == 1 && $convertStatus == 1) || $updateStatus == 1) ? $request->input('one_time_discount_amount_edit') : $request->input('one_time_discount_amount');
         $taxType = $request->input('tax_type');
        $discountType = $request->input('discount_type'); $oneTimeTaxPerct = $request->input('one_time_tax_perct');
        $mailCopy = $request->input('mail_copy'); $journalStatus = $request->input('status');
        $oneTimeDiscount = (!empty($oneTimeDiscountAmount)) ? $oneTimeDiscountAmount : 0.00;
        $amountExclTax = $grandTotal - $oneTimeTaxAmount;    //INCLUDING DISCOUNT IF THERE IS ANY BUT EXCLUDING TAX

        $files = $request->file('file');
        $attachment = [];
        $mailFiles = [];
            
        self::validateFinanceTransaction($postingDate,$password);  //ENSURE THAT EVERYTHING IS SET BEFORE A TRANSACTION CAN ENTER THE JOURNAL
        
        $contact = $prefVendor;
        $contactType = Utility::VENDOR;
        $contactData = VendorCustomer::firstRow('id',$contact);
        $currCode = $contactData->currency->code;
        $currId = $contactData->currency_id;
        $employeeId = '';
        $defaultCurrObj = self::defaultCurrObj();
        $latestExRate = self::latestExchangeRate();
        if(empty($prefVendor)){
            $contact = '';
            $contactType = '';
            $currCode = Utility::currencyArrayItem('code');
            $currId = Utility::currencyArrayItem('id');
            $employeeId = $request->input('employee');
        }


        $uid = Utility::generateUID('journal_extention');

        $virtualObj = new \stdClass();
        $virtualObj->uid = $uid;
        $virtualObj->contact = $contact;
        $virtualObj->contactType = $contactType;
        $virtualObj->currId = $currId;
        $virtualObj->currCode = $currCode;
        $virtualObj->employeeId = $employeeId;
        $virtualObj->transactionType = self::bill;
        $virtualObj->mailFiles = $mailFiles;
        $virtualObj->transactionClass = $transactionClass;
        $virtualObj->location = $location;
       $virtualObj->postDate = Utility::standardDate($postingDate);
        $virtualObj->reconcileId = '';
        $virtualObj->reconcileArr = [];
        $virtualObj->reconcileStatus = self::uncleared;
        $virtualObj->finYear = self::defaultFinYearObj()->id;      
        $virtualObj->cashStatus = Utility::ZERO;
        
        //DEBIT ACCOUNTS
        $virtualObj->inventory = 0; //IF EXISTS, CANT BE ZERO, TO BE OBTAINED FROM EACH INVENTORY UNIT COST ITEM IN A LOOP
        $virtualObj->tax = $oneTimeTaxAmount;

         //DEBIT ACCOUNT TYPE
        $virtualObj->inventoryAccount = Utility::DEBIT_TABLE_ID;
        $virtualObj->taxAccount = Utility::DEBIT_TABLE_ID;

        //CREDIT ACCOUNTS
        $virtualObj->accountPayable = $grandTotal;

        //CREDIT ACCOUNT TYPE
        $virtualObj->accountPayableAccount = Utility::CREDIT_TABLE_ID;

        //UPLOAD FILE IF IT EXISTS
        if($files != ''){
            foreach($files as $file){
                //return$file;
                $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                //array_push($cdn_images,$file_name);
                $attachment[] =  $file_name;
                $mailFiles[] = Utility::FILE_URL($file_name);

                $file->move(
                    Utility::FILE_URL(), $file_name
                );

            }
        }

         //SELECT FROM DB DEFAULT EXCHANGE RATE
         $defaultCurrSelect = Utility::firstRow2('currency','default_curr_status',Utility::STATUS_ACTIVE,'code',$virtualObj->currCode);
         $defaultCurrAmount = (!empty($defaultCurrSelect)) ? $defaultCurrSelect->default_currency : '';

         $getCurrRates = Utility::ratesBasedOnDateData($virtualObj->postDate);  //SELECT LATEST CURRENCY RATE IN CASE THERE IS NO DEFAULT FOR SELECTED CURRENCY
                 
         self::$defaultCurrAmount = $defaultCurrAmount;  //USED IN convertAmountToDate method for conversion to default exchange rate       
         self::$currDateRates = $getCurrRates->rates;   //USED IN convertAmountToDate method for conversion to exchange rate from web

        $extData = [
            'uid' => $uid,
            'file_no' => $fileNo,
            'sum_total' => $grandTotalForeignCurr,
            'trans_total' => $grandTotal,
            'total_excl_tax' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$amountExclTax,$postingDate),
            'total_excl_tax_trans' => $amountExclTax,
            'balance_paid' => $grandTotalForeignCurr,
            'balance_paid_trans' => $grandTotal,
            'balance_status' => Utility::STATUS_ACTIVE,
            'discount_total' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$oneTimeDiscount,$postingDate),
            'discount_trans' => $oneTimeDiscount,
            'discount_perct' => $oneTimePerct,
            'discount_type' => $discountType,                
            'tax_total' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$oneTimeTaxAmount,$postingDate),
            'tax_trans' => $oneTimeTaxAmount,
            'tax_perct' => $oneTimeTaxPerct,
            'tax_type' => $taxType,
            'message' => $message,
            'mails' => $emails,
            'mail_copy' => $mailCopy,
            'attachment' => json_encode($attachment,true),
            'default_curr' => Utility::currencyArrayItem('id'),
            'trans_curr' => $virtualObj->currId,
            'vendor_customer' => $virtualObj->contact,
            'post_date' => Utility::standardDate($postingDate),
            'default_curr' => Utility::currencyArrayItem('id'),
            'post_date' => Utility::standardDate($request->input('posting_date')),
            'ex_rate' => $latestExRate->rates,
            'created_by' => Auth::user()->id,
            'fin_year' => $virtualObj->finYear,
            'journal_status' => $journalStatus,
            'transaction_type' => $virtualObj->transactionType,
            'terms' => $transactionTerms,
            'due_date' => Utility::termsToDueDate($transactionTerms,$virtualObj->postDate),
            'contact_type' => $virtualObj->contactType,
            'billing_address' => $vendorAddress,
            'class_id' => $transactionClass,
            'location_id' => $location,
            'print_status' => $request->input('print_status'),
            'created_by' => Auth::user()->id,
            'status' => Utility::STATUS_ACTIVE
        ];

        $updateId = $request->input('edit_id');

        if(empty($updateId)){
            $extData['balance_trans'] = $grandTotal;
            $extData['balance'] = $grandTotalForeignCurr;
            $extData['balance_status'] = Utility::STATUS_ACTIVE;
        }

         if(!empty($updateId)){
            $journalAccounts = AccountJournal::specialColumnsCustom2('extension_id',$updateId,'reconcile_status',self::reconciled,['chart_id','trans_total','post_date','item_id','reconcile_id']);
            
            //STORE RECONCILED ACCOUNTS AND SOME DETAILS FOR CHANGES OCCURRED DURING UPDATE            
            self::assembleTransDetails($virtualObj->reconcileArr,$journalAccounts);
        }

        self::autoTransaction($request,$extData,$virtualObj); //CREATE DETAILS TO JOURNAL
        
        $defaultTransactionAccounts = self::defaultTransactionAccounts();

        if(!empty($virtualObj->reconcileArr)){
            //DETECT IF THERE IS A CHANGE IN FORMER TRANSACTION TO DETERMINE THE RECONCILE STATUS DURING EDITIING TRANSACTION
            self::detectTransChange($virtualObj,$defaultTransactionAccounts->default_account_payable,$virtualObj->accountPayable,$virtualObj->postDate);
        }
        //SAVE ACCOUNT PAYABLE AMOUNT TRANSACTION TO JOURNAL
        self::virtualTransaction($defaultTransactionAccounts->default_account_payable,$request,$virtualObj,$virtualObj->accountPayable,$virtualObj->accountPayableAccount);
                

        if(!empty($virtualObj->reconcileArr)){
            //DETECT IF THERE IS A CHANGE IN FORMER TRANSACTION TO DETERMINE THE RECONCILE STATUS DURING EDITIING TRANSACTION
            self::detectTransChange($virtualObj,$defaultTransactionAccounts->default_purchase_tax,$virtualObj->tax,$virtualObj->postDate);
        }
        //SAVE TAX AMOUNT TRANSACTION TO JOURNAL IF THERE IS TAX
        if(!empty($oneTimeTaxAmount) && $oneTimeTaxAmount > 0){
            self::virtualTransaction($defaultTransactionAccounts->default_purchase_tax,$request,$virtualObj,$virtualObj->tax,$virtualObj->taxAccount);
        }

    } 
    
    public static function refundReceipt($request){

        //SUM TOTAL FOR DEBIT/CREDIT SIDE SHOULD BE (SUM TOTAL)
        //DEBIT INCOME ACCOUNT(SUM TOTAL), INVENTORY (ASSET ACCOUNT UNIT COST)
        //CREDIT CASH (AS RECEIVED FROM CUSTOMER),COG(EXPENSE ACCOUNT I.E UNIT COST)
        
        //GENERAL VARIABLES
        $postingDate = $request->input('posting_date'); $prefCustomer = $request->input('pref_customer');

        $fileNo = $request->input('file_no'); 
        $paymentAccount = $request->input('refund_from_account');    $password = $request->input('password'); 
        $employeeId = $request->input('employee');  $transactionFormat = $request->input('payment_method');
        $transactionClass = $request->input('transaction_class');  $location = $request->input('location');
        $updateStatus = $request->input('update_status');  $convertStatus = $request->input('convert_status');

         $grandTotalForeignCurr = $request->input('grand_total'); //THIS VARIABLE IS ACTUALLY THE FOREIGN CURRENCY SO DON'T BE CONFUSED ABOUT THE NAMES
        $grandTotal = $request->input('grand_total_vendor_curr');   // THIS IS ACTUALLY THE DEFAULT CURRENCY SO DON'T BE CONFUSED ABOUT THE NAMES
        $mailOption = $request->input('mail_option'); $emails = $request->input('emails'); $file = $request->input('file');
        $message = Utility::urlDecode($request->input('mail_message'));  $oneTimePerct = $request->input('one_time_perct');
        
        $oneTimeTax = (($updateStatus == 1 && $convertStatus == 1) || $updateStatus == 1) ? $request->input('one_time_tax_amount_edit') : $request->input('one_time_tax_amount');
        $oneTimeTaxAmount = (!empty($oneTimeTax)) ? $oneTimeTax : 0.00;

        $oneTimeDiscountAmount = (($updateStatus == 1 && $convertStatus == 1) || $updateStatus == 1) ? $request->input('one_time_discount_amount_edit') : $request->input('one_time_discount_amount');
         $taxType = $request->input('tax_type');
        $discountType = $request->input('discount_type'); $oneTimeTaxPerct = $request->input('one_time_tax_perct');
        $mailCopy = $request->input('mail_copy'); $journalStatus = Utility::CLOSED_ACCOUNT_STATUS;
        $oneTimeDiscount = (!empty($oneTimeDiscountAmount)) ? $oneTimeDiscountAmount : 0.00;
        $amountExclTax = $grandTotal - $oneTimeTaxAmount;    //INCLUDING DISCOUNT IF THERE IS ANY BUT EXCLUDING TAX

        $files = $request->file('file');
        $attachment = [];
        $mailFiles = [];
            
        self::validateFinanceTransaction($postingDate,$password);  //ENSURE THAT EVERYTHING IS SET BEFORE A TRANSACTION CAN ENTER THE JOURNAL
        
        $contact = $prefCustomer;
        $contactType = Utility::CUSTOMER;
        $contactData = VendorCustomer::firstRow('id',$contact);
        $currCode = $contactData->currency->code;
        $currId = $contactData->currency_id;
        $employeeId = '';
        $defaultCurrObj = self::defaultCurrObj();
        $latestExRate = self::latestExchangeRate();
        if(empty($prefCustomer)){
            $contact = '';
            $contactType = '';
            $currCode = Utility::currencyArrayItem('code');
            $currId = Utility::currencyArrayItem('id');
            $employeeId = $request->input('employee');
        }


        $uid = Utility::generateUID('journal_extention');

        $virtualObj = new \stdClass();
        $virtualObj->uid = $uid;
        $virtualObj->contact = $contact;
        $virtualObj->contactType = $contactType;
        $virtualObj->currId = $currId;
        $virtualObj->currCode = $currCode;
        $virtualObj->employeeId = $employeeId;
        $virtualObj->transactionType = self::refundReceipt;
        $virtualObj->mailFiles = $mailFiles;
        $virtualObj->transactionClass = $transactionClass;
        $virtualObj->location = $location;
       $virtualObj->postDate = Utility::standardDate($postingDate);
        $virtualObj->reconcileId = '';
        $virtualObj->reconcileArr = [];
        $virtualObj->reconcileStatus = self::uncleared;
        $virtualObj->finYear = self::defaultFinYearObj()->id;      
        $virtualObj->cashStatus = Utility::STATUS_ACTIVE;
        //DEBIT ACCOUNTS
        $virtualObj->income =  0; //CANT BE ZERO, TO BE OBTAINED FROM EACH RATE*QUANTITY(IF QUANTITY EXISTS) IN A LOOP
        $virtualObj->inventory = 0; //IF EXISTS, CANT BE ZERO, TO BE OBTAINED FROM EACH INVENTORY UNIT COST ITEM IN A LOOP
        $virtualObj->tax = $oneTimeTaxAmount;
        $virtualObj->discountInventoryAccount = $oneTimeDiscount;   //SEE AUTO DISCOUNT METHOD FOR FURTHER EXPLANATION

        //DEBIT ACCOUNT TYPE
        $virtualObj->incomeAccount = Utility::DEBIT_TABLE_ID;
        $virtualObj->inventoryAccount = Utility::DEBIT_TABLE_ID;
        $virtualObj->taxAccount = Utility::DEBIT_TABLE_ID;
        $virtualObj->discountInventoryAccount = Utility::DEBIT_TABLE_ID;   ////SEE AUTO DISCOUNT METHOD FOR FURTHER EXPLANATION


        //CREDIT ACCOUNTS
        $virtualObj->cashPaid = $grandTotal;
        $virtualObj->COG = 0; //CANT BE ZERO, TO BE OBTAINED FROM THE EACH INVENTORY IN A LOOP
        $virtualObj->discountAllowed = $oneTimeDiscount;    //SEE AUTO DISCOUNT METHOD/FUNCTION FOR FURTHER EXPLANATION

         //CREDIT ACCOUNT TYPE
         $virtualObj->cashPaidAccount = Utility::CREDIT_TABLE_ID;
         $virtualObj->COGAccount = Utility::CREDIT_TABLE_ID;
         $virtualObj->discountAllowedAccount = Utility::CREDIT_TABLE_ID; //SEE AUTO DISCOUNT METHOD FOR FURTHER EXPLANATION

        

        //UPLOAD FILE IF IT EXISTS
        if($files != ''){
            foreach($files as $file){
                //return$file;
                $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                //array_push($cdn_images,$file_name);
                $attachment[] =  $file_name;
                $mailFiles[] = Utility::FILE_URL($file_name);

                $file->move(
                    Utility::FILE_URL(), $file_name
                );

            }
        }

         //SELECT FROM DB DEFAULT EXCHANGE RATE
         $defaultCurrSelect = Utility::firstRow2('currency','default_curr_status',Utility::STATUS_ACTIVE,'code',$virtualObj->currCode);
         $defaultCurrAmount = (!empty($defaultCurrSelect)) ? $defaultCurrSelect->default_currency : '';

         $getCurrRates = Utility::ratesBasedOnDateData($virtualObj->postDate);  //SELECT LATEST CURRENCY RATE IN CASE THERE IS NO DEFAULT FOR SELECTED CURRENCY
                 
         self::$defaultCurrAmount = $defaultCurrAmount;  //USED IN convertAmountToDate method for conversion to default exchange rate       
         self::$currDateRates = $getCurrRates->rates;   //USED IN convertAmountToDate method for conversion to exchange rate from web


        $extData = [
            'uid' => $uid,
            'file_no' => $fileNo,
            'sum_total' => $grandTotalForeignCurr,
            'trans_total' => $grandTotal,
            'balance' => $grandTotalForeignCurr,
            'balance_trans' => $grandTotal,
            'total_excl_tax' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$amountExclTax,$postingDate),
            'total_excl_tax_trans' => $amountExclTax,
            'balance_paid' => $grandTotalForeignCurr,
            'balance_paid_trans' => $grandTotal,
            'balance_status' => Utility::ZERO,
            'discount_total' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$oneTimeDiscount,$postingDate),
            'discount_trans' => $oneTimeDiscount,
            'discount_perct' => $oneTimePerct,
            'discount_type' => $discountType,                
            'tax_total' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$oneTimeTaxAmount,$postingDate),
            'tax_trans' => $oneTimeTaxAmount,
            'tax_perct' => $oneTimeTaxPerct,
            'tax_type' => $taxType,
            'message' => $message,
            'mails' => $emails,
            'mail_copy' => $mailCopy,
            'attachment' => json_encode($attachment,true),
            'default_curr' => Utility::currencyArrayItem('id'),
            'trans_curr' => $virtualObj->currId,
            'vendor_customer' => $virtualObj->contact,
            'default_curr' => Utility::currencyArrayItem('id'),
            'post_date' => Utility::standardDate($postingDate),
            'ex_rate' => $latestExRate->rates,
            'created_by' => Auth::user()->id,
            'fin_year' => $virtualObj->finYear,
            'journal_status' => $journalStatus,
            'transaction_type' => $virtualObj->transactionType,
            'transaction_format' => $transactionFormat,
            'contact_type' => $virtualObj->contactType,
            'class_id' => $transactionClass,
            'location_id' => $location,
            'print_status' => $request->input('print_status'),
            'created_by' => Auth::user()->id,
            'status' => Utility::STATUS_ACTIVE,
            'cash_status' => $virtualObj->cashStatus
        ];
        
        $updateId = $request->input('edit_id');
         if(!empty($updateId)){
            $journalAccounts = AccountJournal::specialColumnsCustom2('extension_id',$updateId,'reconcile_status',self::reconciled,['chart_id','trans_total','post_date','item_id','reconcile_id']);
            
            //STORE RECONCILED ACCOUNTS AND SOME DETAILS FOR CHANGES OCCURRED DURING UPDATE            
            self::assembleTransDetails($virtualObj->reconcileArr,$journalAccounts);
        }

        self::autoTransaction($request,$extData,$virtualObj); //CREATE DETAILS TO JOURNAL
        
        if(!empty($virtualObj->reconcileArr)){
            //DETECT IF THERE IS A CHANGE IN FORMER TRANSACTION TO DETERMINE THE RECONCILE STATUS DURING EDITIING TRANSACTION
            self::detectTransChange($virtualObj,$paymentAccount,$virtualObj->cashPaid,$virtualObj->postDate);
        }
        //SAVE CASH AMOUNT TRANSACTION TO JOURNAL
        self::virtualTransaction($paymentAccount,$request,$virtualObj,$virtualObj->cashPaid,$virtualObj->cashPaidAccount);
        
        $defaultTransactionAccounts = self::defaultTransactionAccounts();

        if(!empty($virtualObj->reconcileArr)){
            //DETECT IF THERE IS A CHANGE IN FORMER TRANSACTION TO DETERMINE THE RECONCILE STATUS DURING EDITIING TRANSACTION
            self::detectTransChange($virtualObj,$defaultTransactionAccounts->default_sales_tax,$virtualObj->tax,$virtualObj->postDate);
        }
        //SAVE TAX AMOUNT TRANSACTION TO JOURNAL IF THERE IS TAX
        if(!empty($oneTimeTaxAmount) && $oneTimeTaxAmount > 0){
            self::virtualTransaction($defaultTransactionAccounts->default_sales_tax,$request,$virtualObj,$virtualObj->tax,$virtualObj->taxAccount);
        }

    }

    public static function creditMemo($request){

        //SUM TOTAL FOR DEBIT/CREDIT SIDE SHOULD BE (SUM TOTAL)        
        //DEBIT INCOME ACCOUNT(SUM TOTAL), INVENTORY (ASSET ACCOUNT UNIT COST)
        //CREDIT ACCOUNT RECEIVABLE (AS RECEIVED FROM CUSTOMER),COG(EXPENSE ACCOUNT I.E UNIT COST)

        //GENERAL VARIABLES
        $postingDate = $request->input('posting_date'); $prefCustomer = $request->input('pref_customer');

        $fileNo = $request->input('file_no');  $password = $request->input('password'); 
        $employeeId = $request->input('employee');
        $billingAddress = $request->input('billing_address');  $transactionClass = $request->input('transaction_class');
        $location = $request->input('location'); $updateStatus = $request->input('update_status');
        $convertStatus = $request->input('convert_status');

         $grandTotalForeignCurr = $request->input('grand_total'); //THIS VARIABLE IS ACTUALLY THE FOREIGN CURRENCY SO DON'T BE CONFUSED ABOUT THE NAMES
        $grandTotal = $request->input('grand_total_vendor_curr');   // THIS IS ACTUALLY THE DEFAULT CURRENCY SO DON'T BE CONFUSED ABOUT THE NAMES
        $mailOption = $request->input('mail_option'); $emails = $request->input('emails'); $file = $request->input('file');
        $message = Utility::urlDecode($request->input('mail_message'));  $oneTimePerct = $request->input('one_time_perct');
        
        $oneTimeTax = (($updateStatus == 1 && $convertStatus == 1) || $updateStatus == 1) ? $request->input('one_time_tax_amount_edit') : $request->input('one_time_tax_amount');
        $oneTimeTaxAmount = (!empty($oneTimeTax)) ? $oneTimeTax : 0.00;

        $oneTimeDiscountAmount = (($updateStatus == 1 && $convertStatus == 1) || $updateStatus == 1) ? $request->input('one_time_discount_amount_edit') : $request->input('one_time_discount_amount');
         $taxType = $request->input('tax_type');
        $discountType = $request->input('discount_type'); $oneTimeTaxPerct = $request->input('one_time_tax_perct');
        $mailCopy = $request->input('mail_copy'); $journalStatus = $request->input('status');
        $oneTimeDiscount = (!empty($oneTimeDiscountAmount)) ? $oneTimeDiscountAmount : 0.00;
        $amountExclTax = $grandTotal - $oneTimeTaxAmount;    //INCLUDING DISCOUNT IF THERE IS ANY BUT EXCLUDING TAX

        $files = $request->file('file');
        $attachment = [];
        $mailFiles = [];
            
        self::validateFinanceTransaction($postingDate,$password);  //ENSURE THAT EVERYTHING IS SET BEFORE A TRANSACTION CAN ENTER THE JOURNAL
        
        $contact = $prefCustomer;
        $contactType = Utility::CUSTOMER;
        $contactData = VendorCustomer::firstRow('id',$contact);
        $currCode = $contactData->currency->code;
        $currId = $contactData->currency_id;
        $employeeId = '';
        $latestExRate = self::latestExchangeRate();
        if(empty($prefCustomer)){
            $contact = '';
            $contactType = '';
            $currCode = Utility::currencyArrayItem('code');
            $currId = Utility::currencyArrayItem('id');
            $employeeId = $request->input('employee');
        }


        $uid = Utility::generateUID('journal_extention');

        $virtualObj = new \stdClass();
        $virtualObj->uid = $uid;
        $virtualObj->contact = $contact;
        $virtualObj->contactType = $contactType;
        $virtualObj->currId = $currId;
        $virtualObj->currCode = $currCode;
        $virtualObj->employeeId = $employeeId;
        $virtualObj->transactionType = self::creditMemo;
        $virtualObj->mailFiles = $mailFiles;
        $virtualObj->transactionClass = $transactionClass;
        $virtualObj->location = $location;
       $virtualObj->postDate = Utility::standardDate($postingDate);
        $virtualObj->reconcileId = '';
        $virtualObj->reconcileArr = [];
        $virtualObj->reconcileStatus = self::uncleared;
        $virtualObj->finYear = self::defaultFinYearObj()->id;      
        $virtualObj->cashStatus = Utility::ZERO;

        //DEBIT ACCOUNTS
        $virtualObj->income =  0; //CANT BE ZERO, TO BE OBTAINED FROM EACH RATE*QUANTITY(IF QUANTITY EXISTS) IN A LOOP
        $virtualObj->inventory = 0; //IF EXISTS, CANT BE ZERO, TO BE OBTAINED FROM EACH INVENTORY UNIT COST ITEM IN A LOOP
        $virtualObj->tax = $oneTimeTaxAmount;

        //DEBIT ACCOUNT TYPE
        $virtualObj->incomeAccount = Utility::DEBIT_TABLE_ID;
        $virtualObj->inventoryAccount = Utility::DEBIT_TABLE_ID;
        $virtualObj->taxAccount = Utility::DEBIT_TABLE_ID;
        
        //CREDIT ACCOUNTS
        $virtualObj->accountReceivable = $grandTotal;
        $virtualObj->COG = 0; //CANT BE ZERO, TO BE OBTAINED FROM THE EACH INVENTORY IN A LOOP
        $virtualObj->discountAllowed = $oneTimeDiscount;    //SEE AUTO DISCOUNT METHOD/FUNCTION FOR FURTHER EXPLANATION
        $virtualObj->discountInventoryAccount = $oneTimeDiscount;   //SEE AUTO DISCOUNT METHOD FOR FURTHER EXPLANATION

         //CREDIT ACCOUNT TYPE
         $virtualObj->accountReceivableAccount = Utility::CREDIT_TABLE_ID;
         $virtualObj->COGAccount = Utility::CREDIT_TABLE_ID;
         $virtualObj->discountAllowedAccount = Utility::CREDIT_TABLE_ID; //SEE AUTO DISCOUNT METHOD FOR FURTHER EXPLANATION
         $virtualObj->discountInventoryAccount = Utility::DEBIT_TABLE_ID;   ////SEE AUTO DISCOUNT METHOD FOR FURTHER EXPLANATION
    

        //UPLOAD FILE IF IT EXISTS
        if($files != ''){
            foreach($files as $file){
                //return$file;
                $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                //array_push($cdn_images,$file_name);
                $attachment[] =  $file_name;
                $mailFiles[] = Utility::FILE_URL($file_name);

                $file->move(
                    Utility::FILE_URL(), $file_name
                );

            }
        }

         //SELECT FROM DB DEFAULT EXCHANGE RATE
         $defaultCurrSelect = Utility::firstRow2('currency','default_curr_status',Utility::STATUS_ACTIVE,'code',$virtualObj->currCode);
         $defaultCurrAmount = (!empty($defaultCurrSelect)) ? $defaultCurrSelect->default_currency : '';

         $getCurrRates = Utility::ratesBasedOnDateData($virtualObj->postDate);  //SELECT LATEST CURRENCY RATE IN CASE THERE IS NO DEFAULT FOR SELECTED CURRENCY
                 
         self::$defaultCurrAmount = $defaultCurrAmount;  //USED IN convertAmountToDate method for conversion to default exchange rate       
         self::$currDateRates = $getCurrRates->rates;   //USED IN convertAmountToDate method for conversion to exchange rate from web

        $extData = [
            'uid' => $uid,
            'file_no' => $fileNo,
            'sum_total' => $grandTotalForeignCurr,
            'trans_total' => $grandTotal,
            'total_excl_tax' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$amountExclTax,$postingDate),
            'total_excl_tax_trans' => $amountExclTax,
            'discount_total' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$oneTimeDiscount,$postingDate),
            'discount_trans' => $oneTimeDiscount,
            'discount_perct' => $oneTimePerct,
            'discount_type' => $discountType,                
            'tax_total' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$oneTimeTaxAmount,$postingDate),
            'tax_trans' => $oneTimeTaxAmount,
            'tax_perct' => $oneTimeTaxPerct,
            'tax_type' => $taxType,
            'message' => $message,
            'mails' => $emails,
            'mail_copy' => $mailCopy,
            'billing_address' => $billingAddress,
            'attachment' => json_encode($attachment,true),
            'default_curr' => Utility::currencyArrayItem('id'),
            'trans_curr' => $virtualObj->currId,
            'vendor_customer' => $virtualObj->contact,
            'post_date' => Utility::standardDate($postingDate),
            'default_curr' => Utility::currencyArrayItem('id'),
            'post_date' => Utility::standardDate($postingDate),
            'ex_rate' => $latestExRate->rates,
            'created_by' => Auth::user()->id,
            'fin_year' => $virtualObj->finYear,
            'journal_status' => $journalStatus,
            'transaction_type' => $virtualObj->transactionType,
            'contact_type' => $virtualObj->contactType,
            'class_id' => $transactionClass,
            'location_id' => $location,
            'print_status' => $request->input('print_status'),
            'created_by' => Auth::user()->id,
            'status' => Utility::STATUS_ACTIVE
        ];

        $updateId = $request->input('edit_id');

        if(empty($updateId)){
            $extData['balance_trans'] = $grandTotal;
            $extData['balance'] = $grandTotalForeignCurr;
            $extData['balance_paid'] = 0.00;
            $extData['balance_paid_trans'] = 0.00;
            $extData['balance_status'] = Utility::STATUS_ACTIVE;
        }
        
         if(!empty($updateId)){
            $journalAccounts = AccountJournal::specialColumnsCustom2('extension_id',$updateId,'reconcile_status',self::reconciled,['chart_id','trans_total','post_date','item_id','reconcile_id']);
            
            //STORE RECONCILED ACCOUNTS AND SOME DETAILS FOR CHANGES OCCURRED DURING UPDATE            
            self::assembleTransDetails($virtualObj->reconcileArr,$journalAccounts);
        }

        self::autoTransaction($request,$extData,$virtualObj); //CREATE DETAILS TO JOURNAL
        
        $defaultTransactionAccounts = self::defaultTransactionAccounts();   //CONTAINS DEFAULT TAX,DISCOUNT AND INVENTORY ACCOUNTS
       
        if(!empty($virtualObj->reconcileArr)){
            //DETECT IF THERE IS A CHANGE IN FORMER TRANSACTION TO DETERMINE THE RECONCILE STATUS DURING EDITIING TRANSACTION
            self::detectTransChange($virtualObj,$defaultTransactionAccounts->default_account_receivable,$virtualObj->accountReceivable,$virtualObj->postDate);
        }
        //SAVE ACCOUNT RECEIVABLE TRANSACTION TO JOURNAL        
        self::virtualTransaction($defaultTransactionAccounts->default_account_receivable,$request,$virtualObj,$virtualObj->accountReceivable,$virtualObj->accountReceivableAccount);
                
        if(!empty($virtualObj->reconcileArr)){
            //DETECT IF THERE IS A CHANGE IN FORMER TRANSACTION TO DETERMINE THE RECONCILE STATUS DURING EDITIING TRANSACTION
            self::detectTransChange($virtualObj,$defaultTransactionAccounts->default_sales_tax,$virtualObj->tax,$virtualObj->postDate);
        }
        //SAVE TAX AMOUNT TRANSACTION TO JOURNAL IF THERE IS TAX
        if(!empty($oneTimeTaxAmount) && $oneTimeTaxAmount > 0){
            self::virtualTransaction($defaultTransactionAccounts->default_sales_tax,$request,$virtualObj,$virtualObj->tax,$virtualObj->taxAccount);
        }

    }
    

    public static function vendorCredit($request){

        //SUM TOTAL FOR DEBIT/CREDIT SIDE SHOULD BE (SUM TOTAL)
        //DEBIT ACCOUNT PAYABLE
        //CREDIT  INVENTORY (SUM TOTAL)

        //GENERAL VARIABLES
        $postingDate = $request->input('posting_date'); $prefVendor = $request->input('pref_vendor');

        $fileNo = $request->input('file_no');  $password = $request->input('password'); 
        $employeeId = $request->input('employee');  $transactionClass = $request->input('transaction_class');
        $location = $request->input('location'); $updateStatus = $request->input('update_status');
        $convertStatus = $request->input('convert_status'); $vendorAddress = $request->input('vendor_address');

         $grandTotalForeignCurr = $request->input('grand_total'); //THIS VARIABLE IS ACTUALLY THE FOREIGN CURRENCY SO DON'T BE CONFUSED ABOUT THE NAMES
        $grandTotal = $request->input('grand_total_vendor_curr');   // THIS IS ACTUALLY THE DEFAULT CURRENCY SO DON'T BE CONFUSED ABOUT THE NAMES
        $mailOption = $request->input('mail_option'); $emails = $request->input('emails'); $file = $request->input('file');
        $message = Utility::urlDecode($request->input('mail_message'));  $oneTimePerct = $request->input('one_time_perct');
        
        $oneTimeTax = (($updateStatus == 1 && $convertStatus == 1) || $updateStatus == 1) ? $request->input('one_time_tax_amount_edit') : $request->input('one_time_tax_amount');
        $oneTimeTaxAmount = (!empty($oneTimeTax)) ? $oneTimeTax : 0.00;

        $oneTimeDiscountAmount = (($updateStatus == 1 && $convertStatus == 1) || $updateStatus == 1) ? $request->input('one_time_discount_amount_edit') : $request->input('one_time_discount_amount');
         $taxType = $request->input('tax_type');
        $discountType = $request->input('discount_type'); $oneTimeTaxPerct = $request->input('one_time_tax_perct');
        $mailCopy = $request->input('mail_copy'); $journalStatus = $request->input('status');
        $oneTimeDiscount = (!empty($oneTimeDiscountAmount)) ? $oneTimeDiscountAmount : 0.00;
        $amountExclTax = $grandTotal - $oneTimeTaxAmount;    //INCLUDING DISCOUNT IF THERE IS ANY BUT EXCLUDING TAX

        $files = $request->file('file');
        $attachment = [];
        $mailFiles = [];
            
        self::validateFinanceTransaction($postingDate,$password);  //ENSURE THAT EVERYTHING IS SET BEFORE A TRANSACTION CAN ENTER THE JOURNAL
        
        $contact = $prefVendor;
        $contactType = Utility::VENDOR;
        $contactData = VendorCustomer::firstRow('id',$contact);
        $currCode = $contactData->currency->code;
        $currId = $contactData->currency_id;
        $employeeId = '';
        $defaultCurrObj = self::defaultCurrObj();
        $latestExRate = self::latestExchangeRate();
        if(empty($prefVendor)){
            $contact = '';
            $contactType = '';
            $currCode = Utility::currencyArrayItem('code');
            $currId = Utility::currencyArrayItem('id');
            $employeeId = $request->input('employee');
        }


        $uid = Utility::generateUID('journal_extention');

        $virtualObj = new \stdClass();
        $virtualObj->uid = $uid;
        $virtualObj->contact = $contact;
        $virtualObj->contactType = $contactType;
        $virtualObj->currId = $currId;
        $virtualObj->currCode = $currCode;
        $virtualObj->employeeId = $employeeId;
        $virtualObj->transactionType = self::vendorCredit;
        $virtualObj->mailFiles = $mailFiles;
        $virtualObj->transactionClass = $transactionClass;
        $virtualObj->location = $location;
       $virtualObj->postDate = Utility::standardDate($postingDate);
        $virtualObj->reconcileId = '';
        $virtualObj->reconcileArr = [];
        $virtualObj->reconcileStatus = self::uncleared;
        $virtualObj->finYear = self::defaultFinYearObj()->id;      
        $virtualObj->cashStatus = Utility::ZERO;
        
        //DEBIT ACCOUNTS
        $virtualObj->accountPayable = $grandTotal;

         //DEBIT ACCOUNT TYPE
        $virtualObj->accountPayableAccount = Utility::DEBIT_TABLE_ID;

        //CREDIT ACCOUNTS
        $virtualObj->inventory = 0; //IF EXISTS, CANT BE ZERO, TO BE OBTAINED FROM EACH INVENTORY UNIT COST ITEM IN A LOOP
        $virtualObj->discountInventoryAccount = $oneTimeDiscount;   //SEE AUTO DISCOUNT METHOD FOR FURTHER EXPLANATION
        $virtualObj->discountReceived = $oneTimeDiscount;    //SEE AUTO DISCOUNT METHOD/FUNCTION FOR FURTHER EXPLANATION
        $virtualObj->tax = $oneTimeTaxAmount;

        //CREDIT ACCOUNT TYPE
        $virtualObj->discountInventoryAccount = Utility::CREDIT_TABLE_ID;   //SEE AUTO DISCOUNT METHOD FOR FURTHER EXPLANATION
        $virtualObj->inventoryAccount = Utility::CREDIT_TABLE_ID;
        $virtualObj->discountReceivedAccount = Utility::CREDIT_TABLE_ID; //SEE AUTO DISCOUNT METHOD FOR FURTHER EXPLANATION
        $virtualObj->taxAccount = Utility::CREDIT_TABLE_ID;


        //UPLOAD FILE IF IT EXISTS
        if($files != ''){
            foreach($files as $file){
                //return$file;
                $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                //array_push($cdn_images,$file_name);
                $attachment[] =  $file_name;
                $mailFiles[] = Utility::FILE_URL($file_name);

                $file->move(
                    Utility::FILE_URL(), $file_name
                );

            }
        }

         //SELECT FROM DB DEFAULT EXCHANGE RATE
         $defaultCurrSelect = Utility::firstRow2('currency','default_curr_status',Utility::STATUS_ACTIVE,'code',$virtualObj->currCode);
         $defaultCurrAmount = (!empty($defaultCurrSelect)) ? $defaultCurrSelect->default_currency : '';

         $getCurrRates = Utility::ratesBasedOnDateData($virtualObj->postDate);  //SELECT LATEST CURRENCY RATE IN CASE THERE IS NO DEFAULT FOR SELECTED CURRENCY
                 
         self::$defaultCurrAmount = $defaultCurrAmount;  //USED IN convertAmountToDate method for conversion to default exchange rate       
         self::$currDateRates = $getCurrRates->rates;   //USED IN convertAmountToDate method for conversion to exchange rate from web


        $extData = [
            'uid' => $uid,
            'file_no' => $fileNo,
            'sum_total' => $grandTotalForeignCurr,
            'trans_total' => $grandTotal,
            'total_excl_tax' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$amountExclTax,$postingDate),
            'total_excl_tax_trans' => $amountExclTax,
            'discount_total' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$oneTimeDiscount,$postingDate),
            'discount_trans' => $oneTimeDiscount,
            'discount_perct' => $oneTimePerct,
            'discount_type' => $discountType,                
            'tax_total' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$oneTimeTaxAmount,$postingDate),
            'tax_trans' => $oneTimeTaxAmount,
            'tax_perct' => $oneTimeTaxPerct,
            'tax_type' => $taxType,
            'message' => $message,
            'mails' => $emails,
            'mail_copy' => $mailCopy,
            'attachment' => json_encode($attachment,true),
            'default_curr' => Utility::currencyArrayItem('id'),
            'trans_curr' => $virtualObj->currId,
            'vendor_customer' => $virtualObj->contact,
            'post_date' => Utility::standardDate($postingDate),
            'default_curr' => Utility::currencyArrayItem('id'),
            'post_date' => Utility::standardDate($postingDate),
            'ex_rate' => $latestExRate->rates,
            'created_by' => Auth::user()->id,
            'fin_year' => $virtualObj->finYear,
            'journal_status' => $journalStatus,
            'transaction_type' => $virtualObj->transactionType,
            'contact_type' => $virtualObj->contactType,
            'class_id' => $transactionClass,
            'location_id' => $location,
            'billing_address' => $vendorAddress,
            'print_status' => $request->input('print_status'),
            'created_by' => Auth::user()->id,
            'status' => Utility::STATUS_ACTIVE
        ];

        $updateId = $request->input('edit_id');

        if(empty($updateId)){
            $extData['balance_trans'] = $grandTotal;
            $extData['balance'] = $grandTotalForeignCurr;
            $extData['balance_paid'] = 0.00;
            $extData['balance_paid_trans'] = 0.00;
            $extData['balance_status'] = Utility::STATUS_ACTIVE;
        }

         if(!empty($updateId)){
            $journalAccounts = AccountJournal::specialColumnsCustom2('extension_id',$updateId,'reconcile_status',self::reconciled,['chart_id','trans_total','post_date','item_id','reconcile_id']);
            
            //STORE RECONCILED ACCOUNTS AND SOME DETAILS FOR CHANGES OCCURRED DURING UPDATE            
            self::assembleTransDetails($virtualObj->reconcileArr,$journalAccounts);
        }

        self::autoTransaction($request,$extData,$virtualObj); //CREATE DETAILS TO JOURNAL
        
        $defaultTransactionAccounts = self::defaultTransactionAccounts();   //CONTAINS DEFAULT TAX,DISCOUNT AND INVENTORY ACCOUNTS
       
        if(!empty($virtualObj->reconcileArr)){
            //DETECT IF THERE IS A CHANGE IN FORMER TRANSACTION TO DETERMINE THE RECONCILE STATUS DURING EDITIING TRANSACTION
            self::detectTransChange($virtualObj,$defaultTransactionAccounts->default_account_payable,$virtualObj->accountPayable,$virtualObj->postDate);
        }
        //SAVE CASH AMOUNT TRANSACTION TO JOURNAL
        self::virtualTransaction($defaultTransactionAccounts->default_account_payable,$request,$virtualObj,$virtualObj->accountPayable,$virtualObj->accountPayableAccount);
               
        if(!empty($virtualObj->reconcileArr)){
            //DETECT IF THERE IS A CHANGE IN FORMER TRANSACTION TO DETERMINE THE RECONCILE STATUS DURING EDITIING TRANSACTION
            self::detectTransChange($virtualObj,$defaultTransactionAccounts->default_purchase_tax,$virtualObj->tax,$virtualObj->postDate);
        }
        //SAVE TAX AMOUNT TRANSACTION TO JOURNAL IF THERE IS TAX
        if(!empty($oneTimeTaxAmount) && $oneTimeTaxAmount > 0){
            self::virtualTransaction($defaultTransactionAccounts->default_purchase_tax,$request,$virtualObj,$virtualObj->tax,$virtualObj->taxAccount);
        }

    }

    //NOT IN USE FOR NOW IN THE APPLICATION
    public static function cashBillPayment($request){

        //SUM TOTAL FOR DEBIT/CREDIT SIDE SHOULD BE (SUM TOTAL)
        //DEBIT INVENTORY (SUM TOTAL )
        //CREDIT CASH (AS PAID TO VENDOR)

        //GENERAL VARIABLES
        $postingDate = $request->input('posting_date'); $prefVendor = $request->input('pref_vendor');

        $fileNo = $request->input('file_no');  $amountPaid = $request->input('amount_paid');
        $paymentAccount = $request->input('payment_account');    $password = $request->input('password'); 
        $employeeId = $request->input('employee');  $transactionFormat = $request->input('transaction_method');
        $transactionClass = $request->input('transaction_class');   $location = $request->input('location');
        $updateStatus = $request->input('update_status');  $convertStatus = $request->input('convert_status');

         $grandTotalForeignCurr = $request->input('grand_total'); //THIS VARIABLE IS ACTUALLY THE FOREIGN CURRENCY SO DON'T BE CONFUSED ABOUT THE NAMES
        $grandTotal = $request->input('grand_total_vendor_curr');   // THIS IS ACTUALLY THE DEFAULT CURRENCY SO DON'T BE CONFUSED ABOUT THE NAMES
        $mailOption = $request->input('mail_option'); $emails = $request->input('emails'); $file = $request->input('file');
        $message = Utility::urlDecode($request->input('mail_message'));  $oneTimePerct = $request->input('one_time_perct');
        
        $oneTimeTax = (($updateStatus == 1 && $convertStatus == 1) || $updateStatus == 1) ? $request->input('one_time_tax_amount_edit') : $request->input('one_time_tax_amount');
        $oneTimeTaxAmount = (!empty($oneTimeTax)) ? $oneTimeTax : 0.00;

        $oneTimeDiscountAmount = (($updateStatus == 1 && $convertStatus == 1) || $updateStatus == 1) ? $request->input('one_time_discount_amount_edit') : $request->input('one_time_discount_amount');
         $taxType = $request->input('tax_type');
        $discountType = $request->input('discount_type'); $oneTimeTaxPerct = $request->input('one_time_tax_perct');
        $mailCopy = $request->input('mail_copy'); $journalStatus = Utility::CLOSED_ACCOUNT_STATUS;
        $oneTimeDiscount = (!empty($oneTimeDiscountAmount)) ? $oneTimeDiscountAmount : 0.00;
        $amountExclTax = $grandTotal - $oneTimeTaxAmount;    //INCLUDING DISCOUNT IF THERE IS ANY BUT EXCLUDING TAX

        $files = $request->file('file');
        $attachment = [];
        $mailFiles = [];
            
        self::validateFinanceTransaction($postingDate,$password);  //ENSURE THAT EVERYTHING IS SET BEFORE A TRANSACTION CAN ENTER THE JOURNAL
        

        $contact = $prefVendor;
        $contactType = Utility::VENDOR;
        $contactData = VendorCustomer::firstRow('id',$contact);
        $currCode = $contactData->currency->code;
        $currId = $contactData->currency_id;
        $employeeId = '';
        $defaultCurrObj = self::defaultCurrObj();
        $latestExRate = self::latestExchangeRate();
        if(empty($prefCustomer)){
            $contact = '';
            $contactType = '';
            $currCode = Utility::currencyArrayItem('code');
            $currId = Utility::currencyArrayItem('id');
            $employeeId = $request->input('employee');
        }


        $uid = Utility::generateUID('journal_extention');

        $virtualObj = new \stdClass();
        $virtualObj->uid = $uid;
        $virtualObj->contact = $contact;
        $virtualObj->contactType = $contactType;
        $virtualObj->currId = $currId;
        $virtualObj->currCode = $currCode;
        $virtualObj->employeeId = $employeeId;
        $virtualObj->transactionType = self::cashBillPayment;
        $virtualObj->mailFiles = $mailFiles;
        $virtualObj->transactionClass = $transactionClass;
        $virtualObj->location = $location;
       $virtualObj->postDate = Utility::standardDate($postingDate);
        $virtualObj->reconcileId = '';
        $virtualObj->reconcileArr = [];
        $virtualObj->reconcileStatus = self::uncleared;
        $virtualObj->finYear = self::defaultFinYearObj()->id;      
        $virtualObj->cashStatus = Utility::STATUS_ACTIVE;
        
        //DEBIT ACCOUNTS
        $virtualObj->inventory = 0; //IF EXISTS, CANT BE ZERO, TO BE OBTAINED FROM EACH INVENTORY UNIT COST ITEM IN A LOOP
        $virtualObj->tax = $oneTimeTaxAmount;

         //DEBIT ACCOUNT TYPE
        $virtualObj->inventoryAccount = Utility::DEBIT_TABLE_ID;
        $virtualObj->taxAccount = Utility::DEBIT_TABLE_ID;

        //CREDIT ACCOUNTS
        $virtualObj->amountPaid = $grandTotal;
        $virtualObj->discountInventoryAccount = $oneTimeDiscount;   //SEE AUTO DISCOUNT METHOD FOR FURTHER EXPLANATION
        $virtualObj->discountReceived = $oneTimeDiscount;    //SEE AUTO DISCOUNT METHOD/FUNCTION FOR FURTHER EXPLANATION

        //CREDIT ACCOUNT TYPE
        $virtualObj->amountPaidAccount = Utility::CREDIT_TABLE_ID;
        $virtualObj->discountReceivedAccount = Utility::CREDIT_TABLE_ID; //SEE AUTO DISCOUNT METHOD FOR FURTHER EXPLANATION
        $virtualObj->discountInventoryAccount = Utility::CREDIT_TABLE_ID;   ////SEE AUTO DISCOUNT METHOD FOR FURTHER EXPLANATION


        //UPLOAD FILE IF IT EXISTS
        if($files != ''){
            foreach($files as $file){
                //return$file;
                $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                //array_push($cdn_images,$file_name);
                $attachment[] =  $file_name;
                $mailFiles[] = Utility::FILE_URL($file_name);

                $file->move(
                    Utility::FILE_URL(), $file_name
                );

            }
        }

         //SELECT FROM DB DEFAULT EXCHANGE RATE
         $defaultCurrSelect = Utility::firstRow2('currency','default_curr_status',Utility::STATUS_ACTIVE,'code',$virtualObj->currCode);
         $defaultCurrAmount = (!empty($defaultCurrSelect)) ? $defaultCurrSelect->default_currency : '';

         $getCurrRates = Utility::ratesBasedOnDateData($virtualObj->postDate);  //SELECT LATEST CURRENCY RATE IN CASE THERE IS NO DEFAULT FOR SELECTED CURRENCY
                 
         self::$defaultCurrAmount = $defaultCurrAmount;  //USED IN convertAmountToDate method for conversion to default exchange rate       
         self::$currDateRates = $getCurrRates->rates;   //USED IN convertAmountToDate method for conversion to exchange rate from web

        $extData = [
            'uid' => $uid,
            'file_no' => $fileNo,
            'sum_total' => $grandTotalForeignCurr,
            'trans_total' => $grandTotal,
            'balance' => $grandTotalForeignCurr,
            'balance_trans' => $grandTotal,
            'total_excl_tax' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$amountExclTax,$postingDate),
            'total_excl_tax_trans' => $amountExclTax,
            'balance_paid' => $grandTotalForeignCurr,
            'balance_paid_trans' => $grandTotal,
            'balance_status' => Utility::ZERO,
            'discount_total' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$oneTimeDiscount,$postingDate),
            'discount_trans' => $oneTimeDiscount,
            'discount_perct' => $oneTimePerct,
            'discount_type' => $discountType,                
            'tax_total' => self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$oneTimeTaxAmount,$postingDate),
            'tax_trans' => $oneTimeTaxAmount,
            'tax_perct' => $oneTimeTaxPerct,
            'tax_type' => $taxType,
            'message' => $message,
            'mails' => $emails,
            'mail_copy' => $mailCopy,
            'attachment' => json_encode($attachment,true),
            'default_curr' => Utility::currencyArrayItem('id'),
            'trans_curr' => $virtualObj->currId,
            'vendor_customer' => $virtualObj->contact,
            'post_date' => Utility::standardDate($postingDate),
            'default_curr' => Utility::currencyArrayItem('id'),
            'post_date' => Utility::standardDate($postingDate),
            'ex_rate' => $latestExRate->rates,
            'created_by' => Auth::user()->id,
            'fin_year' => $virtualObj->finYear,
            'journal_status' => $journalStatus,
            'transaction_format' => $transactionFormat,
            'transaction_type' => $virtualObj->transactionType,
            'contact_type' => $virtualObj->contactType,
            'billingAddress' => Utility::companyInfo()->address,
            'class_id' => $transactionClass,
            'location_id' => $location,
            'print_status' => $request->input('print_status'),
            'created_by' => Auth::user()->id,
            'status' => Utility::STATUS_ACTIVE
        ];

        $updateId = $request->input('edit_id');
         if(!empty($updateId)){
            $journalAccounts = AccountJournal::specialColumnsCustom2('extension_id',$updateId,'reconcile_status',self::reconciled,['chart_id','trans_total','post_date','item_id','reconcile_id']);
            
            //STORE RECONCILED ACCOUNTS AND SOME DETAILS FOR CHANGES OCCURRED DURING UPDATE            
            self::assembleTransDetails($virtualObj->reconcileArr,$journalAccounts);
        }

        self::autoTransaction($request,$extData,$virtualObj); //CREATE DETAILS TO JOURNAL
        
        if(!empty($virtualObj->reconcileArr)){
            //DETECT IF THERE IS A CHANGE IN FORMER TRANSACTION TO DETERMINE THE RECONCILE STATUS DURING EDITIING TRANSACTION
            self::detectTransChange($virtualObj,$paymentAccount,$virtualObj->amountPaid,$virtualObj->postDate);
        }
        //SAVE CASH AMOUNT TRANSACTION TO JOURNAL
        self::virtualTransaction($paymentAccount,$request,$virtualObj,$virtualObj->amountPaid,$virtualObj->amountPaidAccount);
        
        $defaultTransactionAccounts = self::defaultTransactionAccounts();

        if(!empty($virtualObj->reconcileArr)){
            //DETECT IF THERE IS A CHANGE IN FORMER TRANSACTION TO DETERMINE THE RECONCILE STATUS DURING EDITIING TRANSACTION
            self::detectTransChange($virtualObj,$defaultTransactionAccounts->default_purchase_tax,$virtualObj->tax,$virtualObj->postDate);
        }
        //SAVE TAX AMOUNT TRANSACTION TO JOURNAL IF THERE IS TAX
        if(!empty($oneTimeTaxAmount) && $oneTimeTaxAmount > 0){
            self::virtualTransaction($defaultTransactionAccounts->default_purchase_tax,$request,$virtualObj,$virtualObj->tax,$virtualObj->taxAccount);
        }

    }

    //DIRECT JOURNAL ENTRY TRANSACTION TO BALANCE DEBIT OR CREDIT SIDE OF JOURNAL ACCOUNT
    public static function journalEntry($request){

        $payerOrPayee = $request->input('payer_receiver');;
        $contactType = '';
        $extData = [];
        
        $defaultCurr = self::defaultCurrObj();
        $latestExRate = self::latestExchangeRate();
        $finYear = self::defaultFinYearObj(); 
        $updateStatus = $request->input('update_status');
        
        $currId = $defaultCurr->id; //DEFAULT CURRENCY ID
        $currCode = $defaultCurr->code; //DEFUALT CURRENCY CODE

        $postingDate = Utility::standardDate($request->input('posting_date'));
        $cashStatus = $request->input('cash_status');
        $journalStatus = Utility::CLOSED_ACCOUNT_STATUS;
        $reconcileStatus = self::uncleared;

        $fileNo = $request->input('file_no');  
        $creditAccount = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('credit_account_hidden_edit')) :  Utility::jsonUrlDecode($request->input('credit_account_hidden'));  //AMOUNT TO BE CREDITED
        $checkmateCredit = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('checkmate_credit_edit')) :  Utility::jsonUrlDecode($request->input('checkmate_credit'));  //AMOUNT TO BE CREDITED
        $debitAccount = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('debit_account_hidden_edit')) :  Utility::jsonUrlDecode($request->input('debit_account_hidden'));  //AMOUNT TO BE DEBITED  
        $checkmateDebit = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('checkmate_debit_edit')) :  Utility::jsonUrlDecode($request->input('checkmate_debit'));  //AMOUNT TO BE DEBITED  
        $password = $request->input('password'); 
        $debitCredit = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('debit_credit_edit')) :  Utility::jsonUrlDecode($request->input('debit_credit'));  //DEBIT OR CREDIT TYPE
        $accDesc = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('acc_desc_edit')) :  Utility::jsonUrlDecode($request->input('acc_desc')); 
        $accClass = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('acc_class_edit')) :  Utility::jsonUrlDecode($request->input('acc_class'));
        $transactionClass = $request->input('transaction_class'); $transactionType = self::journalEntry;
        $location = $request->input('location');    $extData = [];
        
        self::validateFinanceTransaction($postingDate,$password);  //ENSURE THAT EVERYTHING IS SET BEFORE A TRANSACTION CAN ENTER THE JOURNAL
                
        if(array_sum($checkmateDebit) != array_sum($checkmateCredit)){ //ENSURE THAT DEBIT TOTAL IS EQUAL TO CREDIT TOTAL
                exit(
                    json_encode([
                    'message2' => 'Please ensure that Debit side is equal to Credit side',
                    'message' => 'warning'
                ])
            );
        }
       
        $customer = $request->input('pref_customer'); $vendor = $request->input('pref_vendor');
        $employee = $request->input('employee');
        $amountTrans = Utility::roundNum((array_sum($debitAccount) + array_sum($creditAccount))/2); 
        $uid = ($updateStatus == 1) ? $request->input('edit_uid') : Utility::generateUid('journal_extention');     
        
        if($payerOrPayee == Utility::VENDOR || $payerOrPayee == Utility::CUSTOMER){

            if(!empty($customer) || !empty($vendor)){   //DO THIS IF USER SELECTED CUSTOMER OR VENDOR
            $vendorCustomer = ($payerOrPayee == Utility::CUSTOMER) ? $customer : $vendor;
            $contactType = (!empty($customer)) ? Utility::CUSTOMER : Utility::VENDOR;
            $extData['vendor_customer'] = $vendorCustomer;
            $extData['contact_type'] = $contactType;

            $contactData = VendorCustomer::firstRow('id',$vendorCustomer);
            $currId = $contactData->currency_id;
            $currCode = $contactData->currency->code;
            }
            
        }

        if($payerOrPayee == Utility::EMPLOYEE || empty($payerOrPayee) ){
            if(!empty($employee)){
            $extData['employee_id'] = $request->input('employee');
            }
            $currId = Utility::currencyArrayItem('id');
            $currCode = Utility::currencyArrayItem('code');
        }

        $files = $request->file('file');
        $attachment = [];
        $mailFiles = [];     
        
        //UPLOAD FILE IF IT EXISTS
        if($files != ''){
            foreach($files as $file){
                //return$file;
                $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                //array_push($cdn_images,$file_name);
                $attachment[] =  $file_name;
                $mailFiles[] = Utility::FILE_URL($file_name);

                $file->move(
                    Utility::FILE_URL(), $file_name
                );

            }
        }
        
        $extData['uid'] = $uid;
        $extData['file_no'] = $fileNo;
        $extData['sum_total'] = Utility::convertAmountToDate($currCode,Utility::currencyArrayItem('code'),$amountTrans,$postingDate);
        $extData['trans_total'] = $amountTrans;           
        $extData['balance_status'] = Utility::ZERO;        
        $extData['attachment'] = json_encode($attachment,true);
        $extData['default_curr'] = Utility::currencyArrayItem('id');
        $extData['trans_curr'] = $currId;
        $extData['post_date'] = Utility::standardDate($postingDate);
        $extData['ex_rate'] = $latestExRate->rates;
        $extData['fin_year'] = $finYear->id;
        $extData['journal_status'] = $journalStatus;
        $extData['transaction_type'] = self::journalEntry;
        $extData['class_id'] = $transactionClass;
        $extData['location_id'] = $location;
        $extData['print_status'] = $request->input('print_status');
        $extData['status'] = Utility::STATUS_ACTIVE;
        $extData['cash_status'] = $cashStatus;
                        
        $journalId = '';
        $countExAcc = $request->input('count_ext_acc');
        
         //RUN JOURNAL ENTRY FOR EXISTING DEBIT AND CREDIT SIDE FOR ACCOUNTS
         if($updateStatus == 1){

            $virtualObj = new \stdClass();
            $virtualObj->reconcileArr = [];
            $virtualObj->postDate = $postingDate;
            $virtualObj->reconcileStatus = $reconcileStatus;
            $virtualObj->reconcileId = '';
            $updateId = $request->input('edit_id');
            if(!empty($updateId)){
                $journalAccounts = AccountJournal::specialColumnsCustom2('extension_id',$updateId,'reconcile_status',self::reconciled,['chart_id','trans_total','post_date','item_id','reconcile_id']);
                
                //STORE RECONCILED ACCOUNTS AND SOME DETAILS FOR CHANGES OCCURRED DURING UPDATE            
                self::assembleTransDetails($virtualObj->reconcileArr,$journalAccounts);
            }
                        
            //REMOVE EXISTING ACCOUNT JOURNAL DEBI/CREDIT FROM AccountJournal DB TABLE
            $journalItems = AccountJournal::specialColumns('extension_id',$request->input('edit_id')); //SELECT JOURNAL ITEMS FOR ID TO BE EDITED
            foreach($journalItems as $item){
                $accountType = ($item->debit_credit == Utility::CREDIT_TABLE_ID) ? Utility::DEBIT_TABLE_ID : Utility::CREDIT_TABLE_ID;
               Utility::updateAccountBalance($item->chart_id,$item->trans_total,$accountType); //UPDATE ACCOUNT BALANCE TO INITIAL BALANCE                
                AccountJournal::destroy($item->id);
            }    
            
            if($countExAcc >0){

                for($i=1; $i<= $countExAcc; $i++){
                        $accDbData = [];
                    $chartDetail = AccountChart::firstRow('id',$request->input('acc_class'.$i));
                    
                        if(!empty($chartDetail)){   //IF ACCOUNT CHART ID IS NOT EMPTY CONTINUE                                            

                            $accDbData['account_id'] = $request->input('acc_class'.$i);
                            $accDbData['acct_cat_id'] = $chartDetail->acct_cat_id;
                            $accDbData['detail_id'] =  $chartDetail->detail_id;
                            $accDbData['chart_id'] =  $chartDetail->id;
                            $accDbData['extension_id'] = $request->input('edit_id');
                            $accDbData['fin_year'] = $finYear->id;
                            $accDbData['uid'] = $uid;
                            $accDbData['class_id'] = $request->input('transaction_class');
                            $accDbData['location_id'] = $request->input('location');
                            $accDbData['main_trans'] = Utility::STATUS_ACTIVE;
                            $accDbData['trans_desc'] = $request->input('trans_desc'.$i);

                            if($payerOrPayee == Utility::VENDOR || $payerOrPayee == Utility::CUSTOMER){

                                if(!empty($customer) || !empty($vendor)){   //DO THIS IF USER SELECTED CUSTOMER OR VENDOR
                                $vendorCustomer = ($payerOrPayee == Utility::CUSTOMER) ? $customer : $vendor;
                                $contactType = (!empty($customer)) ? Utility::CUSTOMER : Utility::VENDOR;
                                $accDbData['vendor_customer'] = $vendorCustomer;
                                $accDbData['contact_type'] = $contactType;

                                }

                            }
                            if($payerOrPayee == Utility::EMPLOYEE && !empty($employee)){
                                
                                $accDbData['employee_id'] = $request->input('employee');
                            }

                            if($request->input('debit_credit'.$i) == Utility::DEBIT_TABLE_ID){

                                $accDbData['debit_credit'] = Utility::DEBIT_TABLE_ID;
                                $accDbData['unit_cost_trans'] = $request->input('debit_account_hidden'.$i);
                                $accDbData['unit_cost'] = Utility::convertAmountToDate($currCode,Utility::currencyArrayItem('code'),$request->input('debit_account'.$i),$postingDate);
                                $accDbData['trans_total'] = $request->input('debit_account_hidden'.$i);    //THE AMOUNT USED FOR JOURNAL ENTRY
                                $accDbData['total'] = Utility::convertAmountToDate($currCode,Utility::currencyArrayItem('code'),$request->input('debit_account'.$i),$postingDate);  //THE AMOUNT USED FOR JOURNAL ENTRY
                                
                            }else{

                                $accDbData['debit_credit'] = Utility::CREDIT_TABLE_ID;
                                $accDbData['unit_cost_trans'] = $request->input('credit_account_hidden'.$i);
                                $accDbData['unit_cost'] = Utility::convertAmountToDate($currCode,Utility::currencyArrayItem('code'),$request->input('credit_account'.$i),$postingDate);
                                $accDbData['trans_total'] = $request->input('credit_account_hidden'.$i);    //THE AMOUNT USED FOR JOURNAL ENTRY
                                $accDbData['total'] = Utility::convertAmountToDate($currCode,Utility::currencyArrayItem('code'),$request->input('credit_account'.$i),$postingDate);  //THE AMOUNT USED FOR JOURNAL ENTRY
                                
                            }

                        
                        
                            $accDbData['transaction_type'] = $transactionType;
                            $accDbData['post_date'] = $postingDate;
                            $accDbData['trans_curr'] = $currId;
                            $accDbData['default_curr'] = Utility::currencyArrayItem('id');
                            $accDbData['status'] = Utility::STATUS_ACTIVE;
                            $accDbData['cash_status'] = $cashStatus;
                            $accDbData['created_by'] = Auth::user()->id;

                            if(!empty($reconcileArr)){
                                //DETECT IF THERE IS A CHANGE IN FORMER TRANSACTION TO DETERMINE THE RECONCILE STATUS DURING EDITIING TRANSACTION
                                self::detectTransChange($virtualObj,$chartDetail->id,$accDbData['trans_total'] ,$postingDate);
                            }
                            
                            $accDbData['reconcile_status'] = $virtualObj->reconcileStatus;
                            $accDbData['reconcile_id'] = $virtualObj->reconcileId;

                            if($request->input('debit_credit'.$i) == Utility::DEBIT_TABLE_ID){
                                AccountJournal::create($accDbData);
                                Utility::updateAccountBalance($chartDetail->id,$request->input('debit_account_hidden'.$i),Utility::DEBIT_TABLE_ID); //UPDATE ACCOUNT BALANCE
                            }else{
                                AccountJournal::create($accDbData);
                                Utility::updateAccountBalance($chartDetail->id,$request->input('credit_account_hidden'.$i),Utility::CREDIT_TABLE_ID); //UPDATE ACCOUNT BALANCE
                            }
                    
                        }

                }
            }
            
            $extData['uid'] = $request->input('edit_uid');
            $extData['updated_by'] = Auth::user()->id;
            $mainJournal = JournalExtension::defaultUpdate('id', $request->input('edit_id'), $extData);
            $journalId = $request->input('edit_id');

        }else{
            $extData['credated_by'] = Auth::user()->id;
            $mainJournal = JournalExtension::create($extData);
            $journalId = $mainJournal->id;
        }
        
        //RUN NEW JOURNAL ENTRY FOR DEBIT AND CREDIT SIDE FOR ACCOUNTS
        if(!empty($accClass)){
            if(count($accClass) == count($debitCredit) >0){
                $accDbData = [];
                for($i=0;$i<count($accClass);$i++){

                    $chartDetail = AccountChart::firstRow('id',Utility::checkEmptyArrayItem($accClass,$i,0));

                        if(!empty($chartDetail)){   //IF ACCOUNT CHART ID IS NOT EMPTY CONTINUE                                            

                        $accDbData['account_id'] = Utility::checkEmptyArrayItem($accClass,$i,0);
                        $accDbData['acct_cat_id'] = $chartDetail->acct_cat_id;
                        $accDbData['detail_id'] =  $chartDetail->detail_id;
                        $accDbData['chart_id'] =  $chartDetail->id;
                        $accDbData['extension_id'] = $journalId;
                        $accDbData['fin_year'] = $finYear->id;
                        $accDbData['uid'] = $uid;
                        $accDbData['class_id'] = $request->input('transaction_class');
                        $accDbData['location_id'] = $request->input('location');
                        $accDbData['main_trans'] = Utility::STATUS_ACTIVE;
                        $accDbData['trans_desc'] = Utility::checkEmptyArrayItem($accDesc,$i,'');
                        $reconcileStatus = self::uncleared; //ENSURE STATUS IS UNCLEARED CREATING NEW ENTRY
                        $accDbData['reconcile_status'] = $reconcileStatus;

                        if($payerOrPayee == Utility::VENDOR || $payerOrPayee == Utility::CUSTOMER){

                            if(!empty($customer) || !empty($vendor)){
                            $vendorCustomer = ($payerOrPayee == Utility::CUSTOMER) ? $customer: $vendor;
                            $contactType = (!empty($customer)) ? Utility::CUSTOMER : Utility::VENDOR;
                            $accDbData['vendor_customer'] = $vendorCustomer;
                            $accDbData['contact_type'] = $contactType;
                            }
                        }
                        if($payerOrPayee == Utility::EMPLOYEE && !empty($payerOrPayee) ){                        
                            $accDbData['employee_id'] = $request->input('employee');
                        }

                        if(Utility::checkEmptyArrayItem($debitCredit,$i,0) == Utility::DEBIT_TABLE_ID){

                            $accDbData['debit_credit'] = Utility::DEBIT_TABLE_ID;
                            $accDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($debitAccount,$i,0);
                            $accDbData['unit_cost'] = Utility::convertAmountToDate($currCode,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($debitAccount,$i,0),$postingDate);
                            $accDbData['trans_total'] = Utility::checkEmptyArrayItem($debitAccount,$i,0);    //THE AMOUNT USED FOR JOURNAL ENTRY
                            $accDbData['total'] = Utility::convertAmountToDate($currCode,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($debitAccount,$i,0),$postingDate);  //THE AMOUNT USED FOR JOURNAL ENTRY
                            
                        }else{

                            $accDbData['debit_credit'] = Utility::CREDIT_TABLE_ID;
                            $accDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($creditAccount,$i,0);
                            $accDbData['unit_cost'] = Utility::convertAmountToDate($currCode,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($creditAccount,$i,0),$postingDate);
                            $accDbData['trans_total'] = Utility::checkEmptyArrayItem($creditAccount,$i,0);    //THE AMOUNT USED FOR JOURNAL ENTRY
                            $accDbData['total'] = Utility::convertAmountToDate($currCode,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($creditAccount,$i,0),$postingDate);  //THE AMOUNT USED FOR JOURNAL ENTRY
                            
                        }

                        
                        $accDbData['transaction_type'] = $transactionType;
                        $accDbData['post_date'] = $postingDate;
                        $accDbData['transaction_type'] = self::journalEntry;
                        $accDbData['trans_curr'] = $currId;
                        $accDbData['default_curr'] = Utility::currencyArrayItem('id');
                        $accDbData['status'] = Utility::STATUS_ACTIVE;
                        $accDbData['cash_status'] = $cashStatus;
                        $accDbData['created_by'] = Auth::user()->id;

                            if(Utility::checkEmptyArrayItem($debitCredit,$i,0) == Utility::DEBIT_TABLE_ID){
                                AccountJournal::create($accDbData);
                                Utility::updateAccountBalance($chartDetail->id,Utility::checkEmptyArrayItem($debitAccount,$i,0),Utility::DEBIT_TABLE_ID); //UPDATE ACCOUNT BALANCE
                            }else{
                                AccountJournal::create($accDbData);
                                Utility::updateAccountBalance($chartDetail->id,Utility::checkEmptyArrayItem($creditAccount,$i,0),Utility::CREDIT_TABLE_ID); //UPDATE ACCOUNT BALANCE
                            }
                    
                        }

                }
            }else{
                exit(
                    json_encode([
                    'message2' => 'Please ensure that all selected accounts is a debit/credit',
                    'message' => 'warning'
                ])
            );
            }

        }

    }

      
    public static function autoTransaction($request,$dbDATA,$virtualObj){

        $updateStatus = $request->input('update_status');
        $convertStatus = $request->input('convert_status');
        $mainJournal = [];
        //ITEM VARIABLES
        $invClass = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('inv_class_edit')) : Utility::jsonUrlDecode($request->input('inv_class'));
        $itemDesc = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('item_desc_edit')) :  Utility::jsonUrlDecode($request->input('item_desc'));
        $quantity = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('quantity_edit')) :  Utility::jsonUrlDecode($request->input('quantity'));
        $unitCost = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('unit_cost_edit')) :  Utility::jsonUrlDecode($request->input('unit_cost'));
        $unitMeasure = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('unit_measure_edit')) :  Utility::jsonUrlDecode($request->input('unit_measure'));
        $tax = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('tax_edit')) :  Utility::jsonUrlDecode($request->input('tax'));
        $taxPerct = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('tax_perct_edit')) :  Utility::jsonUrlDecode($request->input('tax_perct'));
        $taxAmount = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('tax_amount_edit')) :  Utility::jsonUrlDecode($request->input('tax_amount'));
        $discountPerct = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('discount_perct_edit')) :  Utility::jsonUrlDecode($request->input('discount_perct'));
        $discountAmount = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('discount_amount_edit')) :  Utility::jsonUrlDecode($request->input('discount_amount'));
        $subTotal = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('sub_total_edit')) :  Utility::jsonUrlDecode($request->input('sub_total'));

        //ACCOUNT VARIABLES
        $accClass = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('acc_class_edit')) :  Utility::jsonUrlDecode($request->input('acc_class')); 
        $accDesc = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('acc_desc_edit')) :  Utility::jsonUrlDecode($request->input('acc_desc'));
        $accRate = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('acc_rate_edit')) :  Utility::jsonUrlDecode($request->input('acct_rate')); 
        $accTax = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('acc_tax_edit')) :  Utility::jsonUrlDecode($request->input('acc_tax'));
        $accTaxPerct = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('acc_tax_perct_edit')) :  Utility::jsonUrlDecode($request->input('acc_tax_perct')); 
        $accTaxAmount = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('acc_tax_amount_edit')) :  Utility::jsonUrlDecode($request->input('acc_tax_amount'));
        $accDiscountPerct = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('acc_discount_perct_edit')) :  Utility::jsonUrlDecode($request->input('acc_discount_perct')); 
        $accDiscountAmount = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('acc_discount_amount_edit')) :  Utility::jsonUrlDecode($request->input('acc_discount_amount'));
        $accSubTotal = ($updateStatus == 1) ? Utility::jsonUrlDecode($request->input('acc_sub_total_edit')) :  Utility::jsonUrlDecode($request->input('acc_sub_total'));
        
        //GENERAL VARIABLES
        $postingDate = $request->input('posting_date');  $mailOption = $request->input('mail_option'); 
        $emails = $request->input('emails');    $mailCopy = $request->input('mail_copy'); 
        $dbDATA['uid'] = (($updateStatus == 1 && $convertStatus == 1) || $updateStatus == 0) ? $dbDATA['uid'] : $request->input('edit_uid') ;
        $uid = $dbDATA['uid'];

        $inventoryItemArr = []; //USED FOR COLLECTING ITEMS THAT ARE INVENTORY TYPE IN TRANSACTION
        
        $finYear = self::defaultFinYearObj(); 
        if($updateStatus == 1) {    //IF TRANSACTION IS AN UPDATE/EDIT (equals 1) DO THE FOLLOWING CODE

             
             
             if($updateStatus == 1 && $convertStatus == 1){
                //CONVERSION OF EXISTING DATA TO CREATE NEW DATA
                $mainJournal= JournalExtension::create($dbDATA);
                $virtualObj->journalId = $mainJournal->id;
                $virtualObj->uid = $mainJournal->uid;
             }else{

                 //REMOVE EXISTING ACCOUNT JOURNAL DEBI/CREDIT FROM AccountJournal DB TABLE
                 $journalItems = AccountJournal::specialColumns('extension_id',$request->input('edit_id')); //SELECT JOURNAL ITEMS FOR ID TO BE EDITED
                 if($journalItems->count() >0){
                    foreach($journalItems as $item){
                        $accountType = ($item->debit_credit == Utility::CREDIT_TABLE_ID) ? Utility::DEBIT_TABLE_ID : Utility::CREDIT_TABLE_ID;
                        Utility::updateAccountBalance($item->chart_id,$item->trans_total,$accountType); //UPDATE ACCOUNT BALANCE TO INITIAL BALANCE                
                        AccountJournal::destroy($item->id);           
                    }  
                }              


                 //UPDATE THE JOURNAL EXTENTION WITH NEW DATA
                $mainJournal = JournalExtension::defaultUpdate('id', $request->input('edit_id'), $dbDATA);
                $virtualObj->journalId = $request->input('edit_id');
                $virtualObj->uid = $request->input('edit_uid');
             }
             
 
             $countExtAcc = $request->input('count_ext_acc');
             $countExtItem = $request->input('count_ext_po');
             
             if($countExtItem > 0){
 
                 for ($i = 1; $i <= $countExtItem; $i++) {
                     $itemDbDataEdit = [];
                     
                     if (!empty($request->input('inv_class' . $i))) {
                        
                        $inventoryData = Inventory::firstRow('id',$request->input('inv_class' . $i));
                         $itemDbDataEdit['item_id'] = $request->input('inv_class' . $i);
                         $itemDbDataEdit['extension_id'] = $virtualObj->journalId;
                         $itemDbDataEdit['fin_year'] = $finYear->id;
                         $itemDbDataEdit['uid'] = $uid;
                         $itemDbDataEdit['class_id'] = $request->input('transaction_class');
                         $itemDbDataEdit['location_id'] = $request->input('location');
                         $itemDbDataEdit['main_trans'] = Utility::STATUS_ACTIVE;
                         $itemDbDataEdit['unit_measurement'] = $request->input('unit_measure' . $i);
                         $itemDbDataEdit['quantity'] = $request->input('quantity' . $i);
                         $itemDbDataEdit['trans_desc'] = $request->input('item_desc' . $i);
                         $itemDbDataEdit['unit_cost_trans'] = $request->input('unit_cost' . $i);
                         $itemDbDataEdit['unit_cost'] = self::convertAmountToDate($virtualObj->currCode, Utility::currencyArrayItem('code'), $request->input('unit_cost' . $i), $postingDate);
                         $itemDbDataEdit['tax_id'] = Utility::checkEmptyItem($request->input('tax' . $i), 0);
                         $itemDbDataEdit['tax_perct'] = Utility::checkEmptyItem($request->input('tax_perct' . $i), 0);
                         $itemDbDataEdit['tax_amount_trans'] = Utility::checkEmptyItem($request->input('tax_amount' . $i), 0);
                         $itemDbDataEdit['tax_amount'] = self::convertAmountToDate($virtualObj->currCode, Utility::currencyArrayItem('code'), $request->input('tax_amount' . $i), $postingDate);
                         $itemDbDataEdit['discount_amount_trans'] = Utility::checkEmptyItem($request->input('discount_amount' . $i), 0);
                         $itemDbDataEdit['discount_amount'] = self::convertAmountToDate($virtualObj->currCode, Utility::currencyArrayItem('code'), $request->input('discount_amount' . $i), $postingDate);
                         $itemDbDataEdit['discount_perct'] = Utility::checkEmptyItem($request->input('discount_perct' . $i), 0);
                         $itemDbDataEdit['extended_amount_trans'] = Utility::checkEmptyItem($request->input('sub_total' . $i), 0);
                         $itemDbDataEdit['extended_amount'] = self::convertAmountToDate($virtualObj->currCode, Utility::currencyArrayItem('code'), $request->input('sub_total' . $i), $postingDate);
                        
                         $itemDbDataEdit['vendor_customer'] = $virtualObj->contact;
                         $itemDbDataEdit['contact_type'] = $virtualObj->contactType;
                         $itemDbDataEdit['transaction_type'] = $virtualObj->transactionType;
                         $itemDbDataEdit['employee_id'] = $virtualObj->employeeId;
                         $itemDbDataEdit['trans_curr'] = $virtualObj->currId;
                         $itemDbDataEdit['default_curr'] = Utility::currencyArrayItem('id');
                         $itemDbDataEdit['post_date'] = $virtualObj->postDate;
                         $itemDbDataEdit['cash_status'] = $virtualObj->cashStatus;
                         $itemDbDataEdit['status'] = Utility::STATUS_ACTIVE;
                         $itemDbDataEdit['created_by'] = Auth::user()->id;

                          //FOR TRANSACTIONS INVOLVIING COST OF GOODS SOLD OF ITEM
                    if(in_array($virtualObj->transactionType,self::COGTransactions)){
                        $virtualObj->income =  Utility::roundNum($request->input('quantity' . $i)*$request->input('unit_cost' . $i),2) - Utility::checkEmptyItem($request->input('discount_amount' . $i), 0); 
                        
                        //INCOME ACCOUNT TRANSACTION
                        $itemDbDataEdit['trans_total'] = $virtualObj->income; //AMOUNT TO BE RECORDED FOR INCOME
                        $itemDbDataEdit['total'] = self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$virtualObj->income,$postingDate);
                        $itemDbDataEdit['chart_id'] = $inventoryData->income_account;
                        $itemDbDataEdit['acct_cat_id'] = $inventoryData->income->acct_cat_id;
                        $itemDbDataEdit['detail_id'] = $inventoryData->income->detail_id;
                        $itemDbDataEdit['debit_credit'] = $virtualObj->incomeAccount;

                        Utility::updateAccountBalance($inventoryData->income_account,$virtualObj->income,$virtualObj->incomeAccount); //UPDATE ACCOUNT BALANCE FOR INCOME ACCOUNT                   
                        
                        if($inventoryData->inventory_type == Utility::INVENTORY_ITEM){   //CHECK IF ITEM IS AN INVENTORY ITEM TYPE
                        
                        $inventoryItemArr[] = $request->input('inv_class' . $i); //HOLD ITEMS THAT EXIST AS INVENTORY ITEM                                              

                        
                        $virtualObj->COG = $request->input('quantity' . $i) * $inventoryData->unit_cost;

                        //DETECT RECONCILE STATUS OF INVENTORY ACCOUNT DEPENDING ON WHETHER IT CHANGED DURING UPDATE (RECONCILIATION IS JUST FOR BALANCE SHEET ACCOUNTS)
                        if(!empty($virtualObj->reconcileArr)){  //IF RECONCILED ACCOUNTS EXITS
                            self::detectTransChange($virtualObj,$inventoryData->inventory_account,$virtualObj->COG,$virtualObj->postDate,$inventoryData->id);
                        }

                        //SAVE INVENTORY TRANSACTION TO JOURNAL
                        self::virtualTransaction($inventoryData->inventory_account,$request,$virtualObj,$virtualObj->COG,$virtualObj->inventoryAccount);
                        
                        //SAVE COST OF GOODS SOLD TRANSACTION TO JOURNAL
                        self::virtualTransaction($inventoryData->expense_account,$request,$virtualObj,$virtualObj->COG,$virtualObj->COGAccount);
                        
                        }
                    }

                    //FOR TRANSACTIONS NOT INVOLVIING COST OF GOODS SOLD OF ITEM E.G EXPENSES, BILL, BILLCASHPAYMENT ETC.
                    if(in_array($virtualObj->transactionType,self::inventoryTransactions)){
                        if($inventoryData->inventory_type == Utility::INVENTORY_ITEM){   //CHECK IF ITEM IS AN INVENTORY ITEM TYPE
                        
                            $virtualObj->inventory =  Utility::roundNum($request->input('quantity' . $i)*$request->input('unit_cost' . $i),2) - Utility::checkEmptyItem($request->input('discount_amount' . $i), 0);
                    
                            //INVENTORY ACCOUNT TRANSACTION
                            $itemDbDataEdit['trans_total'] = $virtualObj->inventory; //AMOUNT TO BE RECORDED FOR INVENTORY
                            $itemDbDataEdit['total'] = self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$virtualObj->inventory,$postingDate);
                            $itemDbDataEdit['chart_id'] = $inventoryData->inventory_account;
                            $itemDbDataEdit['acct_cat_id'] = $inventoryData->inventory->acct_cat_id;
                            $itemDbDataEdit['detail_id'] = $inventoryData->inventory->detail_id;
                            $itemDbDataEdit['debit_credit'] = $virtualObj->inventoryAccount;

                            //DETECT RECONCILE STATUS OF INVENTORY ACCOUNT DEPENDING ON WHETHER IT CHANGED DURING UPDATE (RECONCILIATION IS JUST FOR BALANCE SHEET ACCOUNTS)
                            if(!empty($virtualObj->reconcileArr)){  //IF RECONCILED ACCOUNTS EXITS
                                self::detectTransChange($virtualObj,$inventoryData->inventory_account,$virtualObj->inventory,$virtualObj->postDate,$inventoryData->id);
                            }

                            Utility::updateAccountBalance($inventoryData->inventory_account,$virtualObj->inventory,$virtualObj->inventoryAccount); //UPDATE ACCOUNT BALANCE FOR INVENTORY ACCOUNT                   
                                                    
                        }else{

                            $virtualObj->expense =  $request->input('sub_total' . $i);
                    
                            //EXPENSE ACCOUNT TRANSACTION
                            $itemDbDataEdit['trans_total'] = $virtualObj->expense; //AMOUNT TO BE RECORDED FOR EXPENSE
                            $itemDbDataEdit['total'] = self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$virtualObj->expense,$postingDate);
                            $itemDbDataEdit['chart_id'] = $inventoryData->expense_account;
                            $itemDbDataEdit['acct_cat_id'] = $inventoryData->expense->acct_cat_id;
                            $itemDbDataEdit['detail_id'] = $inventoryData->expense->detail_id;
                            $itemDbDataEdit['debit_credit'] = $virtualObj->expenseAccount;

                            Utility::updateAccountBalance($inventoryData->expense_account,$virtualObj->expense,$virtualObj->expenseAccount); //UPDATE ACCOUNT BALANCE FOR EXPENSE ACCOUNT                   
                            
                        }
                        

                    }

 
                        $itemDbDataEdit['reconcile_status'] = $virtualObj->reconcileStatus;
                        $itemDbDataEdit['reconcile_id'] = $virtualObj->reconcileId;
                        
                         AccountJournal::create($itemDbDataEdit);

                     }  //END IF ITEM IS NOT EMPTY
 
                 }  //END OF LOOP FOR EXISTING INVENTORY ITEMS
 
             }
 
             if($countExtAcc > 0){
 
                 for ($i = 1; $i <= $countExtAcc; $i++) {
 
                    $chartDetail = AccountChart::firstRow('id',$request->input('acc_class' . $i));

                     if (!empty($request->input('acc_class' . $i))) {
                         $accDbDataEdit['account_id'] = $request->input('acc_class' . $i);
                         $accDbDataEdit['acct_cat_id'] = $chartDetail->acct_cat_id;
                         $accDbDataEdit['detail_id'] =  $chartDetail->detail_id;
                         $accDbDataEdit['chart_id'] =  $chartDetail->id;
                         $accDbDataEdit['extension_id'] = $virtualObj->journalId;
                         $accDbDataEdit['fin_year'] = $finYear->id;
                         $accDbDataEdit['uid'] = $uid;
                         $accDbDataEdit['class_id'] = $request->input('transaction_class');
                         $accDbDataEdit['location_id'] = $request->input('location');
                         $accDbDataEdit['main_trans'] = Utility::STATUS_ACTIVE;
                         $accDbDataEdit['trans_desc'] = $request->input('item_desc_acc' . $i);
                         $accDbDataEdit['unit_cost_trans'] = $request->input('unit_cost_acc' . $i);
                         $accDbDataEdit['unit_cost'] = self::convertAmountToDate($virtualObj->currCode, Utility::currencyArrayItem('code'), $request->input('unit_cost_acc' . $i), $postingDate);
                         
                         $discountedTotalAccEdit =  Utility::roundNum( $request->input('unit_cost_acc' . $i) -  Utility::checkEmptyItem($request->input('discount_amount_acc' . $i), 0) );  //TOTAL WITH DISCOUNT EXCLUDING TAX
                         
                         $accDbDataEdit['trans_total'] = $discountedTotalAccEdit;
                         $accDbDataEdit['total'] = self::convertAmountToDate($virtualObj->currCode, Utility::currencyArrayItem('code'), $discountedTotalAccEdit, $postingDate);
                         $accDbDataEdit['tax_id'] = $request->input('tax_acc' . $i);
                         $accDbDataEdit['tax_perct'] = $request->input('tax_perct_acc' . $i);
                         $accDbDataEdit['tax_amount_trans'] = $request->input('tax_amount_acc' . $i);
                         $accDbDataEdit['tax_amount'] = self::convertAmountToDate($virtualObj->currCode, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('tax_amount_acc' . $i), 0), $postingDate);
                         $accDbDataEdit['discount_amount_trans'] = Utility::checkEmptyItem($request->input('discount_amount_acc' . $i), 0);
                         $accDbDataEdit['discount_amount'] = self::convertAmountToDate($virtualObj->currCode, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('discount_amount_acc' . $i), 0), $postingDate);
                         $accDbDataEdit['discount_perct'] = $request->input('discount_perct_acc' . $i);
                         $accDbDataEdit['extended_amount_trans'] = $request->input('sub_total_acc' . $i);
                         $accDbDataEdit['extended_amount'] = self::convertAmountToDate($virtualObj->currCode, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('sub_total_acc' . $i), 0), $postingDate);
                         $accDbDataEdit['vendor_customer'] = $virtualObj->contact;
                         $accDbDataEdit['contact_type'] = $virtualObj->contactType;
                         $accDbDataEdit['transaction_type'] = $virtualObj->transactionType;
                         $accDbDataEdit['employee_id'] = $virtualObj->employeeId;
                         $accDbDataEdit['trans_curr'] = $virtualObj->currId;
                         $accDbDataEdit['default_curr'] = Utility::currencyArrayItem('id');
                         $accDbDataEdit['post_date'] = $virtualObj->postDate;
                         $accDbDataEdit['cash_status'] = $virtualObj->cashStatus;
                         $accDbDataEdit['status'] = Utility::STATUS_ACTIVE;
                         $accDbDataEdit['created_by'] = Auth::user()->id;

                         //DETECT RECONCILE STATUS OF ACCOUNT DEPENDING ON WHETHER IT CHANGED DURING UPDATE (RECONCILIATION IS JUST FOR BALANCE SHEET ACCOUNTS)
                        if(in_array($chartDetail->acct_cat_id,Utility::BALANCE_SHEET_ACCOUNTS)){
                            if(!empty($virtualObj->reconcileArr)){  //IF RECONCILED ACCOUNTS EXITS
                                self::detectTransChange($virtualObj,$chartDetail->id,$discountedTotalAccEdit,$virtualObj->postDate);
                            }
                        }

                         if(in_array($virtualObj->transactionType,self::debitAccountChart)){
                            $accDbDataEdit['debit_credit'] = Utility::DEBIT_TABLE_ID;
                        } 
    
                       if(in_array($virtualObj->transactionType,self::creditAccountChart)){
                        $accDbDataEdit['debit_credit'] = Utility::CREDIT_TABLE_ID;
                        } 
    
                        $accDbDataEdit['reconcile_status'] = $virtualObj->reconcileStatus;
                        $accDbDataEdit['reconcile_id'] = $virtualObj->reconcileId;

                        AccountJournal::create($accDbDataEdit);
    
                        if(in_array($virtualObj->transactionType,self::debitAccountChart)){
                            Utility::updateAccountBalance($chartDetail->id,$discountedTotalAccEdit,Utility::DEBIT_TABLE_ID); //UPDATE ACCOUNT BALANCE
                        }
    
                        if(in_array($virtualObj->transactionType,self::creditAccountChart)){
                            Utility::updateAccountBalance($chartDetail->id,$discountedTotalAccEdit,Utility::CREDIT_TABLE_ID); //UPDATE ACCOUNT BALANCE
                        }                             

                     }
 
                 }  //END OF LOOP FOR EXISTING ACCOUNT CATEGORIES
 
             }            
           
        }else{  //INSERT DATA AS NEW NOT AN UPDATE, THAT MEANS THE EXISTING DATA CODES ABOVE WILL NOT GO THROUGH

            $mainJournal= JournalExtension::create($dbDATA);
            $virtualObj->journalId = $mainJournal->id;
            $virtualObj->uid = $mainJournal->uid;

        }       
        //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

        //BEGINING OF LOOP FOR NEWLY ADDED DATA
        
            $virtualObj->reconcile_status = self::uncleared;    //REDECLARE STATUS AS UNCLEARED FOR NEW ENTRIES
            //LOOP THROUGH ACCOUNTS SELECTED FROM CHART OF ACCOUNT LIST
            if(!empty($accClass)) {   
                if(count($accClass) == count($accRate) && count($accSubTotal) == count($accClass)){
                    for($i=0;$i<count($accClass);$i++){
                        $chartDetail = AccountChart::firstRow('id',Utility::checkEmptyArrayItem($accClass,$i,0));

                        if(!empty($chartDetail)){   //IF ACCOUNT CHART ID IS NOT EMPTY CONTINUE                                            

                        $accDbData['account_id'] = Utility::checkEmptyArrayItem($accClass,$i,0);
                        $accDbData['acct_cat_id'] = $chartDetail->acct_cat_id;
                        $accDbData['detail_id'] =  $chartDetail->detail_id;
                        $accDbData['chart_id'] =  $chartDetail->id;
                        $accDbData['extension_id'] = $virtualObj->journalId;
                        $accDbData['fin_year'] = $finYear->id;
                        $accDbData['uid'] = $uid;
                        $accDbData['class_id'] = $request->input('transaction_class');
                        $accDbData['location_id'] = $request->input('location');
                        $accDbData['main_trans'] = Utility::STATUS_ACTIVE;
                        $accDbData['trans_desc'] = Utility::checkEmptyArrayItem($accDesc,$i,'');
                        $accDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($accRate,$i,0);
                        $accDbData['unit_cost'] = Utility::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($accRate,$i,0),$postingDate);
                        
                        $discountedTotalAcc = Utility::roundNum( Utility::checkEmptyArrayItem($accRate,$i,0)-Utility::checkEmptyArrayItem($accDiscountAmount,$i,0) );  //RATE MINUS DISCOUNT EXCLUDING TAX
                        
                        $accDbData['trans_total'] = $discountedTotalAcc;    //THE AMOUNT USED FOR JOURNAL ENTRY
                        $accDbData['total'] = Utility::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$discountedTotalAcc,$postingDate);  //THE AMOUNT USED FOR JOURNAL ENTRY
                        $accDbData['tax_id'] = Utility::checkEmptyArrayItem($accTax,$i,0);
                        $accDbData['tax_perct'] = Utility::checkEmptyArrayItem($accTaxPerct,$i,0);
                        $accDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($accTaxAmount,$i,0);
                        $accDbData['tax_amount'] = Utility::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($accTaxAmount,$i,0),$postingDate);
                        $accDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($accDiscountAmount,$i,0);
                        $accDbData['discount_amount'] = Utility::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($accDiscountAmount,$i,0),$postingDate);
                        $accDbData['discount_perct'] = Utility::checkEmptyArrayItem($accDiscountPerct,$i,0);
                        $accDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($accSubTotal,$i,0);
                        $accDbData['extended_amount'] = Utility::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($accSubTotal,$i,0),$postingDate);
                        $accDbData['vendor_customer'] = $virtualObj->contact;
                        $accDbData['contact_type'] = $virtualObj->contactType;
                        $accDbData['transaction_type'] = $virtualObj->transactionType;
                        $accDbData['employee_id'] = $virtualObj->employeeId;
                        $accDbData['trans_curr'] = $virtualObj->currId;
                        $accDbData['default_curr'] = Utility::currencyArrayItem('id');
                        $accDbData['post_date'] = $virtualObj->postDate;
                        $accDbData['reconcile_status'] = $virtualObj->reconcileStatus;
                        $accDbData['cash_status'] = $virtualObj->cashStatus;
                        $accDbData['status'] = Utility::STATUS_ACTIVE;
                        $accDbData['created_by'] = Auth::user()->id;

                        if(in_array($virtualObj->transactionType,self::debitAccountChart)){
                            $accDbData['debit_credit'] = Utility::DEBIT_TABLE_ID;
                        } 

                    if(in_array($virtualObj->transactionType,self::creditAccountChart)){
                        $accDbData['debit_credit'] = Utility::CREDIT_TABLE_ID;
                        } 

                        AccountJournal::create($accDbData);

                        if(in_array($virtualObj->transactionType,self::debitAccountChart)){
                            Utility::updateAccountBalance($chartDetail->id,Utility::checkEmptyArrayItem($accRate,$i,0),Utility::DEBIT_TABLE_ID); //UPDATE ACCOUNT BALANCE
                        }

                        if(in_array($virtualObj->transactionType,self::creditAccountChart)){
                            Utility::updateAccountBalance($chartDetail->id,Utility::checkEmptyArrayItem($accRate,$i,0),Utility::CREDIT_TABLE_ID); //UPDATE ACCOUNT BALANCE
                        }

                        }
                    }

                }
            }

            //LOOP THROUGH NEW ITEMS
            if(!empty($invClass)) {   
                if(count($invClass) == count($subTotal) && count($unitCost) == count($subTotal)){
                    for($i=0;$i<count($invClass);$i++){
                        $inventoryData = Inventory::firstRow('id',Utility::checkEmptyArrayItem($invClass,$i,0));
                        if(!empty($inventoryData)){ //ENSURE THAT ITEM EXISTS IN THE DATABASE


                        $journalDbData['item_id'] = Utility::checkEmptyArrayItem($invClass,$i,0);
                        $journalDbData['unit_measurement'] = Utility::checkEmptyArrayItem($unitMeasure,$i,0);
                        $journalDbData['quantity'] = Utility::checkEmptyArrayItem($quantity,$i,0);
                        $journalDbData['trans_desc'] = Utility::checkEmptyArrayItem($itemDesc,$i,'');
                        $journalDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($unitCost,$i,0);
                        $journalDbData['unit_cost'] = self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($unitCost,$i,0),$postingDate);
                        $journalDbData['tax_id'] = Utility::checkEmptyArrayItem($tax,$i,0);
                        $journalDbData['tax_perct'] = Utility::checkEmptyArrayItem($taxPerct,$i,0);
                        $journalDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($taxAmount,$i,0);
                        $journalDbData['tax_amount'] = self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($taxAmount,$i,0),$postingDate);
                        $journalDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($discountAmount,$i,0);
                        $journalDbData['discount_amount'] = self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($discountAmount,$i,0),$postingDate);
                        $journalDbData['discount_perct'] = Utility::checkEmptyArrayItem($discountPerct,$i,0);
                        $journalDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($subTotal,$i,0);
                        $journalDbData['extended_amount'] = self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($subTotal,$i,0),$postingDate);

                        $journalDbData['extension_id'] = $virtualObj->journalId;
                        $journalDbData['fin_year'] = $finYear->id;
                        $journalDbData['uid'] = $uid;
                        $journalDbData['class_id'] = $request->input('transaction_class');
                        $journalDbData['location_id'] = $request->input('location');
                        $journalDbData['main_trans'] = Utility::STATUS_ACTIVE;
                        $journalDbData['status'] = Utility::STATUS_ACTIVE;
                        $journalDbData['created_by'] = Auth::user()->id;
                        $journalDbData['vendor_customer'] = $virtualObj->contact;
                        $journalDbData['contact_type'] = $virtualObj->contactType;
                        $journalDbData['transaction_type'] = $virtualObj->transactionType;
                        $journalDbData['employee_id'] = $virtualObj->employeeId;
                        $journalDbData['trans_curr'] = $virtualObj->currId;
                        $journalDbData['default_curr'] = Utility::currencyArrayItem('id');
                        $journalDbData['post_date'] = $virtualObj->postDate;
                        $journalDbData['reconcile_status'] = $virtualObj->reconcileStatus;
                        $journalDbData['cash_status'] = $virtualObj->cashStatus;


                        //FOR TRANSACTIONS INVOLVIING COST OF GOODS SOLD OF ITEM
                        if(in_array($virtualObj->transactionType,self::COGTransactions)){
                            $virtualObj->income =  Utility::roundNum(Utility::checkEmptyArrayItem($quantity,$i,0)*Utility::checkEmptyArrayItem($unitCost,$i,0),2) - Utility::checkEmptyArrayItem($discountAmount,$i,0);
                            
                            //INCOME ACCOUNT TRANSACTION
                            $journalDbData['trans_total'] = $virtualObj->income; //AMOUNT TO BE RECORDED FOR INCOME
                            $journalDbData['total'] = self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$virtualObj->income,$postingDate);
                            $journalDbData['chart_id'] = $inventoryData->income_account;
                            $journalDbData['acct_cat_id'] = $inventoryData->income->acct_cat_id;
                            $journalDbData['detail_id'] = $inventoryData->income->detail_id;
                            $journalDbData['debit_credit'] = $virtualObj->incomeAccount;

                            Utility::updateAccountBalance($inventoryData->income_account,$virtualObj->income,$virtualObj->incomeAccount); //UPDATE ACCOUNT BALANCE FOR INCOME ACCOUNT                   
                            
                            if($inventoryData->inventory_type == Utility::INVENTORY_ITEM){   //CHECK IF ITEM IS AN INVENTORY ITEM TYPE
                            
                            $inventoryItemArr[] = Utility::checkEmptyArrayItem($invClass,$i,0); //HOLD ITEMS THAT EXIST AS INVENTORY ITEM                                              

                            //SAVE INVENTORY TRANSACTION TO JOURNAL
                            $virtualObj->COG = Utility::checkEmptyArrayItem($quantity,$i,0) * $inventoryData->unit_cost; //COST OF GOODS SOLD
                            self::virtualTransaction($inventoryData->inventory_account,$request,$virtualObj,$virtualObj->COG,$virtualObj->inventoryAccount);
                            
                            //SAVE COST OF GOODS SOLD TRANSACTION TO JOURNAL
                            self::virtualTransaction($inventoryData->expense_account,$request,$virtualObj,$virtualObj->COG,$virtualObj->COGAccount);
                            
                            }
                        }

                        //FOR TRANSACTIONS NOT INVOLVIING COST OF GOODS SOLD OF ITEM E.G EXPENSES, BILL, BILLCASHPAYMENT ETC.
                        if(in_array($virtualObj->transactionType,self::inventoryTransactions)){
                            if($inventoryData->inventory_type == Utility::INVENTORY_ITEM){   //CHECK IF ITEM IS AN INVENTORY ITEM TYPE
                            
                                $virtualObj->inventory =  Utility::roundNum(Utility::checkEmptyArrayItem($quantity,$i,0)*Utility::checkEmptyArrayItem($unitCost,$i,0),2) - Utility::checkEmptyArrayItem($discountAmount,$i,0);
                        
                                //INVENTORY ACCOUNT TRANSACTION
                                $journalDbData['trans_total'] = $virtualObj->inventory; //AMOUNT TO BE RECORDED FOR INVENTORY
                                $journalDbData['total'] = self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$virtualObj->inventory,$postingDate);
                                $journalDbData['chart_id'] = $inventoryData->inventory_account;
                                $journalDbData['acct_cat_id'] = $inventoryData->inventory->acct_cat_id;
                                $journalDbData['detail_id'] = $inventoryData->inventory->detail_id;
                                $journalDbData['debit_credit'] = $virtualObj->inventoryAccount;

                                Utility::updateAccountBalance($inventoryData->inventory_account,$virtualObj->inventory,$virtualObj->inventoryAccount); //UPDATE ACCOUNT BALANCE FOR INVENTORY ACCOUNT                   
                                                        
                            }else{

                                $virtualObj->expense = Utility::roundNum(Utility::checkEmptyArrayItem($quantity,$i,0)*Utility::checkEmptyArrayItem($unitCost,$i,0),2) - Utility::checkEmptyArrayItem($discountAmount,$i,0);
                        
                                //EXPENSE ACCOUNT TRANSACTION
                                $journalDbData['trans_total'] = $virtualObj->expense; //AMOUNT TO BE RECORDED FOR EXPENSE
                                $journalDbData['total'] = self::convertAmountToDate($virtualObj->currCode,Utility::currencyArrayItem('code'),$virtualObj->expense,$postingDate);
                                $journalDbData['chart_id'] = $inventoryData->expense_account;
                                $journalDbData['acct_cat_id'] = $inventoryData->expense->acct_cat_id;
                                $journalDbData['detail_id'] = $inventoryData->expense->detail_id;
                                $journalDbData['debit_credit'] = $virtualObj->expenseAccount;

                                Utility::updateAccountBalance($inventoryData->expense_account,$virtualObj->expense,$virtualObj->expenseAccount); //UPDATE ACCOUNT BALANCE FOR EXPENSE ACCOUNT                   
                                
                            }
                            

                        }

                        AccountJournal::create($journalDbData);

                        }

                    }

                }
            }

            //SEND OUT MAIL   
            
                if($mailOption == Utility::STATUS_ACTIVE){
                    $journalId = $virtualObj->journalId;
                    $getJournal = JournalExtension::firstRow('id',$journalId);
                    $getJournalData = accountJournal::specialColumns('uid',$getJournal->uid);
                    $currencyData = Currency::firstRow('id',$virtualObj->currId);
                    Utility::fetchBOMItems($getJournalData);

                    $mailContent = [];

                    $documentType = self::transType($virtualObj->transactionType);
                    $mailCopyContent = ($mailCopy != '') ? explode(',',$mailCopy) : [];
                    $mailContent['copy'] = $mailCopyContent;
                    $mailContent['fromEmail']= Auth::user()->email;
                    $mailContent['journal']= $getJournal;
                    $mailContent['documentType']= $documentType;
                    $mailContent['transactionType']= $virtualObj->transactionType;
                    $mailContent['journalData'] = $getJournalData;
                    $mailContent['attachment'] = $virtualObj->mailFiles;
                    $mailContent['currency'] = $virtualObj->currCode;
                    $mailContent['transactionType'] = $virtualObj->transactionType;

                    //CHECK IF MAIL IS EMPTY ELSE CONTINUE TO SEND MAIL
                    if($emails != ''){
                        $mailToArray = explode(',',$emails);
                        if(count($mailToArray) >0){ //SEND MAIL TO ALL INVOLVED IN THE PURCHASE ORDER
                            foreach($mailToArray as $data) {
                                Notify::JournalMail('mail_views.journal', $mailContent, $data, Auth::user()->firstname.' '.Auth::user()->lastname, 'Purchase Order');
                            }
                        }
                    }

                }
        
    }
    
    //VIRTUAL TRANSACTION TO APPEAR IN MAIN TRANSACTIONS TO BALANCE DEBIT OR CREDIT SIDE OF JOURNAL ACCOUNT
    public static function virtualTransaction($acctChartId,$request,$virtualObj,$amountTrans,$debitCredit){

        $chartDetail = AccountChart::firstRow('id',$acctChartId);
        $defaultCurr = self::defaultCurrObj();
        $latestExRate = self::latestExchangeRate();
        $finYear = self::defaultFinYearObj();     

        $amount = Utility::convertAmount($defaultCurr->code,$virtualObj->currCode,$amountTrans);      

        $journalEntry = [
            'uid' => $virtualObj->uid,
            'acct_cat_id' => $chartDetail->acct_cat_id,
            'detail_id' =>  $chartDetail->detail_id,
            'chart_id' =>  $chartDetail->id,
            'account_id' =>  $chartDetail->acct_cat_id,
            'extension_id' => $virtualObj->journalId,
            'fin_year' => $finYear->id,
            'class_id' => $virtualObj->transactionClass,
            'location_id' => $virtualObj->location,
            'trans_desc' => 'Journal Entry for '.$chartDetail->acct_name,
            'unit_cost' => $amount,
            'unit_cost_trans' => $amountTrans,
            'extended_amount' => $amount,
            'extended_amount_trans' => $amountTrans,
            'total' => $amount,
            'trans_total' => $amountTrans,
            'default_curr' => $defaultCurr->id,
            'trans_curr' => $virtualObj->currId,
            'debit_credit' =>  $debitCredit,
            'post_date' =>  $virtualObj->postDate,
            'ex_rate' => $latestExRate->rates,
            'created_by' => Auth::user()->id,
            'status' => Utility::STATUS_ACTIVE,
            'transaction_type' => $virtualObj->transactionType,
            'main_trans' => Utility::ZERO,
            'cash_status' => $virtualObj->cashStatus,
            'reconcile_status' => $virtualObj->reconcileStatus,
            'reconcile_id' => $virtualObj->reconcileId

        ];

        if(!empty($virtualObj->employeeId)){
            $journalEntry['employee_id'] = $virtualObj->employeeId;
        }

        if(!empty($virtualObj->contact)){
            $journalEntry['vendor_customer'] = $virtualObj->contact;
            $journalEntry['contact_type'] = $virtualObj->contactType;
        }

        AccountJournal::create($journalEntry);

        Utility::updateAccountBalance($chartDetail->id,$amountTrans,$debitCredit); //UPDATE ACCOUNT BALANCE

    }

    public static function validateFinanceTransaction($postDate,$password){

        Utility::checkCurrencyActiveStatus();   //CHECK IF THERE IS AN ACTIVE CURRENCY
        Utility::checkFinYearActiveStatus();    //CHECK IF THERE IS AN ACTIVE FINANCIAL YEAR
        $defaultTransactionAccounts = self::defaultTransactionAccounts();      //SELECT DEFAULT TRANSACTION ACCOUNTS

        if(empty($defaultTransactionAccounts)){
            exit(
                json_encode([
                'message2' => 'Please ensure that default accounts for transaction have been created and active',
                'message' => 'warning'
            ])
        );
        }

        if(Utility::checkClosingBook($postDate,$password) == Utility::ZERO){
            exit(
                json_encode([
                'message2' => 'Transaction of this date and below have been closed, or enter a correct password to get access',
                'message' => 'warning'
            ])
        );
        }

    }

    //GET THE PERCENTAGE OF AN ITEM AMOUNT (MAYBE FROM A LIST OF AMOUNT WHICH IS EQUAL TO A TOTAL AMOUNT) FROM A TOTAL AMOUNT
    public static function getPercentageBalFromCreditBalance($itemAmountBal,$oldTotalBal,$newTotalBal){
        $perctOfNewBal = ($newTotalBal/$oldTotalBal)*100;   //GET PERCENTAGE OF NEW BALANCE
        $perctOfItemAmountBal = ($perctOfNewBal*$itemAmountBal)/100;    //GET PERCENTAGE AMOUNT OF ITEM CREDIT BALANCE
        return Utility::roundNum($perctOfItemAmountBal);
    }

    public static function updateCreditDebitMemoJournal($oldBal,$newBal,$virtualObj){
        $dbData = JournalExtension::specialColumns2('vendor_customer',$virtualObj->contact,'transaction_type',$virtualObj->creditTransactionType);
        
        foreach($dbData as $val){
            $itemNewBalTrans = self::getPercentageBalFromCreditBalance($val->balance,$oldBal,$newBal);
            
            $balanceTrans = $itemNewBalTrans; //DEFAULT AMOUNT
            $balance = Utility::convertAmount(Utility::currencyArrayItem('code'),$virtualObj->currCode,$balanceTrans);
            $balancePaidTrans = $val->balance_paid_trans + $itemNewBalTrans;    //FOREIGN AMOUNT
            $balancePaid = Utility::convertAmount(Utility::currencyArrayItem('code'),$virtualObj->currCode,$balancePaidTrans);
            $updateArr = [
                'balance_trans' => $balanceTrans,
                'balance' =>  $balance,
                'balance_paid_trans' => $balancePaidTrans,
                'balance_paid' =>  $balancePaid, 
            ];
            if($balanceTrans <= 0){
                $updateArr['balance_status'] = Utility::ZERO;
                $updateArr['journal_status'] = Utility::CLOSED_ACCOUNT_STATUS;
            }
            
            JournalExtension::defaultUpdate('id',$val->id,$updateArr);


        }


    }

    public static function inflowOutflow($request){

        //LOOP ACCOUNTS
        $paymentAccount = $request->input('payment_account');
        $receiptAccount = $request->input('receipt_account');
        $sumTotal = $request->input('total_amount');
        //GENERAL ITEMS
        $password = $request->input('password');
        $postingDate = $request->input('posting_date');
        $transactionType = $request->input('transaction_type');
        $creditTransactionType = $request->input('credit_transaction_type');
        $paymentMethod = $request->input('payment_method');
        $fileNo = $request->input('file_no');
        $contactCreditBalArr = [];
        $inflowOutflowDbData = [];

        self::validateFinanceTransaction($postingDate,$password);  //ENSURE THAT EVERYTHING IS SET BEFORE A TRANSACTION CAN PROCEED

        $countItems = $request->input('count_ext');
        if($countItems > 0){

            $files = $request->file('file');
            $attachment = [];
            $mailFiles = [];     


            //UPLOAD FILE IF IT EXISTS
            if($files != ''){
                foreach($files as $file){
                    //return$file;
                    $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                    //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                    //array_push($cdn_images,$file_name);
                    $attachment[] =  $file_name;
                    $mailFiles[] = Utility::FILE_URL($file_name);

                    $file->move(
                        Utility::FILE_URL(), $file_name
                    );

                }
            }

            for ($i = 1; $i <= $countItems; $i++) {                
                
                $contactId = $request->input('contact'.$i);
                $contactCurrCreditBal = $request->input($contactId.'contact_curr_credit_bal'.$i);
                $contactDefaultCreditBal = $request->input($contactId.'contact_default_credit_bal'.$i);

                $contactData = VendorCustomer::firstRow('id',$contactId);
                $dbData = JournalExtension::firstRow('id',$request->input('journal_id'.$i));
                $invoiceBillFileNo = (!empty($dbData->file_no)) ? $dbData->file_no : $dbData->id;
                $invoiceBillId = $dbData->id;

                $balanceTrans = $dbData->balance_trans - $request->input('curr_total'.$i);
                $balancePaidTrans = $dbData->balance_paid_trans + $request->input('curr_total'.$i);

                if (!empty($request->input('curr_total' . $i))) {   //IF PAYMENT RECEIVED/PAID IS NOT EMPTY

                        //HOLD VARIABLES FOR UPDATING VARIOUS EXISTING CONTACT CREDIT/DEBIT MEMO FOR THE CONTACT
                        if($contactDefaultCreditBal > $contactCurrCreditBal){   //IF DEFAULT CREDIT BALANCE IS GREATER THAN CURRENT CREDIT BALANCE
                            if(!in_array($contactId,$contactCreditBalArr)){
                                $contactCreditBalArr[$contactId] = [$contactDefaultCreditBal,$contactCurrCreditBal,$contactData->currency->code];
                            }
                        }

                        $inflowOutflowDbData['balance_trans'] = $balanceTrans;
                        $inflowOutflowDbData['balance'] = Utility::convertAmountToDate($contactData->currency->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($balanceTrans, 0), $postingDate);;
                        $inflowOutflowDbData['balance_paid_trans'] = $balancePaidTrans;
                        $inflowOutflowDbData['balance_paid'] = Utility::convertAmountToDate($contactData->currency->code, Utility::currencyArrayItem('code'), $balancePaidTrans, $postingDate);
                        $inflowOutflowData['updated_by'] = Auth::user()->id;
                        //IF BALANCE IS COMPLETE CONVERT STATUS TO ZERO BALANCE INACTIVE
                        if(($dbData->balance_paid_trans+$request->input('curr_total'.$i)) == $request->input('default_total'.$i)){
                            $inflowOutflowDbData['balance_status'] = Utility::ZERO;
                            $inflowOutflowDbData['journal_status'] = Utility::OPEN_ACCOUNT_STATUS;
                        }

                        //UPDATE THE EXISTING BALANCES OF THE TRANSACTION
                        JournalExtension::defaultUpdate('id', $request->input('journal_id' . $i), $inflowOutflowDbData);

                        //JOURNAL EXTENSION TRANSACTIONS
                        $contactType = ($transactionType == self::invoicePaymentReceipt) ? Utility::CUSTOMER : Utility::VENDOR;
                        $contactData = VendorCustomer::firstRow('id',$contactId);
                        $currCode = $contactData->currency->code;
                        $currId = $contactData->currency_id;
                        $employeeId = '';
                        $latestExRate = self::latestExchangeRate();
                        
                        $uid = Utility::generateUID('journal_extention');

                        $virtualObj = new \stdClass();
                        $virtualObj->uid = $uid;
                        $virtualObj->contact = $contactId;
                        $virtualObj->contactType = $contactType;
                        $virtualObj->currId = $contactData->currency_id;
                        $virtualObj->currCode = $contactData->currency->code;
                        $virtualObj->employeeId = $employeeId;
                        $virtualObj->transactionType = $transactionType;
                        $virtualObj->creditTransactionType = $creditTransactionType;
                        $virtualObj->transactionClass = $dbData->class_id;
                        $virtualObj->location = $dbData->location_id;
                        $virtualObj->postDate = Utility::standardDate($postingDate);
                        $virtualObj->reconcileId = '';
                        $virtualObj->reconcileArr = [];
                        $virtualObj->reconcileStatus = self::uncleared;
                        $virtualObj->finYear = self::defaultFinYearObj()->id;      
                        $virtualObj->cashStatus = Utility::STATUS_ACTIVE;

                        //CREATE JOURNAL ENTRY FOR THE TRANSACTION
                        $extData = [
                        'uid' => $uid,
                        'file_no' => $fileNo,
                        'transaction_format' => $paymentMethod,
                        'reference_no' => $invoiceBillFileNo, //FILE/REF NO OF INVOICE/BILL FOR PAYMENT
                        'journal_id' => $invoiceBillId, //ID OF INVOICE/BILL FOR PAYMENT
                        'sum_total' => Utility::convertAmountToDate($contactData->currency->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('curr_total' . $i), 0), $postingDate),
                        'trans_total' =>  $request->input('curr_total' . $i),                    
                        'balance_status' => Utility::ZERO,           
                        'default_curr' => Utility::currencyArrayItem('id'),
                        'trans_curr' => $virtualObj->currId,
                        'vendor_customer' => $virtualObj->contact,
                        'post_date' => Utility::standardDate($postingDate),
                        'ex_rate' => $latestExRate->rates,
                        'fin_year' => $virtualObj->finYear,
                        'journal_status' => Utility::CLOSED_ACCOUNT_STATUS,
                        'transaction_type' => $virtualObj->transactionType,
                        'contact_type' => $virtualObj->contactType,
                        'class_id' => $virtualObj->transactionClass,
                        'location_id' => $virtualObj->location,
                        'attachment' => json_encode($attachment),   
                        'print_status' => $request->input('print_status'),
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE,
                        'cash_status' => $virtualObj->cashStatus
                    ];

                    $createJournal = JournalExtension::create($extData);
                    $virtualObj->journalId = $createJournal->id;

                    if($transactionType == self::invoicePaymentReceipt){

                        //DEBIT ACCOUNTS
                        $virtualObj->cashReceived = $request->input('curr_total' . $i);
                        $virtualObj->discountAllowed = 0;    //SEE AUTO DISCOUNT METHOD/FUNCTION FOR FURTHER EXPLANATION

                        //DEBIT ACCOUNT TYPE
                        $virtualObj->cashReceiptAccount = Utility::DEBIT_TABLE_ID;
                        $virtualObj->discountAllowedAccount = Utility::DEBIT_TABLE_ID; //SEE AUTO DISCOUNT METHOD FOR FURTHER EXPLANATION

                        //CREDIT ACCOUNTS
                        $virtualObj->accountReceivable =  $request->input('curr_total' . $i); //CANT BE ZERO, TO BE OBTAINED FROM EACH TOTAL SUM IN A LOOP
                        $virtualObj->tax = 0;

                        //CREDIT ACCOUNT TYPE
                        $virtualObj->accountReceivableAccount = Utility::CREDIT_TABLE_ID;
                        $virtualObj->taxAccount = Utility::CREDIT_TABLE_ID;

                        $defaultTransactionAccount = self::defaultTransactionAccounts();
                       
                        //DEBIT CASH
                        self::virtualTransaction($receiptAccount,$request,$virtualObj,$virtualObj->cashReceived,$virtualObj->cashReceiptAccount);

                        //CREDIT ACCOUNT RECEIVABLE
                        self::virtualTransaction($defaultTransactionAccount->default_account_receivable,$request,$virtualObj,$virtualObj->accountReceivable,$virtualObj->accountReceivableAccount);

                    }
                    //ENDING OF INVOICE CASH RECEIPT PAYMENT TRANSACTION

                    if($transactionType == self::existingBillCashPayment){

                       
                        //DEBIT ACCOUNTS
                        $virtualObj->accountPayable =  $request->input('curr_total' . $i); //CANT BE ZERO
                        $virtualObj->tax = 0;

                        //DEBIT ACCOUNT TYPE
                        $virtualObj->accountPayableAccount = Utility::DEBIT_TABLE_ID;
                        $virtualObj->taxAccount = Utility::DEBIT_TABLE_ID;

                         //CREDIT ACCOUNTS
                         $virtualObj->cashPaid = $request->input('curr_total' . $i);
                         $virtualObj->discountReceived = 0;    //SEE AUTO DISCOUNT METHOD/FUNCTION FOR FURTHER EXPLANATION
                         $virtualObj->discountInventory = 0;    //SEE AUTO DISCOUNT METHOD/FUNCTION FOR FURTHER EXPLANATION
 
                         //CREDIT ACCOUNT TYPE
                         $virtualObj->cashPaidAccount = Utility::CREDIT_TABLE_ID;
                         $virtualObj->discountReceivedAccount = Utility::CREDIT_TABLE_ID; //SEE AUTO DISCOUNT METHOD FOR FURTHER EXPLANATION
                         $virtualObj->discountInventoryAccount = Utility::CREDIT_TABLE_ID; //SEE AUTO DISCOUNT METHOD FOR FURTHER EXPLANATION

                    
                        $defaultTransactionAccount = self::defaultTransactionAccounts();    //SELECT DEFAULT TRANSACTION ACCOUNTS FOR USE
                        
                        //CREDIT CASH
                        self::virtualTransaction($paymentAccount,$request,$virtualObj,$virtualObj->cashPaid,$virtualObj->cashPaidAccount);

                        //DEBIT ACCOUNT PAYABLE
                        self::virtualTransaction($defaultTransactionAccount->default_account_payable,$request,$virtualObj,$virtualObj->accountPayable,$virtualObj->accountPayableAccount);

                    }
                    //END OF EXISTING BILL CASH PAYMENT

                }

            }
            
                //UPDATE VARIOUS EXISTING CREDITS (BY PERCENTAGE OF WHAT IS TAKEN FROM IT) FOR EACH CONTACT
                if(!empty($contactCreditBalArr)){
                    foreach($contactCreditBalArr as $key => $val){
                            $virtualObj = new \StdClass();
                            $virtualObj->currCode = $val[2];
                            $virtualObj->transactionType = $transactionType;
                            $virtualObj->contact = $key;
                            $virtualObj->creditTransactionType = $creditTransactionType;
                            self::updateCreditDebitMemoJournal($val[0],$val[1],$virtualObj);
                        }
                }

        }


    }

    public static function trialBalanceReport($query,$paramObj){

        $totalBal = 0; $dateArr = [$paramObj->from,$paramObj->to];
        foreach($query as $val){
            $reportBal = 0; $credit = 0; $debit = 0; $mainData = [];
            if(!empty($paramObj->class) && !empty($paramObj->location)){
                $mainData = AccountJournal::specialColumnsDate4('fin_year',$paramObj->finYear,'chart_id',$val->id,'class_id',$paramObj->class,'location_id',$paramObj->location,$dateArr);
            }
            if(!empty($paramObj->class) && empty($paramObj->location)){
                $mainData = AccountJournal::specialColumnsDate3('fin_year',$paramObj->finYear,'chart_id',$val->id,'class_id',$paramObj->class,$dateArr);
            }
            if(empty($paramObj->class) && !empty($paramObj->location)){
                $mainData = AccountJournal::specialColumnsDate3('fin_year',$paramObj->finYear,'chart_id',$val->id,'location_id',$paramObj->location,$dateArr);
            }
            if(empty($paramObj->class) && empty($paramObj->location)){
                $mainData = AccountJournal::specialColumnsDate2('fin_year',$paramObj->finYear,'chart_id',$val->id,$dateArr);
            }
            //Log::info($mainData);
            //IN THE ACCOUNT JOURNAL TABLE GET TOTAL OF CREDITS AND DEBITS FOR EACH ACCOUNT CHART 
            if(!empty($mainData)){
                foreach($mainData as $value){
                    if($value->debit_credit == Utility::DEBIT_TABLE_ID){    //FOR DEBIT ACCOUNTS
                        $debit+=$value->trans_total;
                    }
                    if($value->debit_credit == Utility::CREDIT_TABLE_ID){   //FOR CREDIT ACCOUNTS
                        $credit+=$value->trans_total;
                    }

                }
            }

            //FOR CREDIT ACCOUNTS GET TOTAL FOR THE PARTICULAR ACOUNT CHART
            if(in_array($val->acct_cat_id,Utility::CREDIT_ACCOUNTS)){
                $reportBal = $credit - $debit;
                $totalBal+=$reportBal;
            }
            //FOR DEBIT ACCOUNTS GET TOTAL FOR THE PARTICULAR ACCOUNT CHART
            if(in_array($val->acct_cat_id,Utility::DEBIT_ACCOUNTS)){
                $reportBal = $debit - $credit;
                $totalBal+=$reportBal;
            }

            $val->reportBal = Utility::roundNum($reportBal);

        }

        //TOTAL BALANCE FOR QUERY LIKE ASSET, EQUITY OR LIABILITY
        $query->totalBal = Utility::roundNum($totalBal);

    }

    public static function balanceSheetReport($query,$paramObj){

        $totalBal = 0; $dateArr = [$paramObj->from,$paramObj->to];
        foreach($query as $val){
            $reportBal = 0; $credit = 0; $debit = 0; $mainData = [];
            
            if($paramObj->accountBasis == Utility::ZERO){
                if(!empty($paramObj->class) && !empty($paramObj->location)){
                    $mainData = AccountJournal::specialColumnsDate4('fin_year',$paramObj->finYear,'chart_id',$val->id,'class_id',$paramObj->class,'location_id',$paramObj->location,$dateArr);
                }
                if(!empty($paramObj->class) && empty($paramObj->location)){
                    $mainData = AccountJournal::specialColumnsDate3('fin_year',$paramObj->finYear,'chart_id',$val->id,'class_id',$paramObj->class,$dateArr);
                }
                if(empty($paramObj->class) && !empty($paramObj->location)){
                    $mainData = AccountJournal::specialColumnsDate3('fin_year',$paramObj->finYear,'chart_id',$val->id,'location_id',$paramObj->location,$dateArr);
                }
                if(empty($paramObj->class) && empty($paramObj->location)){
                    $mainData = AccountJournal::specialColumnsDate2('fin_year',$paramObj->finYear,'chart_id',$val->id,$dateArr);
                }
            }

            if($paramObj->accountBasis == Utility::STATUS_ACTIVE){
                if(!empty($paramObj->class) && !empty($paramObj->location)){
                    $mainData = AccountJournal::specialColumnsDate5('fin_year',$paramObj->finYear,'chart_id',$val->id,'class_id',$paramObj->class,'location_id',$paramObj->location,'cash_status',$paramObj->accountBasis,$dateArr);
                }
                if(!empty($paramObj->class) && empty($paramObj->location)){
                    $mainData = AccountJournal::specialColumnsDate4('fin_year',$paramObj->finYear,'chart_id',$val->id,'class_id',$paramObj->class,'cash_status',$paramObj->accountBasis,$dateArr);
                }
                if(empty($paramObj->class) && !empty($paramObj->location)){
                    $mainData = AccountJournal::specialColumnsDate4('fin_year',$paramObj->finYear,'chart_id',$val->id,'location_id','cash_status',$paramObj->accountBasis,$paramObj->location,$dateArr);
                }
                if(empty($paramObj->class) && empty($paramObj->location)){
                    $mainData = AccountJournal::specialColumnsDate3('fin_year',$paramObj->finYear,'chart_id',$val->id,'cash_status',$paramObj->accountBasis,$dateArr);
                }
            }
            
            //IN THE ACCOUNT JOURNAL TABLE GET TOTAL OF CREDITS AND DEBITS FOR EACH ACCOUNT CHART 
            if(!empty($mainData)){
                foreach($mainData as $value){
                    if($value->debit_credit == Utility::DEBIT_TABLE_ID){    //FOR DEBIT ACCOUNTS
                        $debit+=$value->trans_total;
                    }
                    if($value->debit_credit == Utility::CREDIT_TABLE_ID){   //FOR CREDIT ACCOUNTS
                        $credit+=$value->trans_total;
                    }

                }
            }

            //FOR CREDIT ACCOUNTS GET TOTAL FOR THE PARTICULAR ACOUNT CHART
            if(in_array($val->acct_cat_id,Utility::CREDIT_ACCOUNTS)){
                $reportBal = $credit - $debit;
                $totalBal+=$reportBal;
            }
            //FOR DEBIT ACCOUNTS GET TOTAL FOR THE PARTICULAR ACCOUNT CHART
            if(in_array($val->acct_cat_id,Utility::DEBIT_ACCOUNTS)){
                $reportBal = $debit - $credit;
                $totalBal+=$reportBal;
            }

            $val->reportBal = Utility::roundNum($reportBal);

        }

        //TOTAL BALANCE FOR QUERY LIKE ASSET, EQUITY OR LIABILITY
        $query->totalBal = Utility::roundNum($totalBal);

    }

    public static function incomeStatementReport($query,$paramObj){

        $totalBal = 0;   $dateArr = [$paramObj->from,$paramObj->to];
        foreach($query as $val){
            $reportBal = 0; $credit = 0; $debit = 0; $mainData = [];
            
            if($paramObj->accountBasis == Utility::ZERO){ //ACCRUAL BASIS OF ACCOUNTING PROFIT AND LOSS
                if(!empty($paramObj->class) && !empty($paramObj->location)){
                    $mainData = AccountJournal::specialColumnsDateTransaction4('fin_year',$paramObj->finYear,'chart_id',$val->id,'class_id',$paramObj->class,'location_id',$paramObj->location,$dateArr);
                }
                if(!empty($paramObj->class) && empty($paramObj->location)){
                    $mainData = AccountJournal::specialColumnsDateTransaction3('fin_year',$paramObj->finYear,'chart_id',$val->id,'class_id',$paramObj->class,$dateArr);
                }
                if(empty($paramObj->class) && !empty($paramObj->location)){
                    $mainData = AccountJournal::specialColumnsDateTransaction3('fin_year',$paramObj->finYear,'chart_id',$val->id,'location_id',$paramObj->location,$dateArr);
                }
                if(empty($paramObj->class) && empty($paramObj->location)){
                    $mainData = AccountJournal::specialColumnsDateTransaction2('fin_year',$paramObj->finYear,'chart_id',$val->id,$dateArr);
                }
            }

            if($paramObj->accountBasis == Utility::STATUS_ACTIVE){    //CASH BASIS OF ACCOUNTING PROFIT AND LOSS
                if(!empty($paramObj->class) && !empty($paramObj->location)){
                    $mainData = AccountJournal::specialColumnsDateTransaction5('fin_year',$paramObj->finYear,'chart_id',$val->id,'class_id',$paramObj->class,'location_id',$paramObj->location,'cash_status',$paramObj->accountBasis,$dateArr);
                }
                if(!empty($paramObj->class) && empty($paramObj->location)){
                    $mainData = AccountJournal::specialColumnsDateTransaction4('fin_year',$paramObj->finYear,'chart_id',$val->id,'class_id',$paramObj->class,'cash_status',$paramObj->accountBasis,$dateArr);
                }
                if(empty($paramObj->class) && !empty($paramObj->location)){
                    $mainData = AccountJournal::specialColumnsDateTransaction4('fin_year',$paramObj->finYear,'chart_id',$val->id,'location_id',$paramObj->location,'cash_status',$paramObj->accountBasis,$dateArr);
                }
                if(empty($paramObj->class) && empty($paramObj->location)){
                    $mainData = AccountJournal::specialColumnsDateTransaction3('fin_year',$paramObj->finYear,'chart_id',$val->id,'cash_status',$paramObj->accountBasis,$dateArr);
                }
            }
            
            
            //IN THE ACCOUNT JOURNAL TABLE GET TOTAL OF CREDITS AND DEBITS FOR EACH ACCOUNT CHART 
            if(!empty($mainData)){
                foreach($mainData as $value){

                    if($value->debit_credit == Utility::DEBIT_TABLE_ID){    //FOR DEBIT ACCOUNTS                       
                            $debit+=$value->trans_total;                                             
                    }

                    if($value->debit_credit == Utility::CREDIT_TABLE_ID){   //FOR CREDIT ACCOUNTS                       
                                $credit+=$value->trans_total; 
                    }

                }
            }
            
            //FOR CREDIT ACCOUNTS GET TOTAL FOR THE PARTICULAR ACOUNT CHART
            if(in_array($val->acct_cat_id,Utility::CREDIT_ACCOUNTS)){
                $reportBal = $credit - $debit;
                $totalBal+=$reportBal;
            }
            //FOR DEBIT ACCOUNTS GET TOTAL FOR THE PARTICULAR ACCOUNT CHART
            if(in_array($val->acct_cat_id,Utility::DEBIT_ACCOUNTS)){
                $reportBal = $debit - $credit;
                $totalBal+=$reportBal;
            }
            //Log::info($credit.'debit='.$debit);
            $val->reportBal = $reportBal;

        }

        //TOTAL BALANCE FOR QUERY 
        $query->totalBal = $totalBal;

    }

    public static function contactAccountInventoryReport($request){
        $from = Utility::standardDate($request->input('from_date')); $to = Utility::standardDate($request->input('to_date'));
        $finYear = $request->input('financial_year');  $accountBasis = $request->input('account_basis');
        $class = $request->input('class');  $location = $request->input('location');
        $contact = $request->input('contact'); $reportType = $request->input('report_type');
        $totalBal = 0;   $dateArr = [$from,$to];  $contactType = $request->input('contact_type');
        $accountStatus = $accountBasis;

            $mainData = [];

            if($reportType == self::accountReport){
                $accountId = $request->input('account');
                
                if($accountStatus == Utility::ZERO){
                    if(!empty($class) && !empty($location)){
                        $mainData = AccountJournal::specialColumnsDateTransaction5('fin_year',$finYear,'vendor_customer',$contact,'chart_id',$accountId,'class_id',$class,'location_id',$location,$dateArr);
                    }
                    if(!empty($class) && empty($location)){
                        $mainData = AccountJournal::specialColumnsDateTransaction4('fin_year',$finYear,'vendor_customer',$contact,'chart_id',$accountId,'class_id',$class,$dateArr);
                    }
                    if(empty($class) && !empty($location)){
                        $mainData = AccountJournal::specialColumnsDateTransaction4('fin_year',$finYear,'vendor_customer',$contact,'chart_id',$accountId,'location_id',$location,$dateArr);
                    }
                    if(empty($class) && empty($location)){
                        $mainData = AccountJournal::specialColumnsDateTransaction3('fin_year',$finYear,'vendor_customer',$contact,'chart_id',$accountId,$dateArr);
                    }
                }

                if($accountStatus == Utility::STATUS_ACTIVE){
                    if(!empty($class) && !empty($location)){
                        $mainData = AccountJournal::specialColumnsDateTransaction6('fin_year',$finYear,'vendor_customer',$contact,'chart_id',$accountId,'class_id',$class,'location_id',$location,'cash_status',$accountStatus,$dateArr);
                    }
                    if(!empty($class) && empty($location)){
                        $mainData = AccountJournal::specialColumnsDateTransaction5('fin_year',$finYear,'vendor_customer',$contact,'chart_id',$accountId,'class_id',$class,'cash_status',$accountStatus,$dateArr);
                    }
                    if(empty($class) && !empty($location)){
                        $mainData = AccountJournal::specialColumnsDateTransaction5('fin_year',$finYear,'vendor_customer',$contact,'chart_id',$accountId,'location_id',$location,'cash_status',$accountStatus,$dateArr);
                    }
                    if(empty($class) && empty($location)){
                        $mainData = AccountJournal::specialColumnsDateTransaction4('fin_year',$finYear,'vendor_customer',$contact,'chart_id',$accountId,'cash_status',$accountStatus,$dateArr);
                    }
                }

            }

            if($reportType == self::inventoryReport){
                $itemId = $request->input('inventory');    

                if($accountStatus == Utility::ZERO){
                    if(!empty($class) && !empty($location)){
                        $mainData = AccountJournal::specialColumnsDateTransaction5('fin_year',$finYear,'vendor_customer',$contact,'item_id',$itemId,'class_id',$class,'location_id',$location,$dateArr);
                    }
                    if(!empty($class) && empty($location)){
                        $mainData = AccountJournal::specialColumnsDateTransaction4('fin_year',$finYear,'vendor_customer',$contact,'item_id',$itemId,'class_id',$class,$dateArr);
                    }
                    if(empty($class) && !empty($location)){
                        $mainData = AccountJournal::specialColumnsDateTransaction4('fin_year',$finYear,'vendor_customer',$contact,'item_id',$itemId,'location_id',$location,$dateArr);
                    }
                    if(empty($class) && empty($location)){
                        $mainData = AccountJournal::specialColumnsDateTransaction3('fin_year',$finYear,'vendor_customer',$contact,'item_id',$itemId,$dateArr);
                    }
                }

                if($accountStatus == Utility::STATUS_ACTIVE){
                    if(!empty($class) && !empty($location)){
                        $mainData = AccountJournal::specialColumnsDateTransaction6('fin_year',$finYear,'vendor_customer',$contact,'item_id',$itemId,'class_id',$class,'location_id',$location,'cash_status',$accountStatus,$dateArr);
                    }
                    if(!empty($class) && empty($location)){
                        $mainData = AccountJournal::specialColumnsDateTransaction5('fin_year',$finYear,'vendor_customer',$contact,'item_id',$itemId,'class_id',$class,'cash_status',$accountStatus,$dateArr);
                    }
                    if(empty($class) && !empty($location)){
                        $mainData = AccountJournal::specialColumnsDateTransaction5('fin_year',$finYear,'vendor_customer',$contact,'item_id',$itemId,'location_id',$location,'cash_status',$accountStatus,$dateArr);
                    }
                    if(empty($class) && empty($location)){
                        $mainData = AccountJournal::specialColumnsDateTransaction4('fin_year',$finYear,'vendor_customer',$contact,'item_id',$itemId,'cash_status',$accountStatus,$dateArr);
                    }
                }

            }
            
        //IN THE ACCOUNT JOURNAL TABLE GET TOTAL OF CREDITS AND DEBITS FOR EACH ACCOUNT CHART 
        $totalDebit = 0; $totalCredit = 0; $accountCategoryId = 0;
        if(!empty($mainData)){
            foreach($mainData as $value){
                $accountCategoryId = $value->acct_cat_id;
                if($value->debit_credit == Utility::DEBIT_TABLE_ID){    //FOR DEBIT ACCOUNTS                   
                        $totalDebit+=$value->trans_total;
                }

                if($value->debit_credit == Utility::CREDIT_TABLE_ID){    //FOR DEBIT ACCOUNTS
                          $totalCredit+=$value->trans_total;                  
                }
                
            }
        }
       
        if(in_array($accountCategoryId,Utility::DEBIT_ACCOUNTS)){
            $totalBal = $totalDebit - $totalCredit;
        }
        if(in_array($accountCategoryId,Utility::CREDIT_ACCOUNTS)){
            $totalBal = $totalCredit - $totalDebit;
        }
           
            if(!empty($mainData)){
            $mainData->totalBal = $totalBal;    //TOTAL BALANCE FOR QUERY 
            }

            return $mainData;

    }

    public static function contactTransactionReport($request){
        $from = Utility::standardDate($request->input('from_date')); $to = Utility::standardDate($request->input('to_date'));
        $finYear = $request->input('financial_year');  $transactionType = $request->input('transaction_type');
        $class = $request->input('class');  $location = $request->input('location');
        $contact = $request->input('contact'); $reportType = $request->input('report_type');
        $totalBal = 0;   $dateArr = [$from,$to];  $contactType = $request->input('contact_type');

            $mainData = [];

            if(empty($contact)){    //IF NO CONTACT IS SELECTED RUN THE CODE BELOW

                if($reportType == self::transactionReport){
                    
                    if(!empty($class) && !empty($location)){
                        $mainData = JournalExtension::specialColumnsDateTransaction4('fin_year',$finYear,'class_id',$class,'location_id',$location,'transaction_type',$transactionType,$dateArr);
                    }
                    if(!empty($class) && empty($location)){
                        $mainData = JournalExtension::specialColumnsDateTransaction3('fin_year',$finYear,'class_id',$class,'transaction_type',$transactionType,$dateArr);
                    }
                    if(empty($class) && !empty($location)){
                        $mainData = JournalExtension::specialColumnsDateTransaction3('fin_year',$finYear,'location_id',$location,'transaction_type',$transactionType,$dateArr);
                    }
                    if(empty($class) && empty($location)){
                        $mainData = JournalExtension::specialColumnsDateTransaction2('fin_year',$finYear,'transaction_type',$transactionType,$dateArr);
                    }

                }



            }

            if(!empty($contact)){    //IF CONTACT IS SELECTED RUN THE CODE BELOW
                
                if($reportType == self::transactionReport){
                    
                    if(!empty($class) && !empty($location)){
                        $mainData = JournalExtension::specialColumnsDateTransaction5('fin_year',$finYear,'vendor_customer',$contact,'class_id',$class,'location_id',$location,'transaction_type',$transactionType,$dateArr);
                    }
                    if(!empty($class) && empty($location)){
                        $mainData = JournalExtension::specialColumnsDateTransaction4('fin_year',$finYear,'vendor_customer',$contact,'class_id',$class,'transaction_type',$transactionType,$dateArr);
                    }
                    if(empty($class) && !empty($location)){
                        $mainData = JournalExtension::specialColumnsDateTransaction4('fin_year',$finYear,'vendor_customer',$contact,'location_id',$location,'transaction_type',$transactionType,$dateArr);
                    }
                    if(empty($class) && empty($location)){
                        $mainData = JournalExtension::specialColumnsDateTransaction3('fin_year',$finYear,'vendor_customer',$contact,'transaction_type',$transactionType,$dateArr);
                    }

                }



            }

            if(!empty($mainData)){      
            $mainData->chartData = self::arrangeMonthMainJournal($mainData,$from,$to); //ARRAY FOR BAR,PIE CHART ETC.         
            
            foreach($mainData as $val){
                $totalBal+= $val->trans_total;
            }
            $mainData->totalBal = $totalBal;    //TOTAL BALANCE FOR QUERY 
            }

            return $mainData;

    }

    public static function arrangeMonthMainJournal($query,$start,$end){
        $startDate = Utility::standardDate($start);
        $endDate = Utility::standardDate($end);
        $startYear =  date('Y',strtotime($startDate));
        $endYear = date('Y',strtotime($endDate));
            $monthYear = [];
            for($y=$startYear;$y<=$endYear;$y++){   //LOOP THROUGH THE STARTING YEAR TO ENDING YEAR
                for($m=1;$m<=12;$m++){  //LOOP THROUGH THE MONTHS IN THE YEAR
                    $monthName = date("F", mktime(0, 0, 0, $m, 10));
                    $calcMonthAmtArray = [];
                    foreach($query as $val){    //LOOP THROUGH EACH DATA TO CHECKMATE THE ONE THAT FALLS INTO THE MONTH OF YEAR IN THE LOOP

                        $stdDate = Utility::standardDate($val->post_date);
                        $getM = date('m',strtotime($stdDate)); $getY = date('Y',strtotime($stdDate));
                        if($getM == $m && $getY == $y){
                            
                          $calcMonthAmtArray[] = $val->trans_total;
                          
                        }

                    }
                    $monthYear[$monthName.'-'.$y] = array_sum($calcMonthAmtArray);

                }
            }
            return $monthYear;

    }

    public static function openInvoiceReport($request){
        
        $finYear = $request->input('financial_year');  $contact = $request->input('contact');  
        $contactType = $request->input('contact_type'); $totalBal = 0;
        $from = Utility::standardDate($request->input('from_date')); $to = Utility::standardDate($request->input('to_date')); $dateArr = [$from,$to];

            $mainData = [];

        if(!empty($contact) && !empty($finYear)){
            $mainData = JournalExtension::specialColumnsDateTransaction4('fin_year',$finYear,'vendor_customer',$contact,'transaction_type',self::invoice,'journal_status',Utility::OPEN_ACCOUNT_STATUS,$dateArr);
        }
        if(empty($contact) && !empty($finYear)){
            $mainData = JournalExtension::specialColumnsDateTransaction3('fin_year',$finYear,'transaction_type',self::invoice,'journal_status',Utility::OPEN_ACCOUNT_STATUS,$dateArr);
        }
        
        if(!empty($mainData)){
            foreach($mainData as $value){
                $totalBal+=$value->trans_total;                
            }
        }

        if(!empty($mainData)){
        $mainData->chartData = self::arrangeMonthMainJournal($mainData,$from,$to);
        $mainData->totalBal = $totalBal;
        }
        Log::Info($mainData);
        return $mainData;

    }

    public static function openBillReport($request){
        
        $finYear = $request->input('financial_year');  $contact = $request->input('contact');  
        $contactType = $request->input('contact_type'); $totalBal = 0;
        $from = Utility::standardDate($request->input('from_date')); $to = Utility::standardDate($request->input('to_date')); $dateArr = [$from,$to];

            $mainData = [];

        if(!empty($contact) && !empty($finYear)){
            $mainData = JournalExtension::specialColumnsDateTransaction4('fin_year',$finYear,'vendor_customer',$contact,'transaction_type',self::bill,'journal_status',Utility::OPEN_ACCOUNT_STATUS,$dateArr);
        }
        if(empty($contact) && !empty($finYear)){
            $mainData = JournalExtension::specialColumnsDateTransaction3('fin_year',$finYear,'transaction_type',self::bill,'journal_status',Utility::OPEN_ACCOUNT_STATUS,$dateArr);
        }
       
        if(!empty($mainData)){
            foreach($mainData as $value){
                $totalBal+=$value->trans_total;                
            }
        }

        if(!empty($mainData)){
        $mainData->chartData = self::arrangeMonthMainJournal($mainData,$from,$to);
        $mainData->totalBal = $totalBal;
        }
        
        return $mainData;

    }

    public static function overdueBillReport($request){

        $finYear = $request->input('financial_year');  $contact = $request->input('contact');  
        $contactType = $request->input('contact_type'); $totalBal = 0;  $today = date('Y-m-d');

            $mainData = [];

        if(!empty($contact) && !empty($finYear)){
            $mainData = JournalExtension::specialColumnsDate4('fin_year',$finYear,'vendor_customer',$contact,'transaction_type',self::bill,'journal_status',Utility::OPEN_ACCOUNT_STATUS,$today);
        }
        if(!empty($contact) && empty($finYear)){
            $mainData = JournalExtension::specialColumnsDate3('vendor_customer',$contact,'transaction_type',self::bill,'journal_status',Utility::OPEN_ACCOUNT_STATUS,$today);
        }
        if(empty($contact) && !empty($finYear)){
            $mainData = JournalExtension::specialColumnsDate3('fin_year',$finYear,'transaction_type',self::bill,'journal_status',Utility::OPEN_ACCOUNT_STATUS,$today);
        }
        if(empty($contact) && empty($finYear)){
            $mainData = JournalExtension::specialColumnsDate2('transaction_type',self::bill,'journal_status',Utility::OPEN_ACCOUNT_STATUS,$today);
        }

        if(!empty($mainData)){
            foreach($mainData as $value){
                    $totalBal+=$value->trans_total;
                    $value->daysOverdue = Utility::getDaysLength($value->due_date,date('Y-m-d'));
               
            }
        }
        
        if(!empty($mainData)){
            $mainData->totalBal = $totalBal;
        }

        return $mainData;

    }

    public static function overdueInvoiceReport($request){

        $finYear = $request->input('financial_year');  $contact = $request->input('contact');  
        $contactType = $request->input('contact_type'); $totalBal = 0;  $today = date('Y-m-d');

            $mainData = [];

        if(!empty($contact) && !empty($finYear)){
            $mainData = JournalExtension::specialColumnsDate4('fin_year',$finYear,'vendor_customer',$contact,'transaction_type',self::invoice,'journal_status',Utility::OPEN_ACCOUNT_STATUS,$today);
        }
        if(!empty($contact) && empty($finYear)){
            $mainData = JournalExtension::specialColumnsDate3('vendor_customer',$contact,'transaction_type',self::invoice,'journal_status',Utility::OPEN_ACCOUNT_STATUS,$today);
        }
        if(empty($contact) && !empty($finYear)){
            $mainData = JournalExtension::specialColumnsDate3('fin_year',$finYear,'transaction_type',self::invoice,'journal_status',Utility::OPEN_ACCOUNT_STATUS,$today);
        }
        if(empty($contact) && empty($finYear)){
            $mainData = JournalExtension::specialColumnsDate2('transaction_type',self::invoice,'journal_status',Utility::OPEN_ACCOUNT_STATUS,$today);
        }

        if(!empty($mainData)){
            foreach($mainData as $value){
                    $totalBal+=$value->trans_total;
                    $value->daysOverdue = Utility::getDaysLength($value->due_date,date('Y-m-d'));
               
            }
        }
        
        if(!empty($mainData)){
            $mainData->totalBal = $totalBal;
        }

        return $mainData;

    }

    public static function destroyJournalTransaction($request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        
        foreach($idArray as $data){

            $closing = Utility::firstRow('closing_books','active_status',Utility::STATUS_ACTIVE);
            $journalExt = JournalExtension::firstRow('id',$data);
            if(!empty($closing)){    //FOR ANY CLOSING OF BOOKS DATA IS ACTIVE                
                $postDate = $journalExt->post_date;
                $dataChild = AccountJournal::specialColumns('extension_id',$data);  //FETCH INDIVIDUAL ITEMS FROM TRANSACTION
                if(!empty($dataChild)){
                    foreach($dataChild as $item){
                        $postDate = $item->post_date;
                        if(Utility::standardDate($closing->closing_date) <= $item->post_date){  //ENSURE THE BOOKS CLOSING DATE IS LESS THAN TRANSACTION DATE
                        $accountType = ($item->debit_credit == Utility::CREDIT_TABLE_ID) ? Utility::DEBIT_TABLE_ID : Utility::CREDIT_TABLE_ID;  //CREDIT WILL BECOME DEBIT AND VICE-VERSA
                        Utility::updateAccountBalance($item->chart_id,$item->trans_total,$accountType); //UPDATE ACCOUNT BALANCE TO INITIAL BALANCE                
                        
                        $delete = AccountJournal::destroy($item->id);   //REMOVE ALL CHILD TRANSACTIONS FROM LEDGER
                        }

                    }
                }
                if(Utility::standardDate($closing->closing_date) <= $postDate){  //ENSURE THE BOOKS CLOSING DATE IS LESS THAN TRANSACTION DATE
                    $delete = JournalExtension::destroy($data); //REMOVE MAIN TRANSACTION
                }

            }else{  //START DELETE WHEN CLOSING BOOK IS INACTIVE OR DOES NOT EXIST

                $dataChild = AccountJournal::specialColumns('extension_id',$data);
                if(!empty($dataChild)){
                    foreach($dataChild as $item){
                        $accountType = ($item->debit_credit == Utility::CREDIT_TABLE_ID) ? Utility::DEBIT_TABLE_ID : Utility::CREDIT_TABLE_ID;  //CREDIT WILL BECOME DEBIT AND VICE-VERSA
                        Utility::updateAccountBalance($item->chart_id,$item->trans_total,$accountType); //UPDATE ACCOUNT BALANCE TO INITIAL BALANCE                
                        
                        $delete = AccountJournal::destroy($item->id);   //REMOVE ALL CHILD TRANSACTIONS FROM LEDGER
                    }
                }
                $delete = JournalExtension::destroy($data); //REMOVE MAIN TRANSACTION
            }
            
        }

        exit(
                json_encode([
                'message2' => 'Data deleted successfully',
                'message' => 'deleted'
                ])
            );

    }

    public static function addBalanceToObj($obj){
        foreach($obj as $data){
            $dbData = JournalExtension::where('id',$data->journal_id)->first(['balance','balance_trans']);
            $data->open_balance_trans = $dbData->balance_trans;
            $data->open_balance = $dbData->balance;
        }
    }

}