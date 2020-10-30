<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\RoleTrait;
use App\User;
use Validator;
use Session;
use Auth;

class LoginController extends Controller
{
    use RoleTrait;

    public function form()
    {
        if(Auth::check()) return $this->redirectRole();
        
        return view('auth.login');
    }

    public function process(Request $request)
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
        
        if(!Auth::attempt($data, isset($request->login_remember)))
        {
            //Login Fail
            Session::flash('error', 'Email atau password salah');
            return redirect()->route('login');
        }

        Session::flash('success', 'Selamat datang, '.Auth::user()->role.'!');
        if(Auth::check()) return $this->redirectRole();
    }

    public function logout()
    {
        Auth::logout();
        Session::flash('success', 'Logout berhasil, sampai jumpa!');
        return redirect()->route('login');
    }
}
