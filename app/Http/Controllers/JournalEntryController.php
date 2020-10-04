<?php

namespace App\Http\Controllers;

use App\Helpers\Finance;
use App\Helpers\Utility;
use App\Helpers\Notify;
use App\model\Currency;
use App\model\Inventory;
use App\model\invoiceExtension;
use App\model\invoice;
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
use App\model\TransClass;
use App\model\TransLocation;
use App\model\UnitMeasure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class JournalEntryController extends Controller
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
        $mainData = JournalExtension::paginateAllData();
        $transClass = TransClass::getAllData();
        $transLocation = TransLocation::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('journal_entry.reload',array('mainData' => $mainData,
            'transLocation' => $transLocation,'transClass' => $transClass))->render());

        }else{
            return view::make('journal_entry.main_view')->with('mainData',$mainData)
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
        $validator = Validator::make($request->all(),JournalExtension::$journalEntryRules);

        if($validator->passes()){

           
            Finance::journalEntry($request); //RUN JOURNAL ENTRY OPERATIONS        

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
        $journalEntry = JournalExtension::firstRow('id',$request->input('dataId'));
        $terms = JournalTransactionTerms::getAllData();
        $transClass = TransClass::getAllData();
        $transLocation = TransLocation::getAllData();
        $journalEntryData = AccountJournal::specialColumns('extension_id',$journalEntry->id);
        return view::make('journal_entry.edit_form')->with('edit',$journalEntry)->with('journalEntryData',$journalEntryData)
        ->with('transClass',$transClass)->with('transLocation',$transLocation);

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
        $validator = Validator::make($request->all(),JournalExtension::$journalEntryRules);
        if($validator->passes()){
               
            Finance::journalEntry($request); //RUN JOURNAL ENTRY OPERATIONS 

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

    public function searchJournalEntry(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = JournalExtension::searchJournal($request->input('searchVar'));
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->uid;
        }
        
        //print_r($obtain_array); exit();
        $unique_ids = array_unique($obtain_array);
        $mainData =  JournalExtension::massDataPaginate('uid', $unique_ids);
        //print_r($search); die();
        if (count($unique_ids) > 0) {

            return view::make('journal_entry.search')->with('mainData',$mainData);
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
