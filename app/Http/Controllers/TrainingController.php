<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\Training;
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

class TrainingController extends Controller
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
        $mainData = (in_array(Auth::user()->role,Utility::HR_MANAGEMENT)) ? Training::paginateAllData() : Training::specialColumnsPage('user_id',Auth::user()->id);


        if ($request->ajax()) {
            return \Response::json(view::make('training.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('training.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),Training::$mainRules);
        if($validator->passes()){

            $countData = Training::countData('training_name',$request->input('training_name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'training_name' => ucfirst($request->input('training_name')),
                    'training_desc' => $request->input('training_desc'),
                    'type' => $request->input('training_type'),
                    'vendor' => $request->input('vendor'),
                    'from_date' => Utility::standardDate($request->input('start_date')),
                    'to_date' => Utility::standardDate($request->input('end_date')),
                    'duration' => Utility::getDaysLength($request->input('start_date'),$request->input('end_date')),
                    'user_id' => $request->input('user'),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                Training::create($dbDATA);

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
        $training = Training::firstRow('id',$request->input('dataId'));
        return view::make('training.edit_form')->with('edit',$training);

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
        $validator = Validator::make($request->all(),Training::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'training_name' => ucfirst($request->input('training_name')),
                'training_desc' => $request->input('training_desc'),
                'type' => $request->input('training_type'),
                'vendor' => $request->input('vendor'),
                'from_date' => Utility::standardDate($request->input('start_date')),
                'to_date' => Utility::standardDate($request->input('end_date')),
                'duration' => Utility::getDaysLength($request->input('start_date'),$request->input('end_date')),
                'user_id' => $request->input('user'),
                'updated_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            $rowData = Training::specialColumns('training_name', $request->input('training_name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    Training::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                Training::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
        $delete = Training::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }
}
