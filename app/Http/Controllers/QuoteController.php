<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Helpers\Notify;
use App\model\Currency;
use App\model\Inventory;
use App\model\QuoteExtension;
use App\model\Quote;
use App\model\Stock;
use App\model\VendorCustomer;
use App\model\Warehouse;
use App\model\Tax;
use App\model\WarehouseEmployee;
use App\model\WarehouseReceipt;
use App\model\WhsePickPutAway;
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

class QuoteController extends Controller
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
        $mainData = QuoteExtension::specialColumnsPage('created_by',Auth::user()->id);

        if ($request->ajax()) {
            return \Response::json(view::make('quote.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('quote.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),Quote::$mainRules);

        if($validator->passes()){


            //ITEM VARIABLES
            $invClass = Utility::jsonUrlDecode($request->input('inv_class'));
            $itemDesc = Utility::jsonUrlDecode($request->input('item_desc'));
            $quantity = Utility::jsonUrlDecode($request->input('quantity'));
            $unitCost = Utility::jsonUrlDecode($request->input('unit_cost'));
            $unitMeasure = Utility::jsonUrlDecode($request->input('unit_measure'));
            $tax = Utility::jsonUrlDecode($request->input('tax'));
            $taxPerct = Utility::jsonUrlDecode($request->input('tax_perct'));
            $taxAmount = Utility::jsonUrlDecode($request->input('tax_amount'));
            $discountPerct = Utility::jsonUrlDecode($request->input('discount_perct'));
            $discountAmount = Utility::jsonUrlDecode($request->input('discount_amount'));
            $subTotal = Utility::jsonUrlDecode($request->input('sub_total'));

            //ACCOUNT VARIABLES
            $accClass = Utility::jsonUrlDecode($request->input('acc_class')); $accDesc = Utility::jsonUrlDecode($request->input('acc_desc'));
            $accRate = Utility::jsonUrlDecode($request->input('acct_rate')); $accTax = Utility::jsonUrlDecode($request->input('acc_tax'));
            $accTaxPerct = Utility::jsonUrlDecode($request->input('acc_tax_perct')); $accTaxAmount = Utility::jsonUrlDecode($request->input('acc_tax_amount'));
            $accDiscountPerct = Utility::jsonUrlDecode($request->input('acc_discount_perct')); $accDiscountAmount = Utility::jsonUrlDecode($request->input('acc_discount_amount'));
            $accSubTotal = Utility::jsonUrlDecode($request->input('acc_sub_total'));

            //GENERAL VARIABLES
            $postingDate = $request->input('posting_date'); $prefCustomer = $request->input('pref_customer');
            $quoteNo = $request->input('quote_number');$shipCountry = $request->input('ship_country');
            $shipCity = $request->input('ship_city'); $shipContact = $request->input('ship_contact');
            $shipAgent = $request->input('ship_agent'); $shipMethod = $request->input('ship_method');
            $shipAddress = $request->input('ship_address');
            $user = $request->input('user'); $grandTotal = $request->input('grand_total');  // THIS IS THE REAL VENDOR CURRENCY WAS NAME LIKE THS FOR SOME REASONS
            $grandTotalVendorCurr = $request->input('grand_total_vendor_curr'); //THIS IS DEFAULT CURRENCY FOR SOME REASONS WAS NAMED LIKE THIS
            $mailOption = $request->input('mail_option'); $emails = $request->input('emails'); $file = $request->input('file');
            $message = Utility::urlDecode($request->input('mail_message')); $oneTimeDiscount = $request->input('one_time_discount_amount'); $oneTimePerct = $request->input('one_time_perct');
            $oneTimeTaxAmount = $request->input('one_time_tax_amount'); $taxType = $request->input('tax_type');
            $discountType = $request->input('discount_type'); $oneTimeTaxPerct = $request->input('one_time_tax_perct');
            $mailCopy = $request->input('mail_copy'); $quoteStatus = $request->input('quote_status');

            $vendor = VendorCustomer::firstRow('id',$prefCustomer);
            $curr = Currency::firstRow('id',$vendor->currency_id);
            $files = $request->file('file');
            $attachment = [];
            $mailFiles = [];


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

            $uid = Utility::generateUID('quote_extention');

            $dbDATA = [
                'uid' => $uid,
                'assigned_user' => $user,
                'quote_number' => $quoteNo,
                'mails' => $emails,
                'mail_copy' => $mailCopy,
                'sum_total' => $grandTotal,
                'trans_total' => $grandTotalVendorCurr,
                'discount_total' => Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),$oneTimeDiscount,$postingDate),
                'discount_trans' => $oneTimeDiscount,
                'discount_perct' => $oneTimePerct,
                'discount_type' => $discountType,
                'tax_total' => Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),$oneTimeTaxAmount,$postingDate),
                'tax_trans' => $oneTimeTaxAmount,
                'tax_perct' => $oneTimeTaxPerct,
                'tax_type' => $taxType,
                'message' => $message,
                'attachment' => json_encode($attachment,true),
                'default_curr' => Utility::currencyArrayItem('id'),
                'trans_curr' => $curr->id,
                'customer' => $prefCustomer,
                'post_date' => Utility::standardDate($postingDate),
                'ship_to_city' => $shipCity,
                'ship_address' => $shipAddress,
                'ship_to_country' => $shipCountry,
                'ship_to_contact' => $shipContact,
                'ship_method' => $shipMethod,
                'ship_agent' => $shipAgent,
                'quote_status' => $quoteStatus,
                'created_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            $accDbData = [
                'uid' => $uid
            ];
            $quoteDbData = [
                'uid' => $uid
            ];


            if(count($accClass) == count($accRate) && count($invClass) == count($subTotal)) {

                $mainQuote = QuoteExtension::create($dbDATA);
                $accDbData['quote_id'] = $mainQuote->id;
                $quoteDbData['quote_id'] = $mainQuote->id;

                //LOOP THROUGH ACCOUNTS
                if(count($accClass) == count($accRate) && count($accSubTotal) == count($accClass)){
                    for($i=0;$i<count($accClass);$i++){
                        $accDbData['account_id'] = Utility::checkEmptyArrayItem($accClass,$i,0);
                        $accDbData['quote_desc'] = Utility::checkEmptyArrayItem($accDesc,$i,'');
                        $accDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($accRate,$i,0);
                        $accDbData['unit_cost'] = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($accRate,$i,0),$postingDate);
                        $accDbData['tax_id'] = Utility::checkEmptyArrayItem($accTax,$i,0);
                        $accDbData['tax_perct'] = Utility::checkEmptyArrayItem($accTaxPerct,$i,0);
                        $accDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($accTaxAmount,$i,0);
                        $accDbData['tax_amount'] = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($accTaxAmount,$i,0),$postingDate);
                        $accDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($accDiscountAmount,$i,0);
                        $accDbData['discount_amount'] = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($accDiscountAmount,$i,0),$postingDate);
                        $accDbData['discount_perct'] = Utility::checkEmptyArrayItem($accDiscountPerct,$i,0);
                        $accDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($accSubTotal,$i,0);
                        $accDbData['extended_amount'] = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($accSubTotal,$i,0),$postingDate);
                        $accDbData['status'] = Utility::STATUS_ACTIVE;
                        $accDbData['created_by'] = Auth::user()->id;

                        Quote::create($accDbData);

                    }

                }

                //LOOP THROUGH ITEMS
                if(count($invClass) == count($subTotal)){
                    for($i=0;$i<count($invClass);$i++){
                        $binStock = Inventory::firstRow('id',$invClass);
                        $quoteDbData['item_id'] = Utility::checkEmptyArrayItem($invClass,$i,0);
                        $quoteDbData['bin_stock'] = $binStock->inventory_type;
                        $quoteDbData['unit_measurement'] = Utility::checkEmptyArrayItem($unitMeasure,$i,0);
                        $quoteDbData['quantity'] = Utility::checkEmptyArrayItem($quantity,$i,0);
                        $quoteDbData['quote_desc'] = Utility::checkEmptyArrayItem($itemDesc,$i,'');
                        $quoteDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($unitCost,$i,0);
                        $quoteDbData['unit_cost'] = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($unitCost,$i,0),$postingDate);
                        $quoteDbData['tax_id'] = Utility::checkEmptyArrayItem($tax,$i,0);
                        $quoteDbData['tax_perct'] = Utility::checkEmptyArrayItem($taxPerct,$i,0);
                        $quoteDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($taxAmount,$i,0);
                        $quoteDbData['tax_amount'] = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($taxAmount,$i,0),$postingDate);
                        $quoteDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($discountAmount,$i,0);
                        $quoteDbData['discount_amount'] = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($discountAmount,$i,0),$postingDate);
                        $quoteDbData['discount_perct'] = Utility::checkEmptyArrayItem($discountPerct,$i,0);
                        $quoteDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($subTotal,$i,0);
                        $quoteDbData['extended_amount'] = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($subTotal,$i,0),$postingDate);

                        $quoteDbData['status'] = Utility::STATUS_ACTIVE;
                        $quoteDbData['created_by'] = Auth::user()->id;

                        Quote::create($quoteDbData);

                    }

                }

                /* return response()->json([
                 'message' => 'warning',
                 'message2' => json_encode($poDbData)
             ]);*/

                if($mailOption == Utility::STATUS_ACTIVE){
                    $QuoteId = $mainQuote->id;
                    $getQuote = QuoteExtension::firstRow('id',$QuoteId);
                    $getQuoteData = Quote::specialColumns('uid',$getQuote->uid);
                    $currencyData = Currency::firstRow('id',$getQuote->trans_curr);

                    $mailContent = [];

                    $mailCopyContent = ($mailCopy != '') ? explode(',',$mailCopy) : [];
                    $mailContent['copy'] = $mailCopyContent;
                    $mailContent['fromEmail']= Auth::user()->email;
                    $mailContent['quote']= $getQuote;
                    $mailContent['quoteData'] = $getQuoteData;
                    $mailContent['attachment'] = $mailFiles;
                    $mailContent['currency'] = $currencyData->code;

                    //CHECK IF MAIL IS EMPTY ELSE CONTINUE TO SEND MAIL
                    if($emails != ''){
                        $mailToArray = explode(',',$emails);
                        if(count($mailToArray) >0){ //SEND MAIL TO ALL INVOLVED IN THE QUOTE
                            foreach($mailToArray as $data) {
                                Notify::quoteMail('mail_views.quote', $mailContent, $data, Auth::user()->firstname.' '.Auth::user()->lastname, 'Purchase Order');
                            }
                        }
                    }

                }


                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

            }else{

                return response()->json([
                    'message' => 'warning',
                    'message2' => 'Please ensure that all account selected has a rate'
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
        $po = QuoteExtension::firstRow('id',$request->input('dataId'));
        $QuoteData = Quote::specialColumns('Quote_id',$po->id);
        return view::make('quote.edit_form')->with('edit',$po)->with('quoteData',$QuoteData);

    }


    public function printPreview(Request $request)
    {
        //
        $currency = Utility::defaultCurrency();
        $type = $request->input('type');
        $quote = QuoteExtension::firstRow('id',$request->input('dataId'));
        $poData = Quote::specialColumns('quote_id',$quote->id);
        Utility::fetchBOMItems($poData);
        if($type == 'vendor' && !empty($quote)){
            $data = Currency::firstRow('id',$quote->trans_curr);
            $currency = $data->code;

            return view::make('quote.print_preview_vendor')->with('po',$quote)->with('poData',$poData)
                ->with('currency',$currency);
        }
        return view::make('quote.print_preview_default')->with('po',$quote)->with('poData',$poData)
            ->with('currency',$currency);

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
        $validator = Validator::make($request->all(),Quote::$mainRules);
        if($validator->passes()){

            /*return response()->json([
                'message' => 'warning',
                'message2' =>  $request->input('count_ext_po').'&countAcc='.$request->input('count_ext_acc')
            ]);*/

            //ITEM VARIABLES
            $invClass = Utility::jsonUrlDecode($request->input('inv_class_edit'));
            $itemDesc = Utility::jsonUrlDecode($request->input('item_desc_edit'));
            $quantity = Utility::jsonUrlDecode($request->input('quantity_edit'));
            $unitCost = Utility::jsonUrlDecode($request->input('unit_cost_edit'));
            $unitMeasure = Utility::jsonUrlDecode($request->input('unit_measure_edit'));
            $tax = Utility::jsonUrlDecode($request->input('tax_edit'));
            $taxPerct = Utility::jsonUrlDecode($request->input('tax_perct_edit'));
            $taxAmount = Utility::jsonUrlDecode($request->input('tax_amount_edit'));
            $discountPerct = Utility::jsonUrlDecode($request->input('discount_perct_edit'));
            $discountAmount = Utility::jsonUrlDecode($request->input('discount_amount_edit'));
            $subTotal = Utility::jsonUrlDecode($request->input('sub_total_edit'));

            //ACCOUNT VARIABLES
            $accClass = Utility::jsonUrlDecode($request->input('acc_class_edit')); $accDesc = Utility::jsonUrlDecode($request->input('acc_desc_edit'));
            $accRate = Utility::jsonUrlDecode($request->input('acc_rate_edit')); $accTax = Utility::jsonUrlDecode($request->input('acc_tax_edit'));
            $accTaxPerct = Utility::jsonUrlDecode($request->input('acc_tax_perct_edit')); $accTaxAmount = Utility::jsonUrlDecode($request->input('acc_tax_amount_edit'));
            $accDiscountPerct = Utility::jsonUrlDecode($request->input('acc_discount_perct_edit')); $accDiscountAmount = Utility::jsonUrlDecode($request->input('acc_discount_amount_edit'));
            $accSubTotal = Utility::jsonUrlDecode($request->input('acc_sub_total_edit'));

            //GENERAL VARIABLES
            $postingDate = $request->input('posting_date'); $prefCustomer = $request->input('pref_customer');
            $quoteNo = $request->input('quote_number'); $shipCountry = $request->input('ship_country');
            $shipCity = $request->input('ship_city'); $shipContact = $request->input('ship_contact');
            $shipAgent = $request->input('ship_agent'); $shipMethod = $request->input('ship_method');
            $shipAddress = $request->input('ship_address'); $user = $request->input('user');
            $grandTotal = $request->input('grand_total'); $grandTotalVendorCurr = $request->input('grand_total_vendor_curr');
            $mailOption = $request->input('mail_option'); $emails = $request->input('emails'); $file = $request->input('file');
            $message = Utility::urlDecode($request->input('mail_message')); $oneTimeDiscount = $request->input('one_time_discount_amount_edit');
            $oneTimeDiscountPerct = $request->input('one_time_discount_perct_edit');
            $oneTimeTaxAmount = $request->input('one_time_tax_amount_edit'); $taxType = $request->input('tax_type');
            $discountType = $request->input('discount_type'); $oneTimeTaxPerct = $request->input('one_time_tax_perct_edit');
            $mailCopy = $request->input('mail_copy'); $quoteStatus = $request->input('quote_status');

            $vendor = VendorCustomer::firstRow('id',$prefCustomer);
            $curr = Currency::firstRow('id',$vendor->currency_id);
            $files = $request->file('file');
            $mailFiles = [];

            $editId = $request->input('edit_id');
            $editData = QuoteExtension::firstRow('id',$editId);
            $uid = $editData->uid;
            $attachment = ($editData->attachment != '') ? json_decode($editData->attachment,true) : [];

            if($editData->attachment != ''){
                foreach($attachment as $attach){
                    $mainFiles[] = Utility::FILE_URL($attach);
                }
            }

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

            $dbDATA = [
                'assigned_user' => $user,
                'quote_number' => $quoteNo,
                'mails' => $emails,
                'mail_copy' => $mailCopy,
                'sum_total' => $grandTotal,
                'trans_total' => $grandTotalVendorCurr,
                'discount_total' => Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),$oneTimeDiscount,$postingDate),
                'discount_trans' => $oneTimeDiscount,
                'discount_perct' => $oneTimeDiscountPerct,
                'discount_type' => $discountType,
                'tax_total' => Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),$oneTimeTaxAmount,$postingDate),
                'tax_trans' => $oneTimeTaxAmount,
                'tax_perct' => $oneTimeTaxPerct,
                'tax_type' => $taxType,
                'message' => $message,
                'attachment' => json_encode($attachment,true),
                'default_curr' => Utility::currencyArrayItem('id'),
                'trans_curr' => $curr->id,
                'customer' => $prefCustomer,
                'ship_to_city' => $shipCity,
                'ship_address' => $shipAddress,
                'ship_to_country' => $shipCountry,
                'ship_to_contact' => $shipContact,
                'ship_method' => $shipMethod,
                'ship_agent' => $shipAgent,
                'quote_status' => $quoteStatus,
                'updated_by' => Auth::user()->id,
            ];

            $mainQuote = QuoteExtension::defaultUpdate('id', $editId, $dbDATA);
            $countExtAcc = $request->input('count_ext_acc');
            $countExtPo = $request->input('count_ext_po');
            if($countExtPo > 0){

                for ($i = 1; $i <= $countExtPo; $i++) {
                    $quoteDbDataEdit = [];
                    if (!empty($request->input('inv_class' . $i))) {
                        $binStock = Inventory::firstRow('id', $request->input('inv_class' . $i));
                        $quoteDbDataEdit['item_id'] = $request->input('inv_class' . $i);
                        $quoteDbDataEdit['bin_stock'] = $binStock->inventory_type;
                        $quoteDbDataEdit['unit_measurement'] = $request->input('unit_measure' . $i);
                        $quoteDbDataEdit['quantity'] = $request->input('quantity' . $i);
                        $quoteDbDataEdit['quote_desc'] = $request->input('item_desc' . $i);
                        $quoteDbDataEdit['unit_cost_trans'] = $request->input('unit_cost' . $i);
                        $quoteDbDataEdit['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('unit_cost' . $i), 0), $postingDate);
                        $quoteDbDataEdit['tax_id'] = Utility::checkEmptyItem($request->input('tax' . $i), 0);
                        $quoteDbDataEdit['tax_perct'] = Utility::checkEmptyItem($request->input('tax_perct' . $i), 0);
                        $quoteDbDataEdit['tax_amount_trans'] = Utility::checkEmptyItem($request->input('tax_amount' . $i), 0);
                        $quoteDbDataEdit['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('tax_amount' . $i), 0), $postingDate);
                        $quoteDbDataEdit['discount_amount_trans'] = Utility::checkEmptyItem($request->input('discount_amount' . $i), 0);
                        $quoteDbDataEdit['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('discount_amount' . $i), 0), $postingDate);
                        $quoteDbDataEdit['discount_perct'] = Utility::checkEmptyItem($request->input('discount_perct' . $i), 0);
                        $quoteDbDataEdit['extended_amount_trans'] = Utility::checkEmptyItem($request->input('sub_total' . $i), 0);
                        $quoteDbDataEdit['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('sub_total' . $i), 0), $postingDate);

                        $quoteDbDataEdit['updated_by'] = Auth::user()->id;

                        Quote::defaultUpdate('id', $request->input('poId' . $i), $quoteDbDataEdit);
                    }

                }

            }

            if($countExtAcc > 0){

                for ($i = 1; $i <= $countExtAcc; $i++) {

                    if (!empty($request->input('acc_class' . $i))) {
                        $accDbDataEdit['account_id'] = $request->input('acc_class' . $i);
                        $accDbDataEdit['quote_desc'] = $request->input('item_desc_acc' . $i);
                        $accDbDataEdit['unit_cost_trans'] = $request->input('unit_cost_acc' . $i);
                        $accDbDataEdit['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), $request->input('unit_cost_acc' . $i), $postingDate);
                        $accDbDataEdit['tax_id'] = $request->input('tax_acc' . $i);
                        $accDbDataEdit['tax_perct'] = $request->input('tax_perct_acc' . $i);
                        $accDbDataEdit['tax_amount_trans'] = $request->input('tax_amount_acc' . $i);
                        $accDbDataEdit['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('tax_amount_acc' . $i), 0), $postingDate);
                        $accDbDataEdit['discount_amount_trans'] = Utility::checkEmptyItem($request->input('discount_amount_acc' . $i), 0);
                        $accDbDataEdit['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('discount_amount_acc' . $i), 0), $postingDate);
                        $accDbDataEdit['discount_perct'] = $request->input('discount_perct_acc' . $i);
                        $accDbDataEdit['extended_amount_trans'] = $request->input('sub_total_acc' . $i);
                        $accDbDataEdit['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('sub_total_acc' . $i), 0), $postingDate);
                        $accDbDataEdit['updated_by'] = Auth::user()->id;

                        Quote::defaultUpdate('id', $request->input('accId' . $i), $accDbDataEdit);
                    }

                }

            }
            //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

            $accDbData = [];
            $quoteDbData = [];

            $accDbData['quote_id'] = $editId;
            $accDbData['uid'] = $uid;


            //LOOP THROUGH ACCOUNTS
            if(!empty($accClass)) {
                if (count($accClass) == count($accRate) && count($accSubTotal) == count($accClass)) {
                    for ($i = 0; $i < count($accClass); $i++) {
                        $accDbData['account_id'] = Utility::checkEmptyArrayItem($accClass, $i, 0);
                        $accDbData['quote_desc'] = Utility::checkEmptyArrayItem($accDesc, $i, '');
                        $accDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($accRate, $i, 0);
                        $accDbData['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($accRate, $i, 0), $postingDate);
                        $accDbData['tax_id'] = Utility::checkEmptyArrayItem($accTax, $i, 0);
                        $accDbData['tax_perct'] = Utility::checkEmptyArrayItem($accTaxPerct, $i, 0);
                        $accDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($accTaxAmount, $i, 0);
                        $accDbData['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($accTaxAmount, $i, 0), $postingDate);
                        $accDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($accDiscountAmount, $i, 0);
                        $accDbData['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($accDiscountAmount, $i, 0), $postingDate);
                        $accDbData['discount_perct'] = Utility::checkEmptyArrayItem($accDiscountPerct, $i, 0);
                        $accDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($accSubTotal, $i, 0);
                        $accDbData['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($accSubTotal, $i, 0), $postingDate);
                        $accDbData['status'] = Utility::STATUS_ACTIVE;
                        $accDbData['created_by'] = Auth::user()->id;

                        Quote::create($accDbData);

                    }

                }

            }

            //LOOP THROUGH ITEMS
            $quoteDbData['quote_id'] = $editId;
            $quoteDbData['uid'] = $uid;
            $dda = '';

            /*return response()->json([
                'message' => 'good',
                'message2' =>   json_encode($taxPerct)    //json_encode($request->all(),true)
            ]);*/
            if(!empty($invClass)) {
                if (count($invClass) == count($subTotal)) {
                    for ($i = 0; $i < count($invClass); $i++) {
                        $binStock = Inventory::firstRow('id', $invClass);
                        $quoteDbData['item_id'] = Utility::checkEmptyArrayItem($invClass, $i, 0);
                        $quoteDbData['bin_stock'] = $binStock->inventory_type;
                        $quoteDbData['unit_measurement'] = Utility::checkEmptyArrayItem($unitMeasure, $i, 0);
                        $quoteDbData['quantity'] = Utility::checkEmptyArrayItem($quantity, $i, 0);
                        $quoteDbData['quote_desc'] = Utility::checkEmptyArrayItem($itemDesc, $i, '');
                        $quoteDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($unitCost, $i, 0);
                        $quoteDbData['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($unitCost, $i, 0), $postingDate);
                        $quoteDbData['tax_id'] = Utility::checkEmptyArrayItem($tax, $i, 0);
                        $quoteDbData['tax_perct'] = Utility::checkEmptyArrayItem($taxPerct, $i, 0);
                        $quoteDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($taxAmount, $i, 0);
                        $quoteDbData['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($taxAmount, $i, 0), $postingDate);
                        $quoteDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($discountAmount, $i, 0);
                        $quoteDbData['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($discountAmount, $i, 0), $postingDate);
                        $quoteDbData['discount_perct'] = Utility::checkEmptyArrayItem($discountPerct, $i, 0);
                        $quoteDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($subTotal, $i, 0);
                        $quoteDbData['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($subTotal, $i, 0), $postingDate);

                        $quoteDbData['status'] = Utility::STATUS_ACTIVE;
                        $quoteDbData['created_by'] = Auth::user()->id;

                        Quote::create($quoteDbData);

                    }



                }

            }


            if($mailOption == Utility::STATUS_ACTIVE){
                $QuoteId = $editId;
                $getQuote = QuoteExtension::firstRow('id',$QuoteId);
                $getQuoteData = Quote::specialColumns('uid',$getQuote->uid);
                $currencyData = Currency::firstRow('id',$getQuote->trans_curr);

                $mailContent = [];

                $mailCopyContent = ($mailCopy != '') ? explode(',',$mailCopy) : [];
                $mailContent['copy'] = $mailCopyContent;
                $mailContent['fromEmail']= Auth::user()->email;
                $mailContent['quote']= $getQuote;
                $mailContent['quoteData'] = $getQuoteData;
                $mailContent['attachment'] = $mailFiles;
                $mailContent['currency'] = $currencyData->code;

                //CHECK IF MAIL IS EMPTY ELSE CONTINUE TO SEND MAIL
                if($emails != ''){
                    $mailToArray = explode(',',$emails);
                    if(count($mailToArray) >0){ //SEND MAIL TO ALL INVOLVED IN THE PURCHASE ORDER
                        foreach($mailToArray as $data) {
                            Notify::quoteMail('mail_views.quote', $mailContent, $data, Auth::user()->firstname.' '.Auth::user()->lastname, 'Purchase Order');
                        }
                    }
                }

            }


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

    public function permDelete(Request $request)
    {
        //
        $id = $request->input('dataId');

        $delete = Quote::deleteItem($id);

        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
        ]);

    }

    public function removeAttachment(Request $request){
        $file_name = $request->input('attachment');
        //return $files;
        $attachment = [];
        $editId = $request->input('edit_id');
        $oldData = QuoteExtension::firstRow('id',$editId);

        $dbData = [
            'attachment' => Utility::removeJsonItem($oldData->attachment,$file_name)
        ];
        $save = QuoteExtension::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message' => 'good',
            'message2' => 'File have been removed'
        ]);

    }

    public function downloadAttachment(){
        $file = $_GET['file'];
        $download = Utility::FILE_URL($file);
        return response()->download($download);
        //return $file;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function searchQuote(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = QuoteExtension::searchQuote($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->uid;
        }
        /*for($i=0;$i<count($search);$i++){
            $obtain_array[] = $search[$i]->id;
        }*/
        //print_r($search); exit();
        $user_ids = array_unique($obtain_array);
        $mainData =  QuoteExtension::massDataPaginate('uid', $user_ids);
        //print_r($obtain_array); die();
        if (count($user_ids) > 0) {

            return view::make('quote.search_po')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
        }

    }


    public function destroy(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));

        foreach($idArray as $data){
            $dataChild = Quote::specialColumns('quote_id',$data);
            if(!empty($dataChild)){
                foreach($dataChild as $child){
                    $delete = Quote::deleteItem($child->id);
                }
            }
            $delete = QuoteExtension::deleteItem($data);
        }


        return response()->json([
            'message' => 'deleted',
            'message2' => 'Data deleted successfully'
        ]);

    }

}
