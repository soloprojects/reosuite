<?php

namespace App\Http\Controllers;

use App\model\AccountJournal;
use App\model\ClosingBooks;
use App\model\AccountChart;
use App\Helpers\Utility;
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

class ClosingBooksController extends Controller
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
        $mainData = ClosingBooks::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('closing_books.reload',array('mainData' => $mainData))->render());

        }
        return view::make('closing_books.main_view')->with('mainData',$mainData);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),ClosingBooks::$mainRules);
        if($validator->passes()){

            $countData = ClosingBooks::specialColumns('closing_date',Utility::standardDate($request->input('closing_date')));
            if($countData->count() > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'password' => md5($request->input('password')),
                    'closing_date' => Utility::standardDate($request->input('closing_date')),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                $pro = ClosingBooks::create($dbDATA);

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
        $dept = ClosingBooks::firstRow('id',$request->input('dataId'));
        return view::make('closing_books.edit_form')->with('edit',$dept);

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
        $validator = Validator::make($request->all(),ClosingBooks::$mainRules);
        if($validator->passes()) {

            $new_password = md5($request->input('password'));
            if($request->get('password') == ""){
                $new_password =  $request->input('prev_password');
            }
            $dbDATA = [
                'password' => $new_password,
                'closing_date' => Utility::standardDate($request->input('closing_date')),
                'updated_by' => Auth::user()->id
            ];
            $rowData = ClosingBooks::specialColumns('closing_date',Utility::standardDate($request->input('closing_date')));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    ClosingBooks::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                ClosingBooks::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

    public function closing_booksStatus(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $id = $idArray[0];
        $check = ClosingBooks::countData2('id', $id, 'active_status', '0');
        if ($check > 0) {
            $activeYear = ClosingBooks::firstRow('active_status','1');
            $dbData1 = [
                'active_status' => '0'
            ];
            $dbData = [
                'active_status' => Utility::STATUS_ACTIVE,
            ];
            if(!empty($activeYear)){
                $cancelActive = ClosingBooks::defaultUpdate('id', $activeYear->id, $dbData1);
            }
            $update = ClosingBooks::defaultUpdate('id', $idArray, $dbData);


            return response()->json([
                'message2' => 'changed successfully',
                'message' => 'Status change'
            ]);
        }else{
            return response()->json([
                'message2' => 'rejected',
                'message' => 'Closing Date already active'
            ]);
        }

    }

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
            $rowDataSalary = ClosingBooks::specialColumns2('id', $all_id[$i],'active_status',Utility::STATUS_ACTIVE);
            if(count($rowDataSalary)>0){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }
        $message = (count($unused) > 0) ? ' and '.count($unused).
            ' Closing date is active  and cannot be deleted' : '';
        if(count($in_use) > 0){
            $delete = ClosingBooks::massUpdate('id',$in_use,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($in_use).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => count($unused).' Closing date is active and cannot be deleted',
                'message' => 'warning'
            ]);

        }

    }

}
