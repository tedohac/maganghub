<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Validator;
use Session;

class LoginController extends Controller
{
    public function loginform()
    {
    	return view('auth.login');
    }

    public function loginprocess(Request $request)
    {
    	
        $rules = [
            'login_email'   => 'required|email',
            'login_pass'    => 'required'
        ];
 
        $messages = [
            'login_email.required'  => 'Masukan e-mail',
            'login_email.email'     => 'E-mail tidak valid',
            'login_pass.required'   => 'Masukan password'
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        
        $data = [
            'email'     => $request->login_email,
            'password'  => $request->login_pass
        ];
 
        Auth::attempt($data);
        
        if(!Auth::check())
        {
            //Login Fail
            Session::flash('error', 'Email atau password salah');
            return redirect()->route('login');
        }
        else
        {
            // check verification
            $user = User::where('email',$request->email)->first();

            if(!isset($user['status']) || $user['status'] == 1)
            {
                return redirect()->route('verifyneeded');
            }
            else
            {
                return redirect()->route('/');
            }
        }
       
    }
}
