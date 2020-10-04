<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\UserPinCode;

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

class UserPinCOdeController extends Controller
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
        $mainData = UserPinCode::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('user_pin_code.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('user_pin_code.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),UserPinCode::$mainRules);
        if($validator->passes()){

            $multipleOf = $request->input('multiple_of');

            for($i=0;$i<$multipleOf;$i++){
                $code = Utility::generateUniqueId('user_pin_code','pin_code');
                $dbDATA = [
                    'pin_code' => $code,
                    'status' => Utility::STATUS_ACTIVE
                ];
                UserPinCode::create($dbDATA);

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


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


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
        $deletePinCode = UserPinCode::destroy('id',$idArray);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);
    }
}
