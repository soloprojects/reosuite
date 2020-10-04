<?php

namespace App\Http\Controllers;

use App\Helpers\Finance;
use App\Helpers\Utility;
use App\Helpers\Notify;
use App\model\Currency;
use App\model\Inventory;
use App\model\Stock;
use App\model\VendorCustomer;
use App\model\Tax;
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
use App\model\JournalTransactionTerms;
use App\model\PoExtension;
use App\model\PurchaseOrder;
use App\model\SalesExtension;
use App\model\SalesOrder;
use App\model\TransClass;
use App\model\TransLocation;
use App\model\UnitMeasure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class InvoiceController extends Controller
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
        $mainData = JournalExtension::specialColumnsPage('transaction_type',Finance::invoice);
        $terms = JournalTransactionTerms::getAllData();
        $transClass = TransClass::getAllData();
        $transLocation = TransLocation::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('invoice.reload',array('mainData' => $mainData,'terms' => $terms,
            'transLocation' => $transLocation,'transClass' => $transClass))->render());

        }else{
            return view::make('invoice.main_view')->with('mainData',$mainData)->with('terms',$terms)
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
        $validator = Validator::make($request->all(),JournalExtension::$invoiceRules);

        if($validator->passes()){

           
            Finance::invoice($request); //RUN INVOICE OPERATIONS        

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
        $invoice = JournalExtension::firstRow('id',$request->input('dataId'));
        $terms = JournalTransactionTerms::getAllData();
        $transClass = TransClass::getAllData();
        $transLocation = TransLocation::getAllData();
        $invoiceData = AccountJournal::specialColumns('extension_id',$invoice->id);
        return view::make('invoice.edit_form')->with('edit',$invoice)->with('invoiceData',$invoiceData)
        ->with('terms',$terms)->with('transClass',$transClass)->with('transLocation',$transLocation);

    }

     //FETCH SALES ORDER DATA FOR DISPLAY IN CONVERT TO FORM MODAL DISPLAY
     public function convertSalesForm(Request $request)
     {
         //
         $sales = SalesExtension::firstRow('id',$request->input('dataId'));
         $terms = JournalTransactionTerms::getAllData();
         $transClass = TransClass::getAllData();
         $transLocation = TransLocation::getAllData();
         $salesData = SalesOrder::specialColumns('sales_id',$sales->id);
         return view::make('invoice.convert_sales_form')->with('edit',$sales)->with('salesData',$salesData)
         ->with('terms',$terms)->with('transClass',$transClass)->with('transLocation',$transLocation);
 
     }
 
     //FETCH PO DATA FOR DISPLAY IN CONVERT TO FORM MODAL DISPLAY
     public function convertPoForm(Request $request)
     {
         //
         $po = PoExtension::firstRow('id',$request->input('dataId'));
         $terms = JournalTransactionTerms::getAllData();
         $transClass = TransClass::getAllData();
         $transLocation = TransLocation::getAllData();
         $poData = PurchaseOrder::specialColumns('po_id',$po->id);
         $unitMeasure = UnitMeasure::paginateAllData();
         return view::make('invoice.convert_po_form')->with('edit',$po)->with('poData',$poData)
             ->with('unitMeasure',$unitMeasure)->with('terms',$terms)->with('transClass',$transClass)
             ->with('transLocation',$transLocation);
 
     }
 


    public function printPreview(Request $request)
    {
        //
        $currency = Utility::defaultCurrency();
        $type = $request->input('type');
        $invoice = JournalExtension::firstRow('id',$request->input('dataId'));
        $poData = AccountJournal::specialColumns2('extension_id',$invoice->id,'main_trans',Utility::MAIN_TRANSACTION);
        Utility::fetchBOMItems($poData);
        if($type == 'customer' && !empty($invoice)){
            $data = Currency::firstRow('id',$invoice->trans_curr);
            $currency = $data->code;

            return view::make('invoice.print_preview_customer')->with('po',$invoice)->with('poData',$poData)
                ->with('currency',$currency);
        }
        return view::make('invoice.print_preview_default')->with('po',$invoice)->with('poData',$poData)
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
        $validator = Validator::make($request->all(),JournalExtension::$invoiceRules);
        if($validator->passes()){
               
            Finance::invoice($request); //RUN INVOICE OPERATIONS 

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

    public function searchinvoice(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = JournalExtension::search($_GET['searchVar'],Finance::invoice);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->uid;
        }
        
        //print_r($obtain_array); exit();
        $unique_ids = array_unique($obtain_array);
        $mainData =  JournalExtension::massDataPaginate('uid', $unique_ids);
        //print_r($search); die();
        if (count($unique_ids) > 0) {

            return view::make('invoice.search')->with('mainData',$mainData);
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
