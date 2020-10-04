<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\model\TempUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use View;
use Validator;
use Input;
use Hash;
use DB;
use App\model\Currency;
use App\Helpers\Utility;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Auth\Authenticatable;

class TempUserHomeController extends Controller
{
    //


    public function __construct()
    {
        $this->middleware('auth:temp_user');
    }

    public function index()
    {
        $activeCurr = Currency::firstRow('active_status','1');
        $holdArr = [];
        $holdArr['id'] = $activeCurr->id;
        $holdArr['code'] = $activeCurr->code;
        $holdArr['currency'] = $activeCurr->currency;
        $holdArr['symbol'] = $activeCurr->symbol;
        $holdArr['active_status'] = $activeCurr->active_status;
        $holdArr['status'] = $activeCurr->status;
        session(['currency' => $holdArr]);

        return view::make('auth.temp_user_dashboard');
    }

    public function signout(Request $request){
        session()->forget('currency');
        //Auth::logout();
        Auth::guard('temp_user')->logout();


        return redirect()->route('temp_user_login')->with('message','You\'ve signed out');
    }

}
