<?php

namespace App\Http\Controllers;

use App\model\BudgetRequestTracking;
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
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class BudgetRequestTrackingController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $mainData = BudgetRequestTracking::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('budget_request_tracking.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('budget_request_tracking.main_view')->with('mainData',$mainData);
        }

    }

        //CONVERT BUDGET REQUISITION TRACKING TO ACTIVE OR INACTIVE STATUS
        public function changeBudgetStatus(Request $request)
        {
            //
            $idArray = json_decode($request->input('all_data'));
            $id = $idArray[0];
            $status = $request->input('status');

            $dbData1 = [
                'active_status' => '0'
            ];
            $dbData = [
                'active_status' => $status,
            ];

            if($status == 1) {

                $activeBudget = BudgetRequestTracking::firstRow('active_status', '1');
                if (!empty($activeBudget)) {

                    $cancelActive = BudgetRequestTracking::defaultUpdate('id', $activeBudget->id, $dbData1);
                    $update = BudgetRequestTracking::defaultUpdate('id', $id, $dbData);
                }else{
                    $update = BudgetRequestTracking::defaultUpdate('id', $id, $dbData);
                }

            }else{
                $update = BudgetRequestTracking::defaultUpdate('id', $id, $dbData);
            }



            return response()->json([
                'message2' => 'changed successfully',
                'message' => 'Status change'
            ]);

        }


}
