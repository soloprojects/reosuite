<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\LeaveVacationDates;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Validator;
use Input;
use Hash;
use DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class LeaveVacationDatesController extends Controller
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
        $mainData = (in_array(Auth::user()->role,Utility::HR_MANAGEMENT)) ? LeaveVacationDates::paginateAllData() : LeaveVacationDates::specialColumnsPage('user_id',Auth::user()->id);

        if ($request->ajax()) {
            return \Response::json(view::make('leave_vacation_dates.reload',array('mainData' => $mainData))->render());

        }else{
        return view::make('leave_vacation_dates.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),LeaveVacationDates::$mainRules);
        if($validator->passes()){

            $user =  $request->input('user');

            if(in_array(Auth::user()->role,Utility::HR_MANAGEMENT)){
                if(!empty($request->input('change_user')) || empty($request->input('user'))){
                    $user = Auth::user()->id;
                }
            }

            $dbDATA = [];

            for($i=1; $i<= 4; $i++){
                if(!empty($request->input('week'.$i)) && !empty($request->input('month'.$i)) && !empty($request->input('year'.$i))){
                    $dbDATA['user_id']  = $user;
                    $dbDATA['week'] = $request->input('week'.$i);
                    $dbDATA['month'] = $request->input('month'.$i);
                    $dbDATA['year'] = $request->input('year'.$i);
                    $dbDATA['status'] = Utility::STATUS_ACTIVE;
                    LeaveVacationDates::create($dbDATA);
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


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editForm(Request $request)
    {
        //
        $dates = LeaveVacationDates::firstRow('id',$request->input('dataId'));
        return view::make('leave_vacation_dates.edit_form')->with('edit',$dates);

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
        $validator = Validator::make($request->all(),LeaveVacationDates::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'week' => ucfirst($request->input('week1')),
                'month' => $request->input('month1'),
                'year' => ucfirst($request->input('year1')),
            ];
           
            LeaveVacationDates::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

            $delete = LeaveVacationDates::massUpdate('id',$all_id,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($all_id).' data(s) has been deleted'
            ]);

    }

}
