<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\model\Currency;
use App\model\CrmLead;
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

class CrmLeadController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $mainData =  CrmLead::paginateAllData();
        $currency = Currency::getAllData();


        if ($request->ajax()) {
            return \Response::json(view::make('crm_lead.reload',array('mainData' => $mainData,
                'currency' => $currency))->render());

        }else{
            return view::make('crm_lead.main_view')->with('mainData',$mainData)
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
        $validator = Validator::make($request->all(),CrmLead::$mainRules);
        if($validator->passes()){

            $countData = CrmLead::countData('name',$request->input('name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                $dbDATA = [
                    'email1' => ucfirst($request->input('email1')),
                    'email2' => ucfirst($request->input('email2')),
                    'name' => $request->input('name'),
                    'address' => ucfirst($request->input('address')),
                    'city' => ucfirst($request->input('city')),
                    'contact_no' => ucfirst($request->input('contact_no')),
                    'contact_name' => ucfirst($request->input('contact_name')),
                    'phone' => ucfirst($request->input('phone')),
                    'currency_id' => $request->input('currency'),
                    'created_by' => Auth::user()->id,
                    'active_status' => Utility::STATUS_ACTIVE,
                    'status' => Utility::STATUS_ACTIVE
                ];
                CrmLead::create($dbDATA);

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
        $mainData = CrmLead::firstRow('id',$request->input('dataId'));
        return view::make('crm_lead.edit_form')->with('edit',$mainData)->with('currency',$currency);

    }

    public function convertForm(Request $request)
    {
        //
        $currency = Currency::getAllData();
        $mainData = CrmLead::firstRow('id',$request->input('dataId'));
        return view::make('crm_lead.convert_lead_form')->with('edit',$mainData)->with('currency',$currency);

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
        $validator = Validator::make($request->all(),CrmLead::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'email1' => ucfirst($request->input('email1')),
                'email2' => ucfirst($request->input('email2')),
                'name' => $request->input('name'),
                'address' => ucfirst($request->input('address')),
                'city' => ucfirst($request->input('city')),
                'contact_no' => ucfirst($request->input('contact_no')),
                'contact_name' => ucfirst($request->input('contact_name')),
                'phone' => ucfirst($request->input('phone')),
                'currency_id' => $request->input('currency'),
                'updated_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            $rowData = CrmLead::specialColumns('name', $request->input('name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    CrmLead::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                CrmLead::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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


    public function searchLead(Request $request)
    {

        $mainData = CrmLead::searchLead($_GET['searchVar']);

        if (count($mainData) > 0) {

            return view::make('crm_lead.search')->with('mainData',$mainData);
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

        $inactiveLead = [];
        $activeLead = [];

        foreach($all_id as $var){
            $leadRequest = CrmLead::firstRow('id',$var);
            if($leadRequest->created_by == Auth::user()->id || in_array(Auth::user()->id,Utility::TOP_USERS)){
                $inactiveLead[] = $var;
            }else{
                $activeLead[] = $var;
            }
        }

        $message = (count($inactiveLead) < 1) ? ' and '.count($activeLead).
            ' lead was not created by you and cannot be deleted' : '';
        if(count($inactiveLead) > 0){


            $delete = CrmLead::massUpdate('id',$inactiveLead,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($inactiveLead).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($activeLead).$message,
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
        $delete = CrmLead::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
        ]);

    }

}
