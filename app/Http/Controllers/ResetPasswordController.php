<?php

namespace App\Http\Controllers;

use App\Helpers\Notify;
use App\Helpers\Utility;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Support\Facades\Auth;
use View;
use Validator;
use Input;
use App\model\Currency;
use Hash;
use DB;
use Intervention\Image\Facades\Image;
//use Request;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\model\ResetPassword;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;

class ResetPasswordController extends Controller
{
    //
    public function passwordReset(Request $request){

        return view('auth.passwords.email');

    }

    public function passwordResetEmailExistence(Request $request){

        $search = User::firstRow('email',$request->input('searchVar'));
        if(empty($search)){
            return 'Email '.$request->input('searchVar').' does not exist on our platform';
        }else{
            return '';
        }

    }

    //SEND OUT RESET PASSWORD LINK TO EMAIL
    public function passwordResetEmail(Request $request){

        $email = self::sanitize($request->input('email'));
        $token = $request->input('_token');
        $passwordResetArray = [
            'email' => $email,
            'token' => $token,
        ];
        ResetPassword::create($passwordResetArray);
        $resetLink = url('password_reset/token/'.$token.'/'.urlencode($email));

        //SEND OUT MAIL TO SUBSCRIBER            
        $mailContent = [];

        $messageBody = "Hello, Please click this link to reset password 
        <a href='$resetLink'>$resetLink</a>";

        $mailContent['message'] = $messageBody;
        Notify::GeneralMail('mail_views.general', $mailContent, $email);
        
        return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

    }

    public function passwordResetToken(Request $request, $token, $email){

        $decodeEmail = urldecode($email);
        $checkData = ResetPassword::firstRow2('token',$token,'email',$decodeEmail);
        if(!empty($checkData)){
            return view('auth.passwords.reset')->with('email',$decodeEmail)->with('token',$token);
        }else{
            return 'Token does not exist';
        }

    }

    public function passwordResetLogin(Request $request){

        $mainRules = [
            'email' => 'required',
            'password' => 'between:6,30|confirmed',
            'password_confirmation' => 'same:password',
        ];
        
        $validator = Validator::make($request->all(),$mainRules);
        if($validator->passes()) {

            $passwordHash = Hash::make($request->input('password'));
            $updatePassword = User::defaultUpdate('email',$request->input('email'),['password' => $passwordHash]);

            if($updatePassword){

                $subscription = Utility::subscription();
                $activeStatus = $subscription->activeStatus;
                $memoryStatus = $subscription->memoryStatus;
                if($activeStatus != Utility::STATUS_ACTIVE && $memoryStatus != Utility::STATUS_ACTIVE){
                    return redirect()->route('login')
                    ->with('message','**please ensure that your subscription is not expired/Memory Full**');

                }

                $credentials = array('email'=> $request->input('email'), 'password'=>$request->input('password'),
                    'active_status' => '1', 'dormant_status' => '0','status' => '1');
                $remember = true;
            
                if(Auth::attempt($credentials)){
                    $resetData = ResetPassword::firstRow('email',$request->input('email'));
                    $deleteResetData = ResetPassword::destroy($resetData->id);
                    $newCurr = Currency::firstRow('active_status','1');
                    session(['currency' => $newCurr]);
                    return redirect()->route('dashboard')->with('message', '');
                }else{

                    return redirect()->route('login')
                    ->with('message','**Incorrect Email/Password, please try again**');

                }

            }
            

        }{
            return redirect()->back()->withErrors($validator);
        }


    }

    public static function sanitize($data){

        return htmlentities($data);
   
    }

    public static function sanitizeData(&$data){

        if(is_array($data)){
            foreach ($data as &$d){
                $d = htmlentities($d);
            }
        }
        else{
            $data = htmlentities($data);
        }

    }

    
}
