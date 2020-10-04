<?php

namespace App\Http\Controllers;

use App\model\TicketCategory;
use App\model\Helpdesk;
use App\Helpers\Utility;
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

class TicketCategoryController extends Controller
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
        $mainData = TicketCategory::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('ticket_category.reload',array('mainData' => $mainData,))->render());

        }else{
            return view::make('ticket_category.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),TicketCategory::$mainRules);
        if($validator->passes()){

            $countData = TicketCategory::countData('request_name',$request->input('ticket_name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'request_name' => ucfirst($request->input('ticket_name')),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                TicketCategory::create($dbDATA);

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
        $request = TicketCategory::firstRow('id',$request->input('dataId'));
        return view::make('ticket_category.edit_form')->with('edit',$request);

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
        $validator = Validator::make($request->all(),TicketCategory::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'request_name' => ucfirst($request->input('ticket_name')),
                'updated_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            $rowData = TicketCategory::specialColumns('request_name', $request->input('ticket_name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    TicketCategory::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                TicketCategory::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
        $all_id = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];

        $in_use = [];
        $unused = [];
        $inactiveCat = [];
        $activeCat = [];
        for($i=0;$i<count($all_id);$i++){
            if(in_array($all_id[$i],[0,0])){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }

        foreach($in_use as $var){
            $request = Helpdesk::firstRow('ticket_cat',$var);
            if(empty($request)){
                $inactiveCat[] = $var;
            }else{
                $activeCat[] = $var;
            }
        }

        $message = (count($inactiveCat) < 1) ? ' and '.count($activeCat).
            ' category(ies) has been used for help desk request and cannot be deleted' : '';
        if(count($inactiveCat) > 0){


            $delete = TicketCategory::massUpdate('id',$inactiveCat,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($in_use).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($activeCat).' category(ies) has been used in for help desk request and cannot be deleted',
                'message' => 'warning'
            ]);

        }


    }

}
