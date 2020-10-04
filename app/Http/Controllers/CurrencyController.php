<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\Currency;

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

class CurrencyController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $mainData = Currency::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('currency.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('currency.main_view')->with('mainData',$mainData);
        }

    }

    public function currencyStatus(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $id = $idArray[0];
        $check = Currency::countData2('id', $id, 'active_status', '0');

        Utility::checkExistingLedgerTrans();    //CHECK IF ANY TRANSACTION EXISTS IN THE LEDGER, IF NONE USER CAN CHANGE CURRENCY ELSE THEY CANNOT

            if ($check > 0) {
                $activeCurr = Currency::firstRow('active_status', '1');
                $dbData1 = [
                    'active_status' => '0'
                ];
                $dbData = [
                    'active_status' => Utility::STATUS_ACTIVE,
                ];
                $cancelActive = Currency::defaultUpdate('id', $activeCurr->id, $dbData1);
                $update = Currency::defaultUpdate('id', $idArray, $dbData);
                $newCurr = Currency::firstRow('active_status', '1');
                $holdArr = [];
                $holdArr['id'] = $newCurr->id;
                $holdArr['code'] = $newCurr->code;
                $holdArr['currency'] = $newCurr->currency;
                $holdArr['symbol'] = $newCurr->symbol;
                $holdArr['active_status'] = $newCurr->active_status;
                $holdArr['status'] = $newCurr->status;
                session(['currency' => $holdArr]);

                return response()->json([
                    'message2' => 'changed successfully',
                    'message' => 'Status change'
                ]);
            } else {
                return response()->json([
                    'message2' => 'Currency already active',
                    'message' => 'rejected'
                ]);
            }



    }

    public function editForm(Request $request)
    {
        //
        $dept = Currency::firstRow('id',$request->input('dataId'));
        return view::make('currency.edit_form')->with('edit',$dept);

    }

    public function defaultCurrency(Request $request)
    {
        //
        $validator = Validator::make($request->all(),Currency::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'default_currency' => $request->input('default_rate'),
                'default_curr_status' => $request->input('status')
            ];

                Currency::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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


}
