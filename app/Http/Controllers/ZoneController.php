<?php

namespace App\Http\Controllers;

use App\model\BinType;
use App\model\Zone;
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

class ZoneController extends Controller
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
        $mainData = Zone::paginateAllData();
        $binType = BinType::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('zone.reload',array('mainData' => $mainData,'binType' => $binType))->render());

        }else{
            return view::make('zone.main_view')->with('mainData',$mainData)->with('binType',$binType);
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
        $validator = Validator::make($request->all(),Zone::$mainRules);
        if($validator->passes()){

            $countData = Zone::specialColumns('name', $request->input('name'));
            if($countData->count() > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry '
                ]);

            }else{
                $dbDATA = [
                    'name' => $request->input('name'),
                    'bin_id' => ucfirst($request->input('bin_type')),
                    'special_equip' => ucfirst($request->input('special_equip')),
                    'zone_ranking' => ucfirst($request->input('zone_rank')),
                    'zone_desc' => ucfirst($request->input('zone_desc')),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                $pro = Zone::create($dbDATA);

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

        $binType = BinType::getAllData();
        $dept = Zone::firstRow('id',$request->input('dataId'));
        return view::make('zone.edit_form')->with('edit',$dept)->with('binType',$binType);

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
        $validator = Validator::make($request->all(),Zone::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'name' => $request->input('name'),
                'bin_id' => ucfirst($request->input('bin_type')),
                'special_equip' => ucfirst($request->input('special_equip')),
                'zone_ranking' => ucfirst($request->input('zone_rank')),
                'zone_desc' => ucfirst($request->input('zone_desc')),
                'updated_by' => Auth::user()->id
            ];
            $rowData = Zone::specialColumns('name', $request->input('name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    Zone::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                Zone::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
        $delete = Zone::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

}
