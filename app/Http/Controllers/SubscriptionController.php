<?php

namespace App\Http\Controllers;

use App\model\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    //
    public function updateSubscription(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $status = $request->input('status');
        $dbData = [
            'active_status' => $status,
            'memory_status' => $status,
            'user_count' => $status,
            'apps' => $status,
        ];
        $delete = Subscription::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
        ]);

    }

}
