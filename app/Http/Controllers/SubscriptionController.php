<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\Subscription;
use App\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    
    //UPDATE AUTO SUBSCRIPTION FROM CRON JOB IN THE PORTAL
    public function updateSubscription(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $apps = $request->input('apps');
        $activeStatus = $request->input('active_status');
        $memoryStatus = $request->input('memory_status');
        $userCount = $request->input('subscribed_users');
        $subId = $request->input('subscribe_db_id');
        
        $subscribeData = [
            'active_status' => $activeStatus,
            'memory_status' => $memoryStatus,
            'user_count' => $userCount,
            'apps' => $apps,
        ];
        $update = Subscription::defaultUpdate('id',$subId,$subscribeData);
        
        //CREATE MASTER ACCOUNT FOR USER
        
        $email = $request->input('email');
        $password = $request->input('password');
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $sex = $request->input('sex');
        $phone = $request->input('phone');


        $uid = Utility::generateUID('users');
        $photo = 'user.png';
        $userData = [
            'uid' => $uid,
            'email' => $email,
            'password' => $password,
            'role' => Utility::CONTROLLER,
            'firstname' => ucfirst($firstname),
            'lastname' => ucfirst($lastname),
            'sex' => ucfirst($sex),
            'phone' => ucfirst($phone),
            'photo' => $photo,
            'active_status' => Utility::STATUS_ACTIVE,
            'dormant_status' => Utility::ZERO,
            'status' => Utility::STATUS_ACTIVE
        ];

        $adminData = User::firstRow('email','admin@reosuite.com');
        if(!empty($adminData)){
            $deleteAccount = User::defaultUpdate('id',$adminData->id,['status' => Utility::STATUS_DELETED]);
            $createMasterAccount = User::create($userData);
        }

        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
        ]);

    }

}
