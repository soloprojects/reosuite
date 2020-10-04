<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\QuickNote;
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

class QuickNoteController extends Controller
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
        $mainData = QuickNote::specialColumns('created_by',Auth::user()->id);

        if ($request->ajax()) {
            return \Response::json(view::make('quick_note.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('quick_note.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),QuickNote::$mainRules);
        if($validator->passes()){

                $dbDATA = [
                    'details' => ucfirst($request->input('details')),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                $pro = QuickNote::create($dbDATA);

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $validator = Validator::make($request->all(),QuickNote::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'details' => $request->input('details'),
                'updated_by' => Auth::user()->id
            ];

                QuickNote::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $status = $request->input('status');
        $delete = QuickNote::destroy($idArray);

        return response()->json([
            'message2' => 'deleted successfully',
            'message' => 'Status change'
        ]);

    }

}
