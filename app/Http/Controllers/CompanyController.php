<?php

namespace App\Http\Controllers;

use App\model\Company;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\model\Position;
use App\model\Department;
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
use CreateCompanyInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $mainData = Company::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('company_info.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('company_info.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),Company::$mainRules);
        if($validator->passes()){

            $countData = Company::countData('name',$request->input('name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                $photo = 'logo.jpg';
                if($request->hasFile('photo')){

                    $image = $request->file('photo');
                    $filename = date('Y-m-d-H-i-s')."_".$image->getClientOriginalName();
                    $path = Utility::IMG_URL().$filename;

                    Image::make($image->getRealPath())->resize(300,250)->save($path);
                    $photo = $filename;

                }


                $dbDATA = [
                    'name' => ucfirst($request->input('name')),
                    'address' => ucfirst($request->input('address')),
                    'email' => ucfirst($request->input('email')),
                    'phone1' => ucfirst($request->input('phone1')),
                    'phone2' => ucfirst($request->input('phone2')),
                    'logo' => $photo,
                    'created_by' => Auth::user()->firstname.' '.Auth::user()->lastname,
                    'status' => Utility::STATUS_ACTIVE
                ];
                Company::create($dbDATA);

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

        $company = Company::firstRow('id',$request->input('dataId'));
        return view::make('company_info.edit_form')->with('edit',$company);

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
        $validator = Validator::make($request->all(),Company::$mainRulesEdit);
        if($validator->passes()) {

            $photo = $request->get('prev_photo');

            if($request->hasFile('photo')){

                $image = $request->file('photo');
                $filename = date('Y-m-d-H-i-s')."_".$image->getClientOriginalName();
                $path = Utility::IMG_URL().$filename;

                Image::make($image->getRealPath())->resize(300,250)->save($path);
                $photo = $filename;
                if($request->get('prev_photo') != 'logo.jpg'){
                    unlink($request->get('prev_photo'));
                }

            }

            $dbDATA = [
                'name' => ucfirst($request->input('name')),
                'address' => ucfirst($request->input('address')),
                'email' => ucfirst($request->input('email')),
                'phone1' => ucfirst($request->input('phone1')),
                'phone2' => ucfirst($request->input('phone2')),
                'logo' => $photo,
                'updated_by' => Auth::user()->firstname.' '.Auth::user()->lastname
            ];
            $rowData = Company::specialColumns('name', $request->input('name'));
            if(count($rowData) > 2){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    Company::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                Company::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];
        $delete = Company::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

    public function changeStatus(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $status = $request->input('status');
        $checkActive = Company::firstRow('active_status',Utility::STATUS_ACTIVE);

        $dbData = [
            'active_status' => $status
        ];
        if($status == Utility::STATUS_ACTIVE) {
            if (!empty($checkActive)) {
                Company::defaultUpdate('id', $checkActive->id, ['active_status' => Utility::STATUS_DELETED]);
            }
            $changeStatus = Company::defaultUpdate('id',$idArray[0],$dbData);
        }else{
            $changeStatus = Company::massUpdate('id',$idArray,$dbData);
        }


        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
        ]);

    }

}
