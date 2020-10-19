<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ForgetpassEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
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
            'email'   => 'required|email|exists:users,email',
        ];
 
        $messages = [
            'email.required'  => 'Masukan e-mail',
            'email.email'     => 'E-mail tidak valid',
            'email.exists'    => 'E-mail tidak terdaftar',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        
        $user = User::where('email',$request->email)->first();
        $token = Str::random(32);
                    
        try
        {
            User::where('email',$request->email)
                ->update([
                    'forgetpass_token' => $token,
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba lagi');
            return redirect()->back();
        }

        Mail::to($request->email)->send(new ForgetpassEmail($request->email, $token));

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

        $user = User::where('email',$email)
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
            'pass'     => 'required|confirmed'
        ];
 
        $messages = [
            'pass.required'    => 'Masukan password',
            'pass.confirmed'   => 'Password tidak sama dengan konfirmasi password'
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        
        try
        {
            User::where('email',$request->email)
                ->where('forgetpass_token',$request->token)
                ->update([
                    'forgetpass_token' => null,
                    'password' => Hash::make($request->pass),
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi');
            return redirect()->back();
        }

        Session::flash('success', 'Ubah password berhasil! Silahkan login');
        return redirect()->route('login');
    }
}
