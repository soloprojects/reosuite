<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Helpers\Notify;
use App\model\Currency;
use App\model\Inventory;
use App\model\RFQ;
use App\model\RFQExtension;
use App\model\Stock;
use App\model\UnitMeasure;
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
use Illuminate\Support\Facades\Log;

class RFQController extends Controller
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
        $mainData = RFQExtension::specialColumnsPage('created_by',Auth::user()->id);
        $unitMeasure = UnitMeasure::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('rfq.reload',array('mainData' => $mainData,
                'unitMeasure' => $unitMeasure))->render());

        }else{
            return view::make('rfq.main_view')->with('mainData',$mainData)->with('unitMeasure',$unitMeasure);
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
        $validator = Validator::make($request->all(),RFQExtension::$mainRules);

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
             $quantity = Utility::jsonUrlDecode($request->input('quantity')); $unitMeasure = Utility::jsonUrlDecode($request->input('unit_measure'));

            //ACCOUNT VARIABLES
            $accClass = Utility::jsonUrlDecode($request->input('acc_class'));
            $accDesc = Utility::jsonUrlDecode($request->input('acc_desc'));

            //GENERAL VARIABLES
            $dueDate = $request->input('due_date'); $mailOption = $request->input('mail_option');
            $emails = $request->input('emails'); $file = $request->input('file');
            $message = Utility::urlDecode($request->input('mail_message')); $rfqNo = $request->input('rfq_no');
            $mailCopy = $request->input('mail_copy'); $user = $request->input('user');

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

            $uid = Utility::generateUID('rfq_extention');

            $dbDATA = [
                'uid' => $uid,
                'assigned_user' => $user,
                'rfq_no' => $rfqNo,
                'mails' => $emails,
                'mail_copy' => $mailCopy,
                'message' => $message,
                'attachment' => json_encode($attachment,true),
                'due_date' => Utility::standardDate($dueDate),
                'created_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            $accDbData = [
                'uid' => $uid
            ];
            $rfqDbData = [
                'uid' => $uid
            ];

            /*return response()->json([
                'message' => 'warning',
                'message2' => json_encode($request->all())
            ]);*/

            /*return response()->json([
                'message' => 'warning',
                'message2' => json_encode($invClass)
            ]);*/
            if(!empty($accClass)) {

                $mainRfq = RFQExtension::create($dbDATA);
                $accDbData['rfq_id'] = $mainRfq->id;
                $rfqDbData['rfq_id'] = $mainRfq->id;

                //LOOP THROUGH ACCOUNTS
                if(!empty($accClass)){
                    for($i=0;$i<count($accClass);$i++){
                        $accDbData['account_id'] = Utility::checkEmptyArrayItem($accClass,$i,0);
                        $accDbData['rfq_desc'] = Utility::checkEmptyArrayItem($accDesc,$i,'');
                        $accDbData['status'] = Utility::STATUS_ACTIVE;
                        $accDbData['created_by'] = Auth::user()->id;

                        RFQ::create($accDbData);

                    }

                }

                //LOOP THROUGH ITEMS
                if(!empty($invClass)){
                    for($i=0;$i<count($invClass);$i++){
                        $rfqDbData['item_id'] = Utility::checkEmptyArrayItem($invClass,$i,0);
                        $rfqDbData['unit_measurement'] = Utility::checkEmptyArrayItem($unitMeasure,$i,0);
                        $rfqDbData['quantity'] = Utility::checkEmptyArrayItem($quantity,$i,0);
                        $rfqDbData['rfq_desc'] = Utility::checkEmptyArrayItem($itemDesc,$i,'');
                        $rfqDbData['status'] = Utility::STATUS_ACTIVE;
                        $rfqDbData['created_by'] = Auth::user()->id;

                        RFQ::create($rfqDbData);

                    }

                }

                /* return response()->json([
                 'message' => 'warning',
                 'message2' => json_encode($poDbData)
             ]);*/

                if($mailOption == Utility::STATUS_ACTIVE){
                    $rfqId = $mainRfq->id;
                    $getRfq = RFQExtension::firstRow('id',$rfqId);
                    $getRfqData = RFQ::specialColumns('uid',$getRfq->uid);
                    $currencyData = Currency::firstRow('id',$getRfq->trans_curr);

                    $mailContent = [];

                    $mailCopyContent = ($mailCopy != '') ? explode(',',$mailCopy) : [];
                    $mailContent['copy'] = $mailCopyContent;              
                    $mailContent['fromEmail']= Auth::user()->email;
                    $mailContent['rfq']= $getRfq;
                    $mailContent['rfqData'] = $getRfqData;
                    $mailContent['attachment'] = $mailFiles;
                    $mailContent['currency'] = $currencyData->currency;

                    //CHECK IF MAIL IS EMPTY ELSE CONTINUE TO SEND MAIL
                    if($emails != ''){
                        $mailToArray = explode(',',$emails);
                        if(count($mailToArray) >0){ //SEND MAIL TO ALL INVOLVED IN THE PURCHASE ORDER
                            foreach($mailToArray as $data) {
                                Notify::rfqMail('mail_views.rfq', $mailContent, $data, Auth::user()->firstname.' '.Auth::user()->lastname, 'Request for Quote');
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
        $rfq = RFQExtension::firstRow('id',$request->input('dataId'));
        $rfqData = RFQ::specialColumns('rfq_id',$rfq->id);
        $unitMeasure = UnitMeasure::paginateAllData();
        return view::make('rfq.edit_form')->with('edit',$rfq)->with('rfqData',$rfqData)
            ->with('unitMeasure',$unitMeasure);

    }

    public function printPreview(Request $request)
    {
        //
        $currency = Utility::defaultCurrency();
        $type = $request->input('type');
        $rfq = RFQExtension::firstRow('id',$request->input('dataId'));
        $rfqData = RFQ::specialColumns('rfq_id',$rfq->id);
        Utility::fetchBOMItems($rfqData);

        return view::make('rfq.print_preview_default')->with('po',$rfq)->with('poData',$rfqData)
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
        $validator = Validator::make($request->all(),RFQ::$mainRules);
        if($validator->passes()){

            /*$countData = PoExtension::countData('po_number',$request->input('po_number'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry(PO number) already exist, please try another entry'
                ]);

            }*/

            //ITEM VARIABLES
            $invClass = Utility::jsonUrlDecode($request->input('inv_class_edit'));
            $itemDesc = Utility::jsonUrlDecode($request->input('item_desc_edit'));
            $quantity = Utility::jsonUrlDecode($request->input('quantity_edit'));
            $unitMeasure = Utility::jsonUrlDecode($request->input('unit_measure_edit'));


            //ACCOUNT VARIABLES
            $accClass = Utility::jsonUrlDecode($request->input('acc_class_edit'));
            $accDesc = Utility::jsonUrlDecode($request->input('acc_desc_edit'));

            //GENERAL VARIABLES
            $dueDate = $request->input('due_date'); $mailOption = $request->input('mail_option');
            $emails = $request->input('emails'); $file = $request->input('file');
            $message = Utility::urlDecode($request->input('mail_message')); $user = $request->input('user');
            $rfqNo = $request->input('rfq_no'); $mailCopy = $request->input('mail_copy');

            $files = $request->file('file');
            $mailFiles = [];

            $editId = $request->input('edit_id');
            $editData = RFQExtension::firstRow('id',$editId);
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
                'mails' => $emails,
                'mail_copy' => $mailCopy,
                'rfq_no' => $rfqNo,
                'message' => $message,
                'attachment' => json_encode($attachment,true),
                'due_date' => Utility::standardDate($dueDate),
                'updated_by' => Auth::user()->id,
            ];

            $mainPo = RFQExtension::defaultUpdate('id', $editId, $dbDATA);
            $countExtAcc = $request->input('count_ext_acc');
            $countExtPo = $request->input('count_ext_po');

            if($countExtPo > 0){

                for ($i = 1; $i <= $countExtPo; $i++) {
                    $rfqDbDataEdit = [];
                    if (!empty($request->input('inv_class' . $i))) {
                        $rfqDbDataEdit['item_id'] = $request->input('inv_class' . $i);
                        $rfqDbDataEdit['unit_measurement'] = $request->input('unit_measure' . $i);
                        $rfqDbDataEdit['quantity'] = $request->input('quantity' . $i);
                        $rfqDbDataEdit['rfq_desc'] = $request->input('item_desc' . $i);
                        $rfqDbDataEdit['updated_by'] = Auth::user()->id;

                        RFQ::defaultUpdate('id', $request->input('poId' . $i), $rfqDbDataEdit);
                    }

                }

            }

            if($countExtAcc > 0){

                for ($i = 1; $i <= $countExtAcc; $i++) {

                    if (!empty($request->input('acc_class' . $i))) {
                        $accDbDataEdit['account_id'] = $request->input('acc_class' . $i);
                        $accDbDataEdit['rfq_desc'] = $request->input('item_desc_acc' . $i);
                        $accDbDataEdit['updated_by'] = Auth::user()->id;

                        RFQ::defaultUpdate('id', $request->input('accId' . $i), $accDbDataEdit);
                    }

                }

            }
            //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

            $accDbData = [];
            $rfqDbData = [];

            $accDbData['rfq_id'] = $editId;
            $accDbData['uid'] = $uid;


            /*return response()->json([
                'message' => 'good',
                'message2' =>  json_encode($gg).'count='.$countExtAcc  //json_encode($request->all(),true)
            ]);*/



            //LOOP THROUGH ACCOUNTS
            if(!empty($accClass)) {
                if (!empty($accClass)) {
                    for ($i = 0; $i < count($accClass); $i++) {
                        $accDbData['account_id'] = Utility::checkEmptyArrayItem($accClass, $i, 0);
                        $accDbData['rfq_desc'] = Utility::checkEmptyArrayItem($accDesc, $i, '');
                        $accDbData['status'] = Utility::STATUS_ACTIVE;
                        $accDbData['created_by'] = Auth::user()->id;

                        RFQ::create($accDbData);

                    }

                }

            }

            //LOOP THROUGH ITEMS
            $rfqDbData['rfq_id'] = $editId;
            $rfqDbData['uid'] = $uid;
            $dda = '';

            /*return response()->json([
                'message' => 'good',
                'message2' =>   json_encode($taxPerct)    //json_encode($request->all(),true)
            ]);*/
            if(!empty($invClass)) {
                if (!empty($invClass)) {
                    for ($i = 0; $i < count($invClass); $i++) {
                        $rfqDbData['item_id'] = Utility::checkEmptyArrayItem($invClass, $i, 0);
                        $rfqDbData['unit_measurement'] = Utility::checkEmptyArrayItem($unitMeasure, $i, 0);
                        $rfqDbData['quantity'] = Utility::checkEmptyArrayItem($quantity, $i, 0);
                        $rfqDbData['rfq_desc'] = Utility::checkEmptyArrayItem($itemDesc, $i, '');
                        $rfqDbData['status'] = Utility::STATUS_ACTIVE;
                        $rfqDbData['created_by'] = Auth::user()->id;

                        RFQ::create($rfqDbData);

                    }



                }

            }

            
            if($mailOption == Utility::STATUS_ACTIVE){
                $rfqId = $editId;
                $getRfq = RFQExtension::firstRow('id',$rfqId);
                $getRfqData = RFQ::specialColumns('uid',$getRfq->uid);
                Utility::fetchBOMItems($getRfqData);
                
                $mailContent = [];

                $mailCopyContent = ($mailCopy != '') ? explode(',',$mailCopy) : [];
                $mailContent['copy'] = $mailCopyContent;                
                $mailContent['fromEmail']= Auth::user()->email;
                $mailContent['rfq']= $getRfq;
                $mailContent['rfqData'] = $getRfqData;
                $mailContent['attachment'] = $attachment;
                $mailContent['currency'] = '';
                
                //CHECK IF MAIL IS EMPTY ELSE CONTINUE TO SEND MAIL
                if($emails != ''){
                    $mailToArray = explode(',',$emails);
                    if(count($mailToArray) >0){ //SEND MAIL TO ALL INVOLVED IN THE PURCHASE ORDER
                        foreach($mailToArray as $data) {
                            Notify::rfqMail('mail_views.rfq', $mailContent, $data, Auth::user()->firstname.' '.Auth::user()->lastname, 'Purchase Order');
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

        $delete = RFQ::deleteItem($id);

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
        $oldData = RFQExtension::firstRow('id',$editId);

        $dbData = [
            'attachment' => Utility::removeJsonItem($oldData->attachment,$file_name)
        ];
        $save = RFQExtension::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message2' => 'saved',
            'message' => 'File have been removed'
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

    public function searchRfq(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = RFQExtension::searchRfq($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->id;
        }
        /*for($i=0;$i<count($search);$i++){
            $obtain_array[] = $search[$i]->id;
        }*/
        //print_r($search); exit();
        $user_ids = array_unique($obtain_array);
        $mainData =  RFQExtension::massDataPaginate('id', $user_ids);
        //print_r($obtain_array); die();
        if (count($user_ids) > 0) {

            return view::make('rfq.search_rfq')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
        }

    }


    public function destroy(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));

        foreach($idArray as $data){
            $dataChild = RFQ::specialColumns('rfq_id',$data);
            if(!empty($dataChild)){
                foreach($dataChild as $child){
                    $delete = RFQ::deleteItem($child->id);
                }
            }
            $delete = RFQExtension::deleteItem($data);
        }


        return response()->json([
            'message' => 'deleted',
            'message2' => 'Data deleted successfully'
        ]);

    }

}
