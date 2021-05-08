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
            'user_email'   => 'required|email',
            'user_password'    => 'required'
        ];
 
        $messages = [
            'user_email.required'  => 'Masukan e-mail',
            'user_email.email'     => 'E-mail tidak valid',
            'user_password.required'   => 'Masukan password'
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        
        $data = [
            'user_email'=> $request->user_email,
            'password'  => $request->user_password
        ];
        
        // verification check
        $isverified = User::where('user_email',$request->user_email)->first();
        
        if(!empty($isverified) && $isverified->user_email_verified_at == "") return redirect()->route('verifyneeded');
        else if(!empty($isverified) && $isverified->user_status=='0')
        {
            //Login Fail
            Session::flash('error', 'Akun anda sedang dalam pengawasan, silahkan hubungi admin MagangHub untuk informasi lebih lanjut');
            return redirect()->route('login')->withInput($request->all);
        }

        if(!Auth::attempt($data, isset($request->login_remember)))
        {
            //Login Fail
            Session::flash('error', 'Email atau password salah');
            return redirect()->route('login')->withInput($request->all);
        }

        Session::flash('success', 'Selamat datang, '.Auth::user()->user_role.'!');
        if(Auth::check()) return $this->redirectRole();
    }

    public function logout()
    {
        Auth::logout();
        Session::flash('success', 'Logout berhasil, sampai jumpa!');
        return redirect()->route('login');
    }
}
