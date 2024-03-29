<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ForgetpassEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use Auth;
use Validator;
use Session;
use Hash;
use Mail;

class ForgetpassController extends Controller
{
    public function form()
    {
    	return view('auth.forgetpass');
    }

    public function process(Request $request)
    {

        $rules = [
            'user_email'   => 'required|email|exists:users,user_email',
        ];
 
        $messages = [
            'user_email.required'  => 'Masukan e-mail',
            'user_email.email'     => 'E-mail tidak valid',
            'user_email.exists'    => 'E-mail tidak terdaftar',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        
        $user = User::where('user_email',$request->user_email)->first();
        $token = Str::random(32);
                    
        try
        {
            User::where('user_email',$request->user_email)
                ->update([
                    'forgetpass_token' => $token,
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba lagi');
            return redirect()->back();
        }

        Mail::to($request->user_email)->send(new ForgetpassEmail($request->user_email, $token));

        Session::flash('success', 'Tautan reset password telah kami kirim, silahkan periksa e-mail anda');
        return redirect()->back();
    }
    
    public function resetpassform($email = null, $token = null)
    {
        if($email == null || $token == null)
        {
            Session::flash('error', 'Silahkan login');
            return redirect()->route('login');
        }

        $user = User::where('user_email',$email)
                    ->where('forgetpass_token',$token)
                    ->first();

        if($user == null )
        {
            Session::flash('error', 'Tautan salah');
            return redirect()->route('login');
        }
        
    	return view('auth.resetpass', [
            'email' => $email,
            'token' => $token,
            ]);
    }

    public function resetpassprocess(Request $request)
    {
        $rules = [
            'user_password'     => 'required'
        ];
 
        $messages = [
            'user_password.required'    => 'Masukan password',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        
        try
        {
            User::where('user_email',$request->email)
                ->where('forgetpass_token',$request->token)
                ->update([
                    'forgetpass_token' => null,
                    'user_password' => Hash::make($request->user_password),
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon hubungi admin MagangHub');
            return redirect()->back();
        }

        Session::flash('success', 'Ubah password berhasil! Silahkan login');
        return redirect()->route('login');
    }

    // change pass
    public function changepassform()
    {
    	return view('auth.changepass');
    }

    public function changepassprocess(Request $request)
    {
        $rules = [
            'user_password_lama'     => 'required',
            'user_password_baru'     => 'required'
        ];
 
        $messages = [
            'user_password_lama.required'    => 'Masukan password lama',
            'user_password_baru.required'    => 'Masukan password baru',
        ];

        $user = User::where('user_email', Auth::user()->user_email)->first();
        if(empty($user)) return abort(404);

        if (!Hash::check($request->user_password_lama, $user->user_password))
        {
            Session::flash('error', 'Password lama salah');
            return redirect()->back();
        }

        try
        {
            User::where('user_email',$user->user_email)
                ->update([
                    'forgetpass_token' => null,
                    'user_password' => Hash::make($request->user_password_baru),
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon hubungi admin MagangHub');
            return redirect()->back();
        }

        Auth::logout();
        Session::flash('success', 'Ubah password berhasil! Silahkan login');
        return redirect()->route('login');
    }
}
