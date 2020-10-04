<?php

namespace App\Http\Controllers;

use App\Helpers\Finance;
use App\Helpers\Utility;
use App\Helpers\Notify;
use App\model\Currency;
use App\model\Inventory;
use App\model\cashReceiptExtension;
use App\model\cashReceipt;
use App\model\Stock;
use App\model\VendorCustomer;
use App\model\Warehouse;
use App\model\Tax;
use App\model\WarehouseEmployee;
use App\model\WarehouseReceipt;
use App\model\WhsePickPutAway;
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
use App\model\JournalTransactionFormat;
use App\model\PoExtension;
use App\model\PurchaseOrder;
use App\model\SalesExtension;
use App\model\SalesOrder;
use App\model\TransClass;
use App\model\TransLocation;
use App\model\UnitMeasure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class CashRefundReceiptController extends Controller
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
        $mainData = JournalExtension::specialColumnsPage('transaction_type',Finance::refundReceipt);
        $paymentMethod = JournalTransactionFormat::getAllData();
        $transClass = TransClass::getAllData();
        $transLocation = TransLocation::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('cash_refund_receipt.reload',array('mainData' => $mainData,'paymentMethod' => $paymentMethod,
            'transLocation' => $transLocation,'transClass' => $transClass))->render());

        }else{
            return view::make('cash_refund_receipt.main_view')->with('mainData',$mainData)->with('paymentMethod',$paymentMethod)
                        ->with('transClass',$transClass)->with('transLocation',$transLocation);
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
        $validator = Validator::make($request->all(),JournalExtension::$refundReceiptRules);

        if($validator->passes()){

           
            Finance::refundReceipt($request); //RUN CASH REFUND RECEIPT OPERATIONS        

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
        $cashReceipt = JournalExtension::firstRow('id',$request->input('dataId'));
        $paymentMethod = JournalTransactionFormat::getAllData();
        $transClass = TransClass::getAllData();
        $transLocation = TransLocation::getAllData();
        $cashReceiptData = AccountJournal::specialColumns('extension_id',$cashReceipt->id);
        return view::make('cash_refund_receipt.edit_form')->with('edit',$cashReceipt)->with('cashReceiptData',$cashReceiptData)
        ->with('paymentMethod',$paymentMethod)->with('transClass',$transClass)->with('transLocation',$transLocation);

    }

     //FETCH SALES ORDER DATA FOR DISPLAY IN CONVERT TO FORM MODAL DISPLAY
     public function convertSalesForm(Request $request)
     {
         //
         $sales = SalesExtension::firstRow('id',$request->input('dataId'));
         $paymentMethod = JournalTransactionFormat::getAllData();
         $transClass = TransClass::getAllData();
         $transLocation = TransLocation::getAllData();
         $salesData = SalesOrder::specialColumns('sales_id',$sales->id);
         return view::make('cash_refund_receipt.convert_sales_form')->with('edit',$sales)->with('salesData',$salesData)
         ->with('paymentMethod',$paymentMethod)->with('transClass',$transClass)->with('transLocation',$transLocation);
 
     }
 
     //FETCH PO DATA FOR DISPLAY IN CONVERT TO FORM MODAL DISPLAY
     public function convertPoForm(Request $request)
     {
         //
         $po = PoExtension::firstRow('id',$request->input('dataId'));
         $paymentMethod = JournalTransactionFormat::getAllData();
         $transClass = TransClass::getAllData();
         $transLocation = TransLocation::getAllData();
         $poData = PurchaseOrder::specialColumns('po_id',$po->id);
         $unitMeasure = UnitMeasure::paginateAllData();
         return view::make('cash_refund_receipt.convert_po_form')->with('edit',$po)->with('poData',$poData)
             ->with('unitMeasure',$unitMeasure)->with('paymentMethod',$paymentMethod)->with('transClass',$transClass)
             ->with('transLocation',$transLocation);
 
     }
 


    public function printPreview(Request $request)
    {
        //
        $currency = Utility::defaultCurrency();
        $type = $request->input('type');
        $cashReceipt = JournalExtension::firstRow('id',$request->input('dataId'));
        $poData = AccountJournal::specialColumns2('extension_id',$cashReceipt->id,'main_trans',Utility::MAIN_TRANSACTION);
        Utility::fetchBOMItems($poData);
        if($type == 'customer' && !empty($cashReceipt)){
            $data = Currency::firstRow('id',$cashReceipt->trans_curr);
            $currency = $data->code;

            return view::make('cash_refund_receipt.print_preview_customer')->with('po',$cashReceipt)->with('poData',$poData)
                ->with('currency',$currency);
        }
        return view::make('cash_refund_receipt.print_preview_default')->with('po',$cashReceipt)->with('poData',$poData)
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
        $validator = Validator::make($request->all(),JournalExtension::$refundReceiptRules);
        if($validator->passes()){
               
            Finance::refundReceipt($request); //RUN cashReceipt OPERATIONS 

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
        $oldData = JournalExtension::firstRow('id',$editId);

        $dbData = [
            'attachment' => Utility::removeJsonItem($oldData->attachment,$file_name)
        ];
        $save = JournalExtension::defaultUpdate('id',$editId,$dbData);

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

    public function searchcashReceipt(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = JournalExtension::search($_GET['searchVar'],Finance::refundReceipt);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->uid;
        }
        
        //print_r($obtain_array); exit();
        $unique_ids = array_unique($obtain_array);
        $mainData =  JournalExtension::massDataPaginate('uid', $unique_ids);
        //print_r($search); die();
        if (count($unique_ids) > 0) {

            return view::make('cash_refund_receipt.search')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
        }

    }


    public function destroy(Request $request)
    {
        //REMOVE TRANSACTION
       Finance::destroyJournalTransaction($request);

    }

}
