<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Helpers\Notify;
use App\model\Currency;
use App\model\Inventory;
use App\model\InventoryBom;
use App\model\PoExtension;
use App\model\PurchaseOrder;
use App\model\Stock;
use App\model\VendorCustomer;
use App\model\RFQ;
use App\model\RFQExtension;
use App\model\QuoteExtension;
use App\model\Quote;
use App\model\UnitMeasure;
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
use Illuminate\Support\Facades\Log;

class PurchaseOrderController extends Controller
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
        $mainData = PoExtension::specialColumnsPage('created_by',Auth::user()->id);

        if ($request->ajax()) {
            return \Response::json(view::make('purchase_order.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('purchase_order.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),PurchaseOrder::$mainRules);

        if($validator->passes()){

            /*$countData = PoExtension::firstRow('po_number',$request->input('po_number'));
            if(!empty($countData)){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry(PO number) already exist, please try another entry'
                ]);

            }*/

                //ITEM VARIABLES
                $invClass = Utility::jsonUrlDecode($request->input('inv_class')); $itemDesc = Utility::jsonUrlDecode($request->input('item_desc'));
                $warehouse = Utility::jsonUrlDecode($request->input('warehouse')); $quantity = Utility::jsonUrlDecode($request->input('quantity'));
                $unitCost = Utility::jsonUrlDecode($request->input('unit_cost')); $unitMeasure = Utility::jsonUrlDecode($request->input('unit_measure'));
                $quantityReserved = Utility::jsonUrlDecode($request->input('quantity_reserved')); $quantityReceived = Utility::jsonUrlDecode($request->input('quantity_received'));
                $planned = Utility::jsonUrlDecode($request->input('planned')); $expected = Utility::jsonUrlDecode($request->input('expected'));
                $promised = Utility::jsonUrlDecode($request->input('promised')); $bOrderNo = Utility::jsonUrlDecode($request->input('b_order_no'));
                $bOrderLineNo = Utility::jsonUrlDecode($request->input('b_order_line_no')); $shipStatus = Utility::jsonUrlDecode($request->input('ship_status'));
                $statusComment = Utility::jsonUrlDecode($request->input('status_comment')); $tax = Utility::jsonUrlDecode($request->input('tax'));
                $taxPerct = Utility::jsonUrlDecode($request->input('tax_perct')); $taxAmount = Utility::jsonUrlDecode($request->input('tax_amount'));
                $discountPerct = Utility::jsonUrlDecode($request->input('discount_perct')); $discountAmount = Utility::jsonUrlDecode($request->input('discount_amount'));
                $subTotal = Utility::jsonUrlDecode($request->input('sub_total'));

                //ACCOUNT VARIABLES
                $accClass = Utility::jsonUrlDecode($request->input('acc_class')); $accDesc = Utility::jsonUrlDecode($request->input('acc_desc'));
                $accRate = Utility::jsonUrlDecode($request->input('acct_rate')); $accTax = Utility::jsonUrlDecode($request->input('acc_tax'));
                $accTaxPerct = Utility::jsonUrlDecode($request->input('acc_tax_perct')); $accTaxAmount = Utility::jsonUrlDecode($request->input('acc_tax_amount'));
                $accDiscountPerct = Utility::jsonUrlDecode($request->input('acc_discount_perct')); $accDiscountAmount = Utility::jsonUrlDecode($request->input('acc_discount_amount'));
                $accSubTotal = Utility::jsonUrlDecode($request->input('acc_sub_total'));

                //GENERAL VARIABLES
                $postingDate = $request->input('posting_date'); $prefVendor = $request->input('pref_vendor'); $dueDate = $request->input('due_date');
                $poStatus = $request->input('po_status'); $vendorInvoiceNo = $request->input('vendor_invoice_no'); $purchaseOrderNo = $request->input('po_number');
                $user = $request->input('user'); $shipCountry = $request->input('ship_country'); $shipCity = $request->input('ship_city');
                $shipContact = $request->input('ship_contact'); $shipAgent = $request->input('ship_agent'); $shipMethod = $request->input('ship_method');
                $shipAddress = $request->input('ship_address'); $grandTotal = $request->input('grand_total'); $grandTotalVendorCurr = $request->input('grand_total_vendor_curr');
                $mailOption = $request->input('mail_option'); $emails = $request->input('emails'); $file = $request->input('file');
                $message = Utility::urlDecode($request->input('mail_message')); $oneTimeDiscount = $request->input('one_time_discount_amount'); $oneTimePerct = $request->input('one_time_perct');
                $oneTimeTaxAmount = $request->input('one_time_tax_amount'); $taxType = $request->input('tax_type');
                $discountType = $request->input('discount_type'); $oneTimeTaxPerct = $request->input('one_time_tax_perct');
                $rfqNo = $request->input('rfq_no'); $mailCopy = $request->input('mail_copy');

                $vendor = VendorCustomer::firstRow('id',$prefVendor);
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

                $uid = Utility::generateUID('po_extention');

                $dbDATA = [
                    'uid' => $uid,
                    'assigned_user' => $user,
                    'po_number' => $purchaseOrderNo,
                    'vendor_invoice_no' => $vendorInvoiceNo,
                    'rfq_no' => $rfqNo,
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
                    'vendor' => $prefVendor,
                    'due_date' => Utility::standardDate($dueDate),
                    'post_date' => Utility::standardDate($postingDate),
                    'ship_to_city' => $shipCity,
                    'ship_address' => $shipAddress,
                    'ship_to_country' => $shipCountry,
                    'ship_to_contact' => $shipContact,
                    'ship_method' => $shipMethod,
                    'ship_agent' => $shipAgent,
                    'purchase_status' => $poStatus,
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                $accDbData = [
                    'uid' => $uid
                ];
                $poDbData = [
                    'uid' => $uid
                ];

                if(count($accClass) == count($accRate) && count($invClass) == count($subTotal)) {

                        $mainPo = PoExtension::create($dbDATA);
                        $accDbData['po_id'] = $mainPo->id;
                        $poDbData['po_id'] = $mainPo->id;

                    //LOOP THROUGH ACCOUNTS
                    if(count($accClass) == count($accRate) && count($accSubTotal) == count($accClass)){
                        for($i=0;$i<count($accClass);$i++){
                            $accDbData['account_id'] = Utility::checkEmptyArrayItem($accClass,$i,0);
                            $accDbData['po_desc'] = Utility::checkEmptyArrayItem($accDesc,$i,'');
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

                            PurchaseOrder::create($accDbData);

                        }

                    }

                    //LOOP THROUGH ITEMS
                    if(count($invClass) == count($subTotal)){
                        for($i=0;$i<count($invClass);$i++){
                            $binStock = Inventory::firstRow('id',$invClass);
                            $poDbData['item_id'] = Utility::checkEmptyArrayItem($invClass,$i,0);
                            $poDbData['bin_stock'] = $binStock->inventory_type;
                            $poDbData['unit_measurement'] = Utility::checkEmptyArrayItem($unitMeasure,$i,0);
                            $poDbData['quantity'] = Utility::checkEmptyArrayItem($quantity,$i,0);
                            $poDbData['po_desc'] = Utility::checkEmptyArrayItem($itemDesc,$i,'');
                            $poDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($unitCost,$i,0);
                            $poDbData['unit_cost'] = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($unitCost,$i,0),$postingDate);
                            $poDbData['tax_id'] = Utility::checkEmptyArrayItem($tax,$i,0);
                            $poDbData['tax_perct'] = Utility::checkEmptyArrayItem($taxPerct,$i,0);
                            $poDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($taxAmount,$i,0);
                            $poDbData['tax_amount'] = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($taxAmount,$i,0),$postingDate);
                            $poDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($discountAmount,$i,0);
                            $poDbData['discount_amount'] = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($discountAmount,$i,0),$postingDate);
                            $poDbData['discount_perct'] = Utility::checkEmptyArrayItem($discountPerct,$i,0);
                            $poDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($subTotal,$i,0);
                            $poDbData['extended_amount'] = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($subTotal,$i,0),$postingDate);

                            $statComHist = [];
                            if(Utility::checkEmptyArrayItem($shipStatus,$i,0) != 0){
                                $statComHist[Utility::checkEmptyArrayItem($shipStatus,$i,0)] = Utility::checkEmptyArrayItem($statusComment,$i,'');

                            }

                            $poDbData['ship_to_whse'] = Utility::checkEmptyArrayItem($warehouse,$i,'');
                            $poDbData['reserved_quantity'] = Utility::checkEmptyArrayItem($quantityReserved,$i,'');
                            $poDbData['received_quantity'] = Utility::checkEmptyArrayItem($quantityReceived,$i,'');
                            $poDbData['planned_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($planned,$i,''));
                            $poDbData['promised_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($promised,$i,''));
                            $poDbData['expected_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($expected,$i,''));
                            $poDbData['po_status'] = Utility::checkEmptyArrayItem($shipStatus,$i,'');
                            $poDbData['po_status_comment'] = Utility::checkEmptyArrayItem($statusComment,$i,'');
                            $poDbData['status_comment_history'] = json_encode($statComHist,true);
                            $poDbData['blanket_order_no'] = Utility::checkEmptyArrayItem($bOrderNo,$i,'');
                            $poDbData['blanket_order_line_no'] = Utility::checkEmptyArrayItem($bOrderLineNo,$i,'');
                            $poDbData['status'] = Utility::STATUS_ACTIVE;
                            $poDbData['created_by'] = Auth::user()->id;

                            PurchaseOrder::create($poDbData);

                        }

                    }

                   /* return response()->json([
                    'message' => 'warning',
                    'message2' => json_encode($poDbData)
                ]);*/

                    if($mailOption == Utility::STATUS_ACTIVE){
                        $poId = $mainPo->id;
                        $getPo = PoExtension::firstRow('id',$poId);
                        $getPoData = PurchaseOrder::specialColumns('uid',$getPo->uid);
                        Utility::fetchBOMItems($getPoData);
                        $currencyData = Currency::firstRow('id',$getPo->trans_curr);

                        $mailContent = [];

                        $mailCopyContent = ($mailCopy != '') ? explode(',',$mailCopy) : [];
                        $mailContent['copy'] = $mailCopyContent;
                        $mailContent['fromEmail']= Auth::user()->email;
                        $mailContent['po']= $getPo;
                        $mailContent['poData'] = $getPoData;
                        $mailContent['attachment'] = $mailFiles;
                        $mailContent['currency'] = $currencyData->code;

                        //CHECK IF MAIL IS EMPTY ELSE CONTINUE TO SEND MAIL
                        if($emails != ''){
                            $mailToArray = explode(',',$emails);
                            if(count($mailToArray) >0){ //SEND MAIL TO ALL INVOLVED IN THE PURCHASE ORDER
                                foreach($mailToArray as $data) {
                                    Notify::poMail('mail_views.purchase_order', $mailContent, $data, Auth::user()->firstname.' '.Auth::user()->lastname, 'Purchase Order');
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
        $po = PoExtension::firstRow('id',$request->input('dataId'));
        $poData = PurchaseOrder::specialColumns('po_id',$po->id);
        return view::make('purchase_order.edit_form')->with('edit',$po)->with('poData',$poData);

    }

    public function printPreview(Request $request)
    {
        //
        $currency = Utility::defaultCurrency();
        $type = $request->input('type');
        $po = PoExtension::firstRow('id',$request->input('dataId'));
        $poData = PurchaseOrder::specialColumns('po_id',$po->id);
        Utility::fetchBOMItems($poData);  //ADD BOM ITEMS TO INVENTORY ITEM
        if($type == 'vendor' && !empty($po)){
            $data = Currency::firstRow('id',$po->trans_curr);
            $currency = $data->code;

            return view::make('purchase_order.print_preview_vendor')->with('po',$po)->with('poData',$poData)
                ->with('currency',$currency);
        }
        return view::make('purchase_order.print_preview_default')->with('po',$po)->with('poData',$poData)
            ->with('currency',$currency);

    }

    //FETCH QUOTE DATA FOR DISPLAY IN CONVERT TO FORM MODAL DISPLAY
    public function convertQuoteForm(Request $request)
    {
        //
        $po = QuoteExtension::firstRow('id',$request->input('dataId'));
        $QuoteData = Quote::specialColumns('Quote_id',$po->id);
        return view::make('purchase_order.convert_quote_form')->with('edit',$po)->with('quoteData',$QuoteData);

    }

    //FETCH RFQ DATA FOR DISPLAY IN CONVERT TO FORM MODAL DISPLAY
    public function convertRfqForm(Request $request)
    {
        //
        $rfq = RFQExtension::firstRow('id',$request->input('dataId'));
        $rfqData = RFQ::specialColumns('rfq_id',$rfq->id);
        $unitMeasure = UnitMeasure::paginateAllData();
        return view::make('purchase_order.convert_rfq_form')->with('edit',$rfq)->with('rfqData',$rfqData)
            ->with('unitMeasure',$unitMeasure);

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
        $validator = Validator::make($request->all(),PurchaseOrder::$mainRules);
        if($validator->passes()){

            /*$countData = PoExtension::countData('po_number',$request->input('po_number'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry(PO number) already exist, please try another entry'
                ]);

            }*/
                //ITEM VARIABLES
                $invClass = Utility::jsonUrlDecode($request->input('inv_class_edit')); $itemDesc = Utility::jsonUrlDecode($request->input('item_desc_edit'));
                $warehouse = Utility::jsonUrlDecode($request->input('warehouse_edit')); $quantity = Utility::jsonUrlDecode($request->input('quantity_edit'));
                $unitCost = Utility::jsonUrlDecode($request->input('unit_cost_edit')); $unitMeasure = Utility::jsonUrlDecode($request->input('unit_measure_edit'));
                $quantityReserved = Utility::jsonUrlDecode($request->input('quantity_reserved_edit')); $quantityReceived = Utility::jsonUrlDecode($request->input('quantity_received_edit'));
                $planned = Utility::jsonUrlDecode($request->input('planned_edit')); $expected = Utility::jsonUrlDecode($request->input('expected_edit'));
                $promised = Utility::jsonUrlDecode($request->input('promised_edit')); $bOrderNo = Utility::jsonUrlDecode($request->input('b_order_no_edit'));
                $bOrderLineNo = Utility::jsonUrlDecode($request->input('b_order_line_no_edit')); $shipStatus = Utility::jsonUrlDecode($request->input('ship_status_edit'));
                $statusComment = Utility::jsonUrlDecode($request->input('status_comment_edit')); $tax = Utility::jsonUrlDecode($request->input('tax_edit'));
                $taxPerct = Utility::jsonUrlDecode($request->input('tax_perct_edit')); $taxAmount = Utility::jsonUrlDecode($request->input('tax_amount_edit'));
                $discountPerct = Utility::jsonUrlDecode($request->input('discount_perct_edit')); $discountAmount = Utility::jsonUrlDecode($request->input('discount_amount_edit'));
                $subTotal = Utility::jsonUrlDecode($request->input('sub_total_edit'));

                //ACCOUNT VARIABLES
                $accClass = Utility::jsonUrlDecode($request->input('acc_class_edit')); $accDesc = Utility::jsonUrlDecode($request->input('acc_desc_edit'));
                $accRate = Utility::jsonUrlDecode($request->input('acc_rate_edit')); $accTax = Utility::jsonUrlDecode($request->input('acc_tax_edit'));
                $accTaxPerct = Utility::jsonUrlDecode($request->input('acc_tax_perct_edit')); $accTaxAmount = Utility::jsonUrlDecode($request->input('acc_tax_amount_edit'));
                $accDiscountPerct = Utility::jsonUrlDecode($request->input('acc_discount_perct_edit')); $accDiscountAmount = Utility::jsonUrlDecode($request->input('acc_discount_amount_edit'));
                $accSubTotal = Utility::jsonUrlDecode($request->input('acc_sub_total_edit'));

                //GENERAL VARIABLES
                $postingDate = $request->input('posting_date'); $prefVendor = $request->input('pref_vendor'); $dueDate = $request->input('due_date');
                $poStatus = $request->input('po_status'); $vendorInvoiceNo = $request->input('vendor_invoice_no'); $purchaseOrderNo = $request->input('po_number');
                $user = $request->input('user'); $shipCountry = $request->input('ship_country'); $shipCity = $request->input('ship_city');
                $shipContact = $request->input('ship_contact'); $shipAgent = $request->input('ship_agent'); $shipMethod = $request->input('ship_method');
                $shipAddress = $request->input('ship_address'); $grandTotal = $request->input('grand_total'); $grandTotalVendorCurr = $request->input('grand_total_vendor_curr');
                $mailOption = $request->input('mail_option'); $emails = $request->input('emails'); $file = $request->input('file');
                $message = Utility::urlDecode($request->input('mail_message')); $oneTimeDiscount = $request->input('one_time_discount_amount_edit'); $oneTimeDiscountPerct = $request->input('one_time_discount_perct_edit');
                $oneTimeTaxAmount = $request->input('one_time_tax_amount_edit'); $taxType = $request->input('tax_type');
                $discountType = $request->input('discount_type'); $oneTimeTaxPerct = $request->input('one_time_tax_perct_edit');
                $rfqNo = $request->input('rfq_no'); $mailCopy = $request->input('mail_copy');

                $vendor = VendorCustomer::firstRow('id',$prefVendor);
                $curr = Currency::firstRow('id',$vendor->currency_id);
                $files = $request->file('file');
                $mailFiles = [];

                $editId = $request->input('edit_id');
                $editData = PoExtension::firstRow('id',$editId);
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
                    'po_number' => $purchaseOrderNo,
                    'vendor_invoice_no' => $vendorInvoiceNo,
                    'mails' => $emails,
                    'mail_copy' => $mailCopy,
                    'rfq_no' => $rfqNo,
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
                    'vendor' => $prefVendor,
                    'due_date' => Utility::standardDate($dueDate),
                    'post_date' => Utility::standardDate($postingDate),
                    'ship_to_city' => $shipCity,
                    'ship_address' => $shipAddress,
                    'ship_to_country' => $shipCountry,
                    'ship_to_contact' => $shipContact,
                    'ship_method' => $shipMethod,
                    'ship_agent' => $shipAgent,
                    'purchase_status' => $poStatus,
                    'updated_by' => Auth::user()->id,
                ];

                $mainPo = PoExtension::defaultUpdate('id', $editId, $dbDATA);
                $countExtAcc = $request->input('count_ext_acc');
                $countExtPo = $request->input('count_ext_po');

                if($countExtPo > 0){

                    for ($i = 1; $i <= $countExtPo; $i++) {
                        $poDbDataEdit = [];

                        if (!empty($request->input('inv_class' . $i))) {
                            $binStock = Inventory::firstRow('id', $request->input('inv_class' . $i));
                            $poDbDataEdit['item_id'] = $request->input('inv_class' . $i);
                            $poDbDataEdit['bin_stock'] = $binStock->inventory_type;
                            $poDbDataEdit['unit_measurement'] = $request->input('unit_measure' . $i);
                            $poDbDataEdit['quantity'] = $request->input('quantity' . $i);
                            $poDbDataEdit['po_desc'] = $request->input('item_desc' . $i);
                            $poDbDataEdit['unit_cost_trans'] = $request->input('unit_cost' . $i);
                            $poDbDataEdit['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('unit_cost' . $i), 0), $postingDate);
                            $poDbDataEdit['tax_id'] = Utility::checkEmptyItem($request->input('tax' . $i), 0);
                            $poDbDataEdit['tax_perct'] = Utility::checkEmptyItem($request->input('tax_perct' . $i), 0);
                            $poDbDataEdit['tax_amount_trans'] = Utility::checkEmptyItem($request->input('tax_amount' . $i), 0);
                            $poDbDataEdit['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('tax_amount' . $i), 0), $postingDate);
                            $poDbDataEdit['discount_amount_trans'] = Utility::checkEmptyItem($request->input('discount_amount' . $i), 0);
                            $poDbDataEdit['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('discount_amount' . $i), 0), $postingDate);
                            $poDbDataEdit['discount_perct'] = Utility::checkEmptyItem($request->input('discount_perct' . $i), 0);
                            $poDbDataEdit['extended_amount_trans'] = Utility::checkEmptyItem($request->input('sub_total' . $i), 0);
                            $poDbDataEdit['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('sub_total' . $i), 0), $postingDate);

                            $statComHist = [];
                            if (Utility::checkEmptyItem($request->input('ship_status' . $i), 0) != 0) {
                                $statComHist[Utility::checkEmptyItem($request->input('ship_status' . $i), 0)] = Utility::checkEmptyItem($request->input('status_comment' . $i), '');

                            }

                            $poDbDataEdit['ship_to_whse'] = Utility::checkEmptyItem($request->input('warehouse' . $i), '0');
                            $poDbDataEdit['reserved_quantity'] = Utility::checkEmptyItem($request->input('quantity_reserved' . $i), '');
                            $poDbDataEdit['received_quantity'] = Utility::checkEmptyItem($request->input('quantity_received' . $i), '');
                            $poDbDataEdit['planned_receipt_date'] = Utility::standardDate(Utility::checkEmptyItem($request->input('planned' . $i), '0000-00-00'));
                            $poDbDataEdit['promised_receipt_date'] = Utility::standardDate(Utility::checkEmptyItem($request->input('promised' . $i), '0000-00-00'));
                            $poDbDataEdit['expected_receipt_date'] = Utility::standardDate(Utility::checkEmptyItem($request->input('expected' . $i), '0000-00-00'));
                            $poDbDataEdit['po_status'] = Utility::checkEmptyItem($request->input('ship_status' . $i), '');
                            $poDbDataEdit['po_status_comment'] = Utility::checkEmptyItem($request->input('status_comment' . $i), '');
                            $poDbDataEdit['status_comment_history'] = json_encode($statComHist, true);
                            $poDbDataEdit['blanket_order_no'] = Utility::checkEmptyItem($request->input('blanket_order_no' . $i), '');
                            $poDbDataEdit['blanket_order_line_no'] = Utility::checkEmptyItem($request->input('blanket_order_line_no' . $i), '');
                            $poDbDataEdit['updated_by'] = Auth::user()->id;

                            PurchaseOrder::defaultUpdate('id', $request->input('poId' . $i), $poDbDataEdit);
                        }

                    }

                }

                if($countExtAcc > 0){

                    for ($i = 1; $i <= $countExtAcc; $i++) {

                        if (!empty($request->input('acc_class' . $i))) {
                            $accDbDataEdit['account_id'] = $request->input('acc_class' . $i);
                            $accDbDataEdit['po_desc'] = $request->input('item_desc_acc' . $i);
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

                            PurchaseOrder::defaultUpdate('id', $request->input('accId' . $i), $accDbDataEdit);
                        }

                    }

                }
                   //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

                        $accDbData = [];
                        $poDbData = [];

                        $accDbData['po_id'] = $editId;
                        $accDbData['uid'] = $uid;


            /*return response()->json([
                'message' => 'good',
                'message2' =>  json_encode($gg).'count='.$countExtAcc  //json_encode($request->all(),true)
            ]);*/



                    //LOOP THROUGH ACCOUNTS
                    if(!empty($accClass)) {
                        if (count($accClass) == count($accRate) && count($accSubTotal) == count($accClass)) {
                            for ($i = 0; $i < count($accClass); $i++) {
                                $accDbData['account_id'] = Utility::checkEmptyArrayItem($accClass, $i, 0);
                                $accDbData['po_desc'] = Utility::checkEmptyArrayItem($accDesc, $i, '');
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

                                PurchaseOrder::create($accDbData);

                            }

                        }

                    }

                    //LOOP THROUGH ITEMS
                    $poDbData['po_id'] = $editId;
                    $poDbData['uid'] = $uid;
                    $dda = '';

            /*return response()->json([
                'message' => 'good',
                'message2' =>   json_encode($taxPerct)    //json_encode($request->all(),true)
            ]);*/
                    if(!empty($invClass)) {
                        if (count($invClass) == count($subTotal)) {
                            for ($i = 0; $i < count($invClass); $i++) {
                                $binStock = Inventory::firstRow('id', $invClass);
                                $poDbData['item_id'] = Utility::checkEmptyArrayItem($invClass, $i, 0);
                                $poDbData['bin_stock'] = $binStock->inventory_type;
                                $poDbData['unit_measurement'] = Utility::checkEmptyArrayItem($unitMeasure, $i, 0);
                                $poDbData['quantity'] = Utility::checkEmptyArrayItem($quantity, $i, 0);
                                $poDbData['po_desc'] = Utility::checkEmptyArrayItem($itemDesc, $i, '');
                                $poDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($unitCost, $i, 0);
                                $poDbData['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($unitCost, $i, 0), $postingDate);
                                $poDbData['tax_id'] = Utility::checkEmptyArrayItem($tax, $i, 0);
                                $poDbData['tax_perct'] = Utility::checkEmptyArrayItem($taxPerct, $i, 0);
                                $poDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($taxAmount, $i, 0);
                                $poDbData['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($taxAmount, $i, 0), $postingDate);
                                $poDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($discountAmount, $i, 0);
                                $poDbData['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($discountAmount, $i, 0), $postingDate);
                                $poDbData['discount_perct'] = Utility::checkEmptyArrayItem($discountPerct, $i, 0);
                                $poDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($subTotal, $i, 0);
                                $poDbData['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($subTotal, $i, 0), $postingDate);

                                $statComHist = [];
                                if (Utility::checkEmptyArrayItem($shipStatus, $i, 0) != 0) {
                                    $statComHist[Utility::checkEmptyArrayItem($shipStatus, $i, 0)] = Utility::checkEmptyArrayItem($statusComment, $i, '');

                                }

                                $poDbData['ship_to_whse'] = Utility::checkEmptyArrayItem($warehouse, $i, '0');
                                $poDbData['reserved_quantity'] = Utility::checkEmptyArrayItem($quantityReserved, $i, '');
                                $poDbData['received_quantity'] = Utility::checkEmptyArrayItem($quantityReceived, $i, '');
                                $poDbData['planned_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($planned, $i, ''));
                                $poDbData['promised_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($promised, $i, ''));
                                $poDbData['expected_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($expected, $i, ''));
                                $poDbData['po_status'] = Utility::checkEmptyArrayItem($shipStatus, $i, '');
                                $poDbData['po_status_comment'] = Utility::checkEmptyArrayItem($statusComment, $i, '');
                                $poDbData['status_comment_history'] = json_encode($statComHist, true);
                                $poDbData['blanket_order_no'] = Utility::checkEmptyArrayItem($bOrderNo, $i, '');
                                $poDbData['blanket_order_line_no'] = Utility::checkEmptyArrayItem($bOrderLineNo, $i, '');
                                $poDbData['status'] = Utility::STATUS_ACTIVE;
                                $poDbData['created_by'] = Auth::user()->id;

                                PurchaseOrder::create($poDbData);

                            }



                        }

                    }


                    if($mailOption == Utility::STATUS_ACTIVE){
                        $poId = $editId;
                        $getPo = PoExtension::firstRow('id',$poId);
                        $getPoData = PurchaseOrder::specialColumns('uid',$getPo->uid);
                        Utility::fetchBOMItems($getPoData);
                        $currencyData = Currency::firstRow('id',$getPo->trans_curr);

                        $mailContent = [];

                        $mailCopyContent = ($mailCopy != '') ? explode(',',$mailCopy) : [];
                        $mailContent['copy'] = $mailCopyContent;
                        $mailContent['fromEmail']= Auth::user()->email;
                        $mailContent['po']= $getPo;
                        $mailContent['poData'] = $getPoData;
                        $mailContent['attachment'] = $mailFiles;
                        $mailContent['currency'] = $currencyData->code;
                        
                        //CHECK IF MAIL IS EMPTY ELSE CONTINUE TO SEND MAIL
                        if($emails != ''){
                            $mailToArray = explode(',',$emails);
                            if(count($mailToArray) >0){ //SEND MAIL TO ALL INVOLVED IN THE PURCHASE ORDER
                                foreach($mailToArray as $data) {
                                    Notify::poMail('mail_views.purchase_order', $mailContent, $data, Auth::user()->firstname.' '.Auth::user()->lastname, 'Purchase Order');
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

    //CONVERT RFQ TO PURCHASE ORDER
    public function convertRfq(Request $request)
    {
        //
        $validator = Validator::make($request->all(),PurchaseOrder::$mainRules);
        if($validator->passes()){


            //ITEM VARIABLES
            $invClass = Utility::jsonUrlDecode($request->input('inv_class_edit')); $itemDesc = Utility::jsonUrlDecode($request->input('item_desc_edit'));
            $warehouse = Utility::jsonUrlDecode($request->input('warehouse_edit')); $quantity = Utility::jsonUrlDecode($request->input('quantity_edit'));
            $unitCost = Utility::jsonUrlDecode($request->input('unit_cost_edit')); $unitMeasure = Utility::jsonUrlDecode($request->input('unit_measure_edit'));
            $quantityReserved = Utility::jsonUrlDecode($request->input('quantity_reserved_edit')); $quantityReceived = Utility::jsonUrlDecode($request->input('quantity_received_edit'));
            $planned = Utility::jsonUrlDecode($request->input('planned_edit')); $expected = Utility::jsonUrlDecode($request->input('expected_edit'));
            $promised = Utility::jsonUrlDecode($request->input('promised_edit')); $bOrderNo = Utility::jsonUrlDecode($request->input('b_order_no_edit'));
            $bOrderLineNo = Utility::jsonUrlDecode($request->input('b_order_line_no_edit')); $shipStatus = Utility::jsonUrlDecode($request->input('ship_status_edit'));
            $statusComment = Utility::jsonUrlDecode($request->input('status_comment_edit')); $tax = Utility::jsonUrlDecode($request->input('tax_edit'));
            $taxPerct = Utility::jsonUrlDecode($request->input('tax_perct_edit')); $taxAmount = Utility::jsonUrlDecode($request->input('tax_amount_edit'));
            $discountPerct = Utility::jsonUrlDecode($request->input('discount_perct_edit')); $discountAmount = Utility::jsonUrlDecode($request->input('discount_amount_edit'));
            $subTotal = Utility::jsonUrlDecode($request->input('sub_total_edit'));

            //ACCOUNT VARIABLES
            $accClass = Utility::jsonUrlDecode($request->input('acc_class_edit')); $accDesc = Utility::jsonUrlDecode($request->input('acc_desc_edit'));
            $accRate = Utility::jsonUrlDecode($request->input('acc_rate_edit')); $accTax = Utility::jsonUrlDecode($request->input('acc_tax_edit'));
            $accTaxPerct = Utility::jsonUrlDecode($request->input('acc_tax_perct_edit')); $accTaxAmount = Utility::jsonUrlDecode($request->input('acc_tax_amount_edit'));
            $accDiscountPerct = Utility::jsonUrlDecode($request->input('acc_discount_perct_edit')); $accDiscountAmount = Utility::jsonUrlDecode($request->input('acc_discount_amount_edit'));
            $accSubTotal = Utility::jsonUrlDecode($request->input('acc_sub_total_edit'));

            //GENERAL VARIABLES
            $postingDate = $request->input('posting_date'); $prefVendor = $request->input('pref_vendor'); $dueDate = $request->input('due_date');
            $poStatus = $request->input('po_status'); $vendorInvoiceNo = $request->input('vendor_invoice_no'); $purchaseOrderNo = $request->input('po_number');
            $user = $request->input('user'); $shipCountry = $request->input('ship_country'); $shipCity = $request->input('ship_city');
            $shipContact = $request->input('ship_contact'); $shipAgent = $request->input('ship_agent'); $shipMethod = $request->input('ship_method');
            $shipAddress = $request->input('ship_address'); $grandTotal = $request->input('grand_total'); $grandTotalVendorCurr = $request->input('grand_total_vendor_curr');
            $mailOption = $request->input('mail_option'); $emails = $request->input('emails'); $file = $request->input('file');
            $message = Utility::urlDecode($request->input('mail_message')); $oneTimeDiscount = $request->input('one_time_discount_amount_edit'); $oneTimeDiscountPerct = $request->input('one_time_discount_perct_edit');
            $oneTimeTaxAmount = $request->input('one_time_tax_amount_edit'); $taxType = $request->input('tax_type');
            $discountType = $request->input('discount_type'); $oneTimeTaxPerct = $request->input('one_time_tax_perct_edit');
            $rfqNo = $request->input('rfq_no'); $mailCopy = $request->input('mail_copy');



            if (count($accClass) != count($accRate) && count($invClass) != count($unitCost)) {

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Please ensure to enter rate or/and quantity for each item/account'
                ]);

            }

            $vendor = VendorCustomer::firstRow('id',$prefVendor);
            $curr = Currency::firstRow('id',$vendor->currency_id);
            $files = $request->file('file');
            $mailFiles = [];

            $editId = $request->input('edit_id');
            $editData = RFQExtension::firstRow('id',$editId);
            $uid = Utility::generateUID('po_extention');
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
                'po_number' => $purchaseOrderNo,
                'vendor_invoice_no' => $vendorInvoiceNo,
                'mails' => $emails,
                'mail_copy' => $mailCopy,
                'rfq_no' => $rfqNo,
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
                'vendor' => $prefVendor,
                'due_date' => Utility::standardDate($dueDate),
                'post_date' => Utility::standardDate($postingDate),
                'ship_to_city' => $shipCity,
                'ship_address' => $shipAddress,
                'ship_to_country' => $shipCountry,
                'ship_to_contact' => $shipContact,
                'ship_method' => $shipMethod,
                'ship_agent' => $shipAgent,
                'purchase_status' => $poStatus,
                'created_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE,
            ];

            $mainPo = PoExtension::create($dbDATA);
            $countExtAcc = $request->input('count_ext_acc');
            $countExtPo = $request->input('count_ext_po');

            $accDbDataEdit['po_id'] = $mainPo->id;
            $poDbDataEdit['po_id'] = $mainPo->id;

            if($countExtPo > 0){

                for ($i = 1; $i <= $countExtPo; $i++) {

                    if (!empty($request->input('inv_class' . $i))) {
                        $binStock = Inventory::firstRow('id', $request->input('inv_class' . $i));
                        $poDbDataEdit['uid'] = $uid;
                        $poDbDataEdit['item_id'] = $request->input('inv_class' . $i);
                        $poDbDataEdit['bin_stock'] = $binStock->inventory_type;
                        $poDbDataEdit['unit_measurement'] = $request->input('unit_measure' . $i);
                        $poDbDataEdit['quantity'] = $request->input('quantity' . $i);
                        $poDbDataEdit['po_desc'] = $request->input('item_desc' . $i);
                        $poDbDataEdit['unit_cost_trans'] = $request->input('unit_cost' . $i);
                        $poDbDataEdit['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('unit_cost' . $i), 0), $postingDate);
                        $poDbDataEdit['tax_id'] = Utility::checkEmptyItem($request->input('tax' . $i), 0);
                        $poDbDataEdit['tax_perct'] = Utility::checkEmptyItem($request->input('tax_perct' . $i), 0);
                        $poDbDataEdit['tax_amount_trans'] = Utility::checkEmptyItem($request->input('tax_amount' . $i), 0);
                        $poDbDataEdit['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('tax_amount' . $i), 0), $postingDate);
                        $poDbDataEdit['discount_amount_trans'] = Utility::checkEmptyItem($request->input('discount_amount' . $i), 0);
                        $poDbDataEdit['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('discount_amount' . $i), 0), $postingDate);
                        $poDbDataEdit['discount_perct'] = Utility::checkEmptyItem($request->input('discount_perct' . $i), 0);
                        $poDbDataEdit['extended_amount_trans'] = Utility::checkEmptyItem($request->input('sub_total' . $i), 0);
                        $poDbDataEdit['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('sub_total' . $i), 0), $postingDate);
                        $poDbDataEdit['uid'] = $uid;
                        $statComHist = [];
                        if (Utility::checkEmptyItem($request->input('ship_status' . $i), 0) != 0) {
                            $statComHist[Utility::checkEmptyItem($request->input('ship_status' . $i), 0)] = Utility::checkEmptyItem($request->input('status_comment' . $i), '');

                        }

                        $poDbDataEdit['ship_to_whse'] = Utility::checkEmptyItem($request->input('warehouse' . $i), '0');
                        $poDbDataEdit['reserved_quantity'] = Utility::checkEmptyItem($request->input('quantity_reserved' . $i), '');
                        $poDbDataEdit['received_quantity'] = Utility::checkEmptyItem($request->input('quantity_received' . $i), '');
                        $poDbDataEdit['planned_receipt_date'] = Utility::standardDate(Utility::checkEmptyItem($request->input('planned' . $i), '0000-00-00'));
                        $poDbDataEdit['promised_receipt_date'] = Utility::standardDate(Utility::checkEmptyItem($request->input('promised' . $i), '0000-00-00'));
                        $poDbDataEdit['expected_receipt_date'] = Utility::standardDate(Utility::checkEmptyItem($request->input('expected' . $i), '0000-00-00'));
                        $poDbDataEdit['po_status'] = Utility::checkEmptyItem($request->input('ship_status' . $i), '');
                        $poDbDataEdit['po_status_comment'] = Utility::checkEmptyItem($request->input('status_comment' . $i), '');
                        $poDbDataEdit['status_comment_history'] = json_encode($statComHist, true);
                        $poDbDataEdit['blanket_order_no'] = Utility::checkEmptyItem($request->input('blanket_order_no' . $i), '');
                        $poDbDataEdit['blanket_order_line_no'] = Utility::checkEmptyItem($request->input('blanket_order_line_no' . $i), '');
                        $poDbDataEdit['created_by'] = Auth::user()->id;
                        $poDbDataEdit['status'] = Utility::STATUS_ACTIVE;

                        PurchaseOrder::create($poDbDataEdit);
                    }

                }

            }

            if($countExtAcc > 0){

                for ($i = 1; $i <= $countExtAcc; $i++) {

                    if (!empty($request->input('acc_class' . $i))) {
                        $accDbDataEdit['uid'] = $uid;
                        $accDbDataEdit['account_id'] = $request->input('acc_class' . $i);
                        $accDbDataEdit['po_desc'] = $request->input('item_desc_acc' . $i);
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
                        $accDbDataEdit['created_by'] = Auth::user()->id;
                        $accDbDataEdit['status'] = Utility::STATUS_ACTIVE;

                        PurchaseOrder::create($accDbDataEdit);
                    }

                }

            }
            //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

            $accDbData = [];
            $poDbData = [];

            $accDbData['po_id'] = $mainPo->id;
            $accDbData['uid'] = $uid;


            /*return response()->json([
                'message' => 'good',
                'message2' =>  json_encode($gg).'count='.$countExtAcc  //json_encode($request->all(),true)
            ]);*/



            //LOOP THROUGH ACCOUNTS
            if(!empty($accClass)) {
                if (count($accClass) == count($accRate) && count($accSubTotal) == count($accClass)) {
                    for ($i = 0; $i < count($accClass); $i++) {
                        $accDbData['uid'] = $uid;
                        $accDbData['account_id'] = Utility::checkEmptyArrayItem($accClass, $i, 0);
                        $accDbData['po_desc'] = Utility::checkEmptyArrayItem($accDesc, $i, '');
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

                        PurchaseOrder::create($accDbData);

                    }

                }

            }

            //LOOP THROUGH ITEMS
            $poDbData['po_id'] = $mainPo->id;
            $poDbData['uid'] = $uid;

            /*return response()->json([
                'message' => 'good',
                'message2' =>   json_encode($taxPerct)    //json_encode($request->all(),true)
            ]);*/
            if(!empty($invClass)) {
                if (count($invClass) == count($subTotal)) {
                    for ($i = 0; $i < count($invClass); $i++) {
                        $binStock = Inventory::firstRow('id', $invClass);
                        $poDbData['uid'] = $uid;
                        $poDbData['item_id'] = Utility::checkEmptyArrayItem($invClass, $i, 0);
                        $poDbData['bin_stock'] = $binStock->inventory_type;
                        $poDbData['unit_measurement'] = Utility::checkEmptyArrayItem($unitMeasure, $i, 0);
                        $poDbData['quantity'] = Utility::checkEmptyArrayItem($quantity, $i, 0);
                        $poDbData['po_desc'] = Utility::checkEmptyArrayItem($itemDesc, $i, '');
                        $poDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($unitCost, $i, 0);
                        $poDbData['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($unitCost, $i, 0), $postingDate);
                        $poDbData['tax_id'] = Utility::checkEmptyArrayItem($tax, $i, 0);
                        $poDbData['tax_perct'] = Utility::checkEmptyArrayItem($taxPerct, $i, 0);
                        $poDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($taxAmount, $i, 0);
                        $poDbData['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($taxAmount, $i, 0), $postingDate);
                        $poDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($discountAmount, $i, 0);
                        $poDbData['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($discountAmount, $i, 0), $postingDate);
                        $poDbData['discount_perct'] = Utility::checkEmptyArrayItem($discountPerct, $i, 0);
                        $poDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($subTotal, $i, 0);
                        $poDbData['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($subTotal, $i, 0), $postingDate);

                        $statComHist = [];
                        if (Utility::checkEmptyArrayItem($shipStatus, $i, 0) != 0) {
                            $statComHist[Utility::checkEmptyArrayItem($shipStatus, $i, 0)] = Utility::checkEmptyArrayItem($statusComment, $i, '');

                        }

                        $poDbData['ship_to_whse'] = Utility::checkEmptyArrayItem($warehouse, $i, '0');
                        $poDbData['reserved_quantity'] = Utility::checkEmptyArrayItem($quantityReserved, $i, '');
                        $poDbData['received_quantity'] = Utility::checkEmptyArrayItem($quantityReceived, $i, '');
                        $poDbData['planned_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($planned, $i, ''));
                        $poDbData['promised_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($promised, $i, ''));
                        $poDbData['expected_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($expected, $i, ''));
                        $poDbData['po_status'] = Utility::checkEmptyArrayItem($shipStatus, $i, '');
                        $poDbData['po_status_comment'] = Utility::checkEmptyArrayItem($statusComment, $i, '');
                        $poDbData['status_comment_history'] = json_encode($statComHist, true);
                        $poDbData['blanket_order_no'] = Utility::checkEmptyArrayItem($bOrderNo, $i, '');
                        $poDbData['blanket_order_line_no'] = Utility::checkEmptyArrayItem($bOrderLineNo, $i, '');
                        $poDbData['status'] = Utility::STATUS_ACTIVE;
                        $poDbData['created_by'] = Auth::user()->id;

                        PurchaseOrder::create($poDbData);

                    }



                }

            }


            if($mailOption == Utility::STATUS_ACTIVE){
                $poId = $mainPo->id;
                $getPo = PoExtension::firstRow('id',$poId);
                $getPoData = PurchaseOrder::specialColumns('uid',$getPo->uid);
                Utility::fetchBOMItems($getPoData);
                $currencyData = Currency::firstRow('id',$getPo->trans_curr);

                $mailContent = [];

                $mailCopyContent = ($mailCopy != '') ? explode(',',$mailCopy) : [];
                $mailContent['copy'] = $mailCopyContent;
                $mailContent['fromEmail']= Auth::user()->email;
                $mailContent['po']= $getPo;
                $mailContent['poData'] = $getPoData;
                $mailContent['attachment'] = $mailFiles;
                $mailContent['currency'] = $currencyData->code;

                //CHECK IF MAIL IS EMPTY ELSE CONTINUE TO SEND MAIL
                if($emails != ''){
                    $mailToArray = explode(',',$emails);
                    if(count($mailToArray) >0){ //SEND MAIL TO ALL INVOLVED IN THE PURCHASE ORDER
                        foreach($mailToArray as $data) {
                            Notify::poMail('mail_views.purchase_order', $mailContent, $data, Auth::user()->firstname.' '.Auth::user()->lastname, 'Purchase Order');
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

    //CONVERT QUOTE TO PURCHASE ORDER
    public function convertQuote(Request $request)
    {
        //
        $validator = Validator::make($request->all(),PurchaseOrder::$mainRules);
        if($validator->passes()){


            //ITEM VARIABLES
            $invClass = Utility::jsonUrlDecode($request->input('inv_class_edit')); $itemDesc = Utility::jsonUrlDecode($request->input('item_desc_edit'));
            $warehouse = Utility::jsonUrlDecode($request->input('warehouse_edit')); $quantity = Utility::jsonUrlDecode($request->input('quantity_edit'));
            $unitCost = Utility::jsonUrlDecode($request->input('unit_cost_edit')); $unitMeasure = Utility::jsonUrlDecode($request->input('unit_measure_edit'));
            $quantityReserved = Utility::jsonUrlDecode($request->input('quantity_reserved_edit')); $quantityReceived = Utility::jsonUrlDecode($request->input('quantity_received_edit'));
            $planned = Utility::jsonUrlDecode($request->input('planned_edit')); $expected = Utility::jsonUrlDecode($request->input('expected_edit'));
            $promised = Utility::jsonUrlDecode($request->input('promised_edit')); $bOrderNo = Utility::jsonUrlDecode($request->input('b_order_no_edit'));
            $bOrderLineNo = Utility::jsonUrlDecode($request->input('b_order_line_no_edit')); $shipStatus = Utility::jsonUrlDecode($request->input('ship_status_edit'));
            $statusComment = Utility::jsonUrlDecode($request->input('status_comment_edit')); $tax = Utility::jsonUrlDecode($request->input('tax_edit'));
            $taxPerct = Utility::jsonUrlDecode($request->input('tax_perct_edit')); $taxAmount = Utility::jsonUrlDecode($request->input('tax_amount_edit'));
            $discountPerct = Utility::jsonUrlDecode($request->input('discount_perct_edit')); $discountAmount = Utility::jsonUrlDecode($request->input('discount_amount_edit'));
            $subTotal = Utility::jsonUrlDecode($request->input('sub_total_edit'));

            //ACCOUNT VARIABLES
            $accClass = Utility::jsonUrlDecode($request->input('acc_class_edit')); $accDesc = Utility::jsonUrlDecode($request->input('acc_desc_edit'));
            $accRate = Utility::jsonUrlDecode($request->input('acc_rate_edit')); $accTax = Utility::jsonUrlDecode($request->input('acc_tax_edit'));
            $accTaxPerct = Utility::jsonUrlDecode($request->input('acc_tax_perct_edit')); $accTaxAmount = Utility::jsonUrlDecode($request->input('acc_tax_amount_edit'));
            $accDiscountPerct = Utility::jsonUrlDecode($request->input('acc_discount_perct_edit')); $accDiscountAmount = Utility::jsonUrlDecode($request->input('acc_discount_amount_edit'));
            $accSubTotal = Utility::jsonUrlDecode($request->input('acc_sub_total_edit'));

            //GENERAL VARIABLES
            $postingDate = $request->input('posting_date'); $prefVendor = $request->input('pref_vendor'); $dueDate = $request->input('due_date');
            $poStatus = $request->input('po_status'); $vendorInvoiceNo = $request->input('vendor_invoice_no'); $purchaseOrderNo = $request->input('po_number');
            $user = $request->input('user'); $shipCountry = $request->input('ship_country'); $shipCity = $request->input('ship_city');
            $shipContact = $request->input('ship_contact'); $shipAgent = $request->input('ship_agent'); $shipMethod = $request->input('ship_method');
            $shipAddress = $request->input('ship_address'); $grandTotal = $request->input('grand_total'); $grandTotalVendorCurr = $request->input('grand_total_vendor_curr');
            $mailOption = $request->input('mail_option'); $emails = $request->input('emails'); $file = $request->input('file');
            $message = Utility::urlDecode($request->input('mail_message')); $oneTimeDiscount = $request->input('one_time_discount_amount_edit'); $oneTimeDiscountPerct = $request->input('one_time_discount_perct_edit');
            $oneTimeTaxAmount = $request->input('one_time_tax_amount_edit'); $taxType = $request->input('tax_type');
            $discountType = $request->input('discount_type'); $oneTimeTaxPerct = $request->input('one_time_tax_perct_edit');
            $rfqNo = $request->input('rfq_no'); $mailCopy = $request->input('mail_copy');


            if (count($accClass) != count($accRate) && count($invClass) != count($subTotal)) {

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Please ensure to enter rate or/and quantity for each item/account'
                ]);

            }

            $vendor = VendorCustomer::firstRow('id',$prefVendor);
            $curr = Currency::firstRow('id',$vendor->currency_id);
            $files = $request->file('file');
            $mailFiles = [];

            $editId = $request->input('edit_id');
            $editData = QuoteExtension::firstRow('id',$editId);
            $uid = Utility::generateUID('po_extention');
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
                'uid' => $uid,
                'assigned_user' => $user,
                'po_number' => $purchaseOrderNo,
                'vendor_invoice_no' => $vendorInvoiceNo,
                'mails' => $emails,
                'mail_copy' => $mailCopy,
                'rfq_no' => $rfqNo,
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
                'vendor' => $prefVendor,
                'due_date' => Utility::standardDate($dueDate),
                'post_date' => Utility::standardDate($postingDate),
                'ship_to_city' => $shipCity,
                'ship_address' => $shipAddress,
                'ship_to_country' => $shipCountry,
                'ship_to_contact' => $shipContact,
                'ship_method' => $shipMethod,
                'ship_agent' => $shipAgent,
                'purchase_status' => $poStatus,
                'created_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];

            $mainPo = PoExtension::create($dbDATA);
            $countExtAcc = $request->input('count_ext_acc');
            $countExtPo = $request->input('count_ext_po');

            $accDbDataEdit['po_id'] = $mainPo->id;
            $poDbDataEdit['po_id'] = $mainPo->id;

            if($countExtPo > 0){

                for ($i = 1; $i <= $countExtPo; $i++) {
                    if (!empty($request->input('inv_class' . $i))) {
                        $binStock = Inventory::firstRow('id', $request->input('inv_class' . $i));
                        $poDbDataEdit['uid'] = $uid;
                        $poDbDataEdit['item_id'] = $request->input('inv_class' . $i);
                        $poDbDataEdit['bin_stock'] = $binStock->inventory_type;
                        $poDbDataEdit['unit_measurement'] = $request->input('unit_measure' . $i);
                        $poDbDataEdit['quantity'] = $request->input('quantity' . $i);
                        $poDbDataEdit['po_desc'] = $request->input('item_desc' . $i);
                        $poDbDataEdit['unit_cost_trans'] = $request->input('unit_cost' . $i);
                        $poDbDataEdit['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('unit_cost' . $i), 0), $postingDate);
                        $poDbDataEdit['tax_id'] = Utility::checkEmptyItem($request->input('tax' . $i), 0);
                        $poDbDataEdit['tax_perct'] = Utility::checkEmptyItem($request->input('tax_perct' . $i), 0);
                        $poDbDataEdit['tax_amount_trans'] = Utility::checkEmptyItem($request->input('tax_amount' . $i), 0);
                        $poDbDataEdit['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('tax_amount' . $i), 0), $postingDate);
                        $poDbDataEdit['discount_amount_trans'] = Utility::checkEmptyItem($request->input('discount_amount' . $i), 0);
                        $poDbDataEdit['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('discount_amount' . $i), 0), $postingDate);
                        $poDbDataEdit['discount_perct'] = Utility::checkEmptyItem($request->input('discount_perct' . $i), 0);
                        $poDbDataEdit['extended_amount_trans'] = Utility::checkEmptyItem($request->input('sub_total' . $i), 0);
                        $poDbDataEdit['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('sub_total' . $i), 0), $postingDate);
                        $poDbDataEdit['uid'] = $uid;
                        $statComHist = [];
                        if (Utility::checkEmptyItem($request->input('ship_status' . $i), 0) != 0) {
                            $statComHist[Utility::checkEmptyItem($request->input('ship_status' . $i), 0)] = Utility::checkEmptyItem($request->input('status_comment' . $i), '');

                        }

                        $poDbDataEdit['ship_to_whse'] = Utility::checkEmptyItem($request->input('warehouse' . $i), '0');
                        $poDbDataEdit['reserved_quantity'] = Utility::checkEmptyItem($request->input('quantity_reserved' . $i), '');
                        $poDbDataEdit['received_quantity'] = Utility::checkEmptyItem($request->input('quantity_received' . $i), '');
                        $poDbDataEdit['planned_receipt_date'] = Utility::standardDate(Utility::checkEmptyItem($request->input('planned' . $i), '0000-00-00'));
                        $poDbDataEdit['promised_receipt_date'] = Utility::standardDate(Utility::checkEmptyItem($request->input('promised' . $i), '0000-00-00'));
                        $poDbDataEdit['expected_receipt_date'] = Utility::standardDate(Utility::checkEmptyItem($request->input('expected' . $i), '0000-00-00'));
                        $poDbDataEdit['po_status'] = Utility::checkEmptyItem($request->input('ship_status' . $i), '');
                        $poDbDataEdit['po_status_comment'] = Utility::checkEmptyItem($request->input('status_comment' . $i), '');
                        $poDbDataEdit['status_comment_history'] = json_encode($statComHist, true);
                        $poDbDataEdit['blanket_order_no'] = Utility::checkEmptyItem($request->input('blanket_order_no' . $i), '');
                        $poDbDataEdit['blanket_order_line_no'] = Utility::checkEmptyItem($request->input('blanket_order_line_no' . $i), '');
                        $poDbDataEdit['created_by'] = Auth::user()->id;
                        $poDbDataEdit['status'] = Utility::STATUS_ACTIVE;

                        PurchaseOrder::create($poDbDataEdit);
                    }

                }

            }

            if($countExtAcc > 0){

                for ($i = 1; $i <= $countExtAcc; $i++) {

                    if (!empty($request->input('acc_class' . $i))) {
                        $accDbDataEdit['uid'] = $uid;
                        $accDbDataEdit['account_id'] = $request->input('acc_class' . $i);
                        $accDbDataEdit['po_desc'] = $request->input('item_desc_acc' . $i);
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
                        $accDbDataEdit['created_by'] = Auth::user()->id;
                        $accDbDataEdit['status'] = Utility::STATUS_ACTIVE;

                        PurchaseOrder::create($accDbDataEdit);
                    }

                }

            }
            //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

            $accDbData = [];
            $poDbData = [];

            $accDbData['po_id'] = $mainPo->id;
            $accDbData['uid'] = $uid;


            /*return response()->json([
                'message' => 'good',
                'message2' =>  json_encode($gg).'count='.$countExtAcc  //json_encode($request->all(),true)
            ]);*/



            //LOOP THROUGH ACCOUNTS
            if(!empty($accClass)) {
                if (count($accClass) == count($accRate) && count($accSubTotal) == count($accClass)) {
                    for ($i = 0; $i < count($accClass); $i++) {
                        $accDbData['uid'] = $uid;
                        $accDbData['account_id'] = Utility::checkEmptyArrayItem($accClass, $i, 0);
                        $accDbData['po_desc'] = Utility::checkEmptyArrayItem($accDesc, $i, '');
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

                        PurchaseOrder::create($accDbData);

                    }

                }

            }

            //LOOP THROUGH ITEMS
            $poDbData['po_id'] = $mainPo->id;
            $poDbData['uid'] = $uid;

            /*return response()->json([
                'message' => 'good',
                'message2' =>   json_encode($taxPerct)    //json_encode($request->all(),true)
            ]);*/
            if(!empty($invClass)) {
                if (count($invClass) == count($subTotal)) {
                    for ($i = 0; $i < count($invClass); $i++) {
                        $binStock = Inventory::firstRow('id', $invClass);
                        $poDbData['uid'] = $uid;
                        $poDbData['item_id'] = Utility::checkEmptyArrayItem($invClass, $i, 0);
                        $poDbData['bin_stock'] = $binStock->inventory_type;
                        $poDbData['unit_measurement'] = Utility::checkEmptyArrayItem($unitMeasure, $i, 0);
                        $poDbData['quantity'] = Utility::checkEmptyArrayItem($quantity, $i, 0);
                        $poDbData['po_desc'] = Utility::checkEmptyArrayItem($itemDesc, $i, '');
                        $poDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($unitCost, $i, 0);
                        $poDbData['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($unitCost, $i, 0), $postingDate);
                        $poDbData['tax_id'] = Utility::checkEmptyArrayItem($tax, $i, 0);
                        $poDbData['tax_perct'] = Utility::checkEmptyArrayItem($taxPerct, $i, 0);
                        $poDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($taxAmount, $i, 0);
                        $poDbData['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($taxAmount, $i, 0), $postingDate);
                        $poDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($discountAmount, $i, 0);
                        $poDbData['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($discountAmount, $i, 0), $postingDate);
                        $poDbData['discount_perct'] = Utility::checkEmptyArrayItem($discountPerct, $i, 0);
                        $poDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($subTotal, $i, 0);
                        $poDbData['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($subTotal, $i, 0), $postingDate);

                        $statComHist = [];
                        if (Utility::checkEmptyArrayItem($shipStatus, $i, 0) != 0) {
                            $statComHist[Utility::checkEmptyArrayItem($shipStatus, $i, 0)] = Utility::checkEmptyArrayItem($statusComment, $i, '');

                        }

                        $poDbData['ship_to_whse'] = Utility::checkEmptyArrayItem($warehouse, $i, '0');
                        $poDbData['reserved_quantity'] = Utility::checkEmptyArrayItem($quantityReserved, $i, '');
                        $poDbData['received_quantity'] = Utility::checkEmptyArrayItem($quantityReceived, $i, '');
                        $poDbData['planned_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($planned, $i, ''));
                        $poDbData['promised_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($promised, $i, ''));
                        $poDbData['expected_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($expected, $i, ''));
                        $poDbData['po_status'] = Utility::checkEmptyArrayItem($shipStatus, $i, '');
                        $poDbData['po_status_comment'] = Utility::checkEmptyArrayItem($statusComment, $i, '');
                        $poDbData['status_comment_history'] = json_encode($statComHist, true);
                        $poDbData['blanket_order_no'] = Utility::checkEmptyArrayItem($bOrderNo, $i, '');
                        $poDbData['blanket_order_line_no'] = Utility::checkEmptyArrayItem($bOrderLineNo, $i, '');
                        $poDbData['status'] = Utility::STATUS_ACTIVE;
                        $poDbData['created_by'] = Auth::user()->id;

                        PurchaseOrder::create($poDbData);

                    }

                }

            }


            if($mailOption == Utility::STATUS_ACTIVE){
                $poId = $mainPo->id;
                $getPo = PoExtension::firstRow('id',$poId);
                $getPoData = PurchaseOrder::specialColumns('uid',$getPo->uid);
                Utility::fetchBOMItems($getPoData);
                $currencyData = Currency::firstRow('id',$getPo->trans_curr);

                $mailContent = [];

                $mailCopyContent = ($mailCopy != '') ? explode(',',$mailCopy) : [];
                $mailContent['copy'] = $mailCopyContent;
                $mailContent['fromEmail']= Auth::user()->email;
                $mailContent['po']= $getPo;
                $mailContent['poData'] = $getPoData;
                $mailContent['attachment'] = $mailFiles;
                $mailContent['currency'] = $currencyData->code;

                //CHECK IF MAIL IS EMPTY ELSE CONTINUE TO SEND MAIL
                if($emails != ''){
                    $mailToArray = explode(',',$emails);
                    if(count($mailToArray) >0){ //SEND MAIL TO ALL INVOLVED IN THE PURCHASE ORDER
                        foreach($mailToArray as $data) {
                            Notify::poMail('mail_views.purchase_order', $mailContent, $data, Auth::user()->firstname.' '.Auth::user()->lastname, 'Purchase Order');
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

        $delete = PurchaseOrder::deleteItem($id);

        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
        ]);

    }

    //DATA NOT REQUIRED TO BE DELETED FROM DATABASE
    public function permDeleteConvert(Request $request)
    {
        //
        $id = $request->input('dataId');

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
        $oldData = PoExtension::firstRow('id',$editId);

        $dbData = [
            'attachment' => Utility::removeJsonItem($oldData->attachment,$file_name)
        ];
        $save = PoExtension::defaultUpdate('id',$editId,$dbData);

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

    public function searchPo(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = PoExtension::searchPo($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->uid;
        }
        /*for($i=0;$i<count($search);$i++){
            $obtain_array[] = $search[$i]->id;
        }*/
        //print_r($search); exit();
        $user_ids = array_unique($obtain_array);
        $mainData =  PoExtension::massDataPaginate('uid', $user_ids);
        //print_r($obtain_array); die();
        if (count($user_ids) > 0) {

            return view::make('purchase_order.search_po')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
        }

    }


    public function destroy(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));

        foreach($idArray as $data){
            $dataChild = PurchaseOrder::specialColumns('po_id',$data);
            if(!empty($dataChild)){
                foreach($dataChild as $child){
                    $delete = PurchaseOrder::deleteItem($child->id);
                }
            }
            $delete = PoExtension::deleteItem($data);
        }


        return response()->json([
            'message' => 'deleted',
            'message2' => 'Data deleted successfully'
        ]);

    }


}
