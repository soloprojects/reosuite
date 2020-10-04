<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\model\AccountJournal;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\model\Currency;
use App\model\VendorCustomer;
use App\model\SalaryStructure;
use App\Helpers\Utility;
use App\User;
use App\model\Roles;
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

class VendorCustomerController extends Controller
{
    //
    public function indexVendor(Request $request)
    {
        //
        //$req = new Request();
        $mainData =  VendorCustomer::specialColumnsPage('company_type',Utility::VENDOR);
        $currency = Currency::getAllData();


        if ($request->ajax()) {
            return \Response::json(view::make('vendor_customer.reload',array('mainData' => $mainData,
                'currency' => $currency))->render());

        }else{
            return view::make('vendor_customer.main_view')->with('mainData',$mainData)
                ->with('currency',$currency);
        }

    }

    public function indexCustomer(Request $request)
    {
        //
        //$req = new Request();
        $mainData =  VendorCustomer::specialColumnsPage('company_type',Utility::CUSTOMER);
        $currency = Currency::getAllData();


        if ($request->ajax()) {
            return \Response::json(view::make('vendor_customer.reload_customer',array('mainData' => $mainData,
                'currency' => $currency))->render());

        }else{
            return view::make('vendor_customer.main_view_customer')->with('mainData',$mainData)
                ->with('currency',$currency);
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
        $validator = Validator::make($request->all(),VendorCustomer::$mainRules);
        if($validator->passes()){

            $countData = VendorCustomer::countData('name',$request->input('name'),'company_type',$request->input('contact_type'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                $photo = 'logo.jpg';
                $sign = '';
                if($request->hasFile('logo')){

                    $image = $request->file('photo');
                    $filename = date('Y-m-d-H-i-s')."_".$image->getClientOriginalName();
                    $path = Utility::IMG_URL().$filename;

                    Image::make($image->getRealPath())->resize(72,72)->save($path);
                    $photo = $filename;

                }

                $dbDATA = [
                    'email1' => ucfirst($request->input('email1')),
                    'email2' => ucfirst($request->input('email2')),
                    'name' => $request->input('name'),
                    'address' => ucfirst($request->input('address')),
                    'city' => ucfirst($request->input('city')),
                    'zip_code' => ucfirst($request->input('zip_code')),
                    'contact_no' => ucfirst($request->input('contact_no')),
                    'contact_name' => ucfirst($request->input('contact_name')),
                    'search_key' => ucfirst($request->input('search_key')),
                    'company_desc' => ucfirst($request->input('company_desc')),
                    'phone' => ucfirst($request->input('phone')),
                    'website' => ucfirst($request->input('website')),
                    'company_no' => ucfirst($request->input('company_no')),
                    'payment_terms' => $request->input('payment_terms'),
                    'tax_id_no' => $request->input('tax_id_no'),
                    'bank_name' => $request->input('bank_name'),
                    'account_no' => $request->input('account_no'),
                    'account_name' => ucfirst($request->input('account_name')),
                    'currency_id' => $request->input('currency'),
                    'company_type' => $request->input('contact_type'),
                    'logo' => $photo,
                    'created_by' => Auth::user()->id,
                    'active_status' => Utility::STATUS_ACTIVE,
                    'status' => Utility::STATUS_ACTIVE
                ];
                VendorCustomer::create($dbDATA);

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

        $currency = Currency::getAllData();
        $vendorCustomer = VendorCustomer::firstRow('id',$request->input('dataId'));
        return view::make('vendor_customer.edit_form')->with('edit',$vendorCustomer)->with('currency',$currency);

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
        $validator = Validator::make($request->all(),VendorCustomer::$mainRules);
        if($validator->passes()) {

            $photo = $request->get('prev_photo');

            Utility::checkVendorCustomerExistingLedgerTrans($request->input('edit_id'),$request->input('currency'));

            if($request->hasFile('photo')){

                $image = $request->file('photo');
                $filename = date('Y-m-d-H-i-s')."_".$image->getClientOriginalName();
                $path = Utility::IMG_URL().$filename;

                Image::make($image->getRealPath())->resize(72,72)->save($path);
                $photo = $filename;
                if($request->get('prev_logo') != 'logo.jpg'){
                    if(file_exists(Utility::IMG_URL().$request->get('prev_photo')))
                        unlink(Utility::IMG_URL().$request->get('prev_photo'));
                }

            }

            $dbDATA = [
                'email1' => ucfirst($request->input('email1')),
                'email2' => ucfirst($request->input('email2')),
                'name' => $request->input('name'),
                'address' => ucfirst($request->input('address')),
                'city' => ucfirst($request->input('city')),
                'zip_code' => ucfirst($request->input('zip_code')),
                'contact_no' => ucfirst($request->input('contact_no')),
                'contact_name' => ucfirst($request->input('contact_name')),
                'search_key' => ucfirst($request->input('search_key')),
                'company_desc' => ucfirst($request->input('company_desc')),
                'phone' => ucfirst($request->input('phone')),
                'website' => ucfirst($request->input('website')),
                'company_no' => ucfirst($request->input('company_no')),
                'payment_terms' => $request->input('payment_terms'),
                'tax_id_no' => $request->input('tax_id_no'),
                'bank_name' => $request->input('bank_name'),
                'account_no' => $request->input('account_no'),
                'account_name' => ucfirst($request->input('account_name')),
                'currency_id' => $request->input('currency'),
                'company_type' => $request->input('contact_type'),
                'logo' => $photo,
                'updated_by' => Auth::user()->id,
                'active_status' => Utility::STATUS_ACTIVE,
                'status' => Utility::STATUS_ACTIVE
            ];
            $rowData = VendorCustomer::specialColumns('name', $request->input('name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    VendorCustomer::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);

                } else {
                    return response()->json([
                        'message' => 'good',
                        'message2' => 'Entry already exist, please try another entry'
                    ]);

                }

            } else{
                VendorCustomer::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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


    public function searchVendor(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = VendorCustomer::searchVendor($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->id;
        }

        $user_ids = array_unique($obtain_array);
        $mainData =  VendorCustomer::massData('id', $user_ids);
        //print_r($obtain_array); die();
        //return var_dump($search); exit();
        if (count($user_ids) > 0) {

            return view::make('vendor_customer.vendor_customer_search')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
        }

    }

    public function searchCustomer(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = VendorCustomer::searchCustomer($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->uid;
        }
        /*for($i=0;$i<count($search);$i++){
            $obtain_array[] = $search[$i]->id;
        }*/

        $dataIds = array_unique($obtain_array);
        $mainData =  VendorCustomer::massDataCondition('id', $dataIds,'company_type',Utility::CUSTOMER);
        //print_r($obtain_array); die();
        if (count($dataIds) > 0) {

            return view::make('vendor_customer.vendor_customer_search')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
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

        $in_use = [];
        $unused = [];
        for($i=0;$i<count($all_id);$i++){
            $rowDataJournal = AccountJournal::specialColumns('vendor_customer', $all_id[$i]);
            if(count($rowDataJournal)>0){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }

        $inactiveContact = [];
        $activeContact = [];

        foreach($in_use as $var){
            $leadRequest = VendorCustomer::firstRow('id',$var);
            if($leadRequest->created_by == Auth::user()->id || in_array(Auth::user()->id,Utility::TOP_USERS)){
                $inactiveContact[] = $var;
            }else{
                $activeContact[] = $var;
            }
        }

        $contactMessage = (count($inactiveContact) < 1) ? ', '.count($activeContact).
            ' contact(s) was not created by you and cannot be deleted' : '';

        $message = (count($unused) > 0) ? ' and '.count($unused).
            ' contact has been used in another general ledger and cannot be deleted' : '';
        if(count($in_use) > 0 && count($inactiveContact) > 0){
            $delete = VendorCustomer::massUpdate('id',$inactiveContact,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($in_use).' data(s) has been deleted'.$message.$contactMessage
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.$message.$contactMessage,
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
        $delete = VendorCustomer::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
        ]);

    }

}
