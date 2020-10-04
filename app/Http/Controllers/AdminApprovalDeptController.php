<?php

namespace App\Http\Controllers;

use App\model\AdminApprovalDept;
use App\Helpers\Utility;
use App\model\AdminApprovalSys;
use App\model\Department;
use App\model\AdminRequisition;
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

class AdminApprovalDeptController extends Controller
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
        $mainData = AdminApprovalDept::paginateAllData();
        $dept = Department::getAllData();
        $approval = AdminApprovalSys::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('admin_approval_dept.reload',array('mainData' => $mainData,'dept' => $dept
            ,'approval' => $approval))->render());

        }else{
            return view::make('admin_approval_dept.main_view')->with('mainData',$mainData)->with('dept',$dept)
                ->with('approval',$approval);
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
        $validator = Validator::make($request->all(),AdminApprovalDept::$mainRules);
        if($validator->passes()){

            $countData = AdminApprovalDept::countData('dept',$request->input('department'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'dept' => $request->input('department'),
                    'approval_id' => $request->input('approval_system'),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                AdminApprovalDept::create($dbDATA);

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
        $approvalDept = AdminApprovalDept::firstRow('id',$request->input('dataId'));
        $dept = Department::getAllData();
        $approval = AdminApprovalSys::getAllData();
        return view::make('admin_approval_dept.edit_form')->with('edit',$approvalDept)->with('approval',$approval)->with('dept',$dept);

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
        $validator = Validator::make($request->all(),AdminApprovalDept::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'dept' => $request->input('department'),
                'approval_id' => $request->input('approval_system'),
                'updated_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            $rowData = AdminApprovalDept::specialColumns('dept', $request->input('dept'));
            $rowData2 = AdminApprovalDept::specialColumns('id', $request->input('edit_id'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    //CHECK IF PREVIOUS APPROVAL SYSTEM STILL HAVE SOME REQUEST FOR APPROVAL IN REQUISITION TABLE
                    $activeApprovalSys = AdminRequisition::specialColumns3('dept_id',$rowData2[0]->dept_id,'approval_id',$rowData2[0]->approval_id,'complete_status',Utility::ZERO);
                    if($activeApprovalSys->count() >0){
                        return response()->json([
                            'message' => 'warning',
                            'message2' => 'Ensure there are no pending requests for approval for this department'
                        ]);
                    }

                    Department::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

                //CHECK IF PREVIOUS APPROVAL SYSTEM STILL HAVE SOME REQUEST FOR APPROVAL IN REQUISITION TABLE
                /*return response()->json([
                    'message' => 'warning',
                    'message2' => json_encode($rowData)//'dept_id'.$rowData[0]->dept_id.'approval_id'.$rowData[0]->approval_id.'complete_status',Utility::ZERO
                ]);*/

                $activeApprovalSys = AdminRequisition::specialColumns3('dept_id',$rowData2[0]->dept,'approval_id',$rowData2[0]->approval_id,'complete_status',Utility::ZERO);
                if($activeApprovalSys->count() >0){
                    return response()->json([
                        'message' => 'warning',
                        'message2' => 'Ensure there are no pending requests for approval for this department'
                    ]);
                }

                AdminApprovalDept::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
        $delete = AdminApprovalDept::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

}
