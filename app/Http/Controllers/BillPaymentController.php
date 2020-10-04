<?php

namespace App\Http\Controllers;

use App\Helpers\Finance;
use App\Helpers\Utility;
use App\Helpers\Notify;
use App\model\VendorCustomer;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Input;
use Hash;
use DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\model\AccountJournal;
use App\model\JournalExtension;
use App\model\Currency;
use App\model\TransClass;
use App\model\TransLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class BillPaymentController extends Controller
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
        $mainData = JournalExtension::specialColumnsPage2('transaction_type',Finance::bill,'journal_status',Utility::OPEN_ACCOUNT_STATUS);
        $transClass = TransClass::getAllData();
        $transLocation = TransLocation::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('bill_payment.reload',array('mainData' => $mainData,
            'transLocation' => $transLocation,'transClass' => $transClass))->render());

        }else{
            return view::make('bill_payment.main_view')->with('mainData',$mainData)
                        ->with('transClass',$transClass)->with('transLocation',$transLocation);
        }

    }

    public function billPayments(Request $request)
    {
        //
        //$req = new Request();
        $mainData = JournalExtension::specialColumnsPage('transaction_type',Finance::existingBillCashPayment);
        Finance::addBalanceToObj($mainData);
        if ($request->ajax()) {
            return \Response::json(view::make('bill_payment.payment_reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('bill_payment.payment')->with('mainData',$mainData);
        }

    }

    public function printPreview(Request $request)
    {
        //
        $currency = Utility::defaultCurrency();
        $type = $request->input('type');
        $payment = JournalExtension::firstRow('id',$request->input('dataId'));
        $bill = JournalExtension::firstRow('id',$payment->journal_id);
        $poData = AccountJournal::specialColumns2('extension_id',$payment->journal_id,'main_trans',Utility::MAIN_TRANSACTION);
        Utility::fetchBOMItems($poData);
        if($type == 'vendor' && !empty($payment)){
            $data = Currency::firstRow('id',$payment->trans_curr);
            $currency = $data->code;

            return view::make('bill_payment.print_preview_customer')->with('po',$bill)->with('poData',$poData)
                ->with('currency',$currency)->with('payment',$payment);
        }
        return view::make('bill_payment.print_preview_default')->with('po',$bill)->with('poData',$poData)
            ->with('currency',$currency)->with('payment',$payment);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),JournalExtension::$billPaymentRules);

        if($validator->passes()){

           
            Finance::inflowOutflow($request); //RUN BILL PAYMENT OPERATIONS        

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
        $allId = json_decode($request->input('all_data'));
        $journalEntry = JournalExtension::massData('id',$allId);
        $transClass = TransClass::getAllData();
        $transLocation = TransLocation::getAllData();
        $this->getCreditBalance($journalEntry);
        
        return view::make('bill_payment.edit_form')->with('journalEntry',$journalEntry)->with('transClass',$transClass)
        ->with('transLocation',$transLocation);

    }

    public function getCreditBalance($dataObj){
        $contact = 0; $contactArr = [];
        foreach($dataObj as $data){
            $contact = $data->vendor_customer;
            $creditBal = JournalExtension::sumColumnDataCondition2('vendor_customer',$data->vendor_customer,'transaction_type',finance::vendorCredit,'balance_trans');
            
            if(!in_array($contact,$contactArr)){
                $contactArr[$contact] = (!empty($creditBal)) ? Utility::roundNum($creditBal) : 0.00;
                $data->creditBalance = (!empty($creditBal)) ? Utility::roundNum($creditBal) : 0.00;
            }
        }
        return $dataObj;
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function searchOpenBill(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = JournalExtension::searchOpenTransaction($_GET['searchVar'],Finance::bill);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->uid;
        }
        
        //print_r($obtain_array); exit();
        $unique_ids = array_unique($obtain_array);
        $mainData =  JournalExtension::massDataPaginate('uid', $unique_ids);
        //print_r($search); die();
        if (count($unique_ids) > 0) {

            return view::make('bill_payment.search')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
        }

    }

    public function searchBillPayments(Request $request)
    {
        //        
        $search = JournalExtension::search($_GET['searchVar'],Finance::existingBillCashPayment);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->uid;
        }
        
        //print_r($obtain_array); exit();
        $unique_ids = array_unique($obtain_array);
        $mainData =  JournalExtension::massDataPaginate('uid', $unique_ids);
        //print_r($search); die();
        if (count($unique_ids) > 0) {

            return view::make('bill_payment.search_payment')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
        }

    }


}
