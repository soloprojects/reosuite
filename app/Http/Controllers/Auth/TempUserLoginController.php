<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\model\TempUsers;
use Illuminate\Support\Facades\Auth;
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
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class TempUserLoginController extends Controller
{

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest:temp_user', ['except' => ['logout', 'temp_user_logout']]);
    }


    public function signin() {

        return view::make('auth.temp_user_login');
    }

    //
    public function login(Request $request) {
        $credentials = array('email'=> $request->input('email'), 'password'=>$request->input('password'),
            'active_status' => '1','status' => '1');
        $remember = true;
        if(Auth::guard('temp_user')->attempt($credentials)){
            $newCurr = Currency::firstRow('active_status','1');
            session(['currency' => $newCurr]);
            return redirect()->route('temp_user_dashboard')->with('message', '');
        }

        /*if(Auth::user()->active_status == 1 && Auth::user()->status == 1){
            return Redirect::to('dashboard')->with('message', 'welcome.');
        }*/

        return redirect()->route('temp_user_login')
            ->with('message','**Incorrect Email/Password, please try again**');


    }


}
