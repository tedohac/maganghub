<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\User;
use Validator;
use Session;
use Hash;
use Mail;

class VerifyController extends Controller
{
    public function verifyemail($email = null, $token = null)
    {
        if($email == null || $token == null)
        {
            Session::flash('error', 'Silahkan login');
            return redirect()->route('login');
        }

        $user = User::where('user_email',$email)
                    ->where('user_verify_token',$token)
                    ->first();

        if(empty($user))
        {
            Session::flash('error', 'Tautan salah atau anda sudah melalukan verifikasi sebelumnya');
            return redirect()->route('login');
        }

        try
        {
            User::where('user_email',$email)
                ->where('user_verify_token',$token)
                ->update([
                    'user_email_verified_at' => Carbon::now(),
                    'user_verify_token' => null,
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi');
            return redirect()->route('login');
        }

        Session::flash('success', 'Verifikasi e-mail berhasil, silahkan Login');
        return redirect()->route('login');

    }
    
    public function verifyneededform()
    {
        return view('auth.verify-needed');
    }
    
    public function verifyneededprocess(Request $request)
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
        
        $user = User::where('user_email',$request->user_email)->whereNull('user_email_verified_at')->first();
                    
        if(!empty($user))
        {
            Mail::to($user->user_email)->send(new VerificationEmail($user->user_email, $user->user_verify_token, $user->user_role));

            Session::flash('success', 'Tautan verifikasi telah kami kirim kembali');
            return redirect()->back();
        } else {
            Session::flash('error', 'E-mail tidak ditemukan atau sudah melakukan verifikasi');
            return redirect()->back();
        }
    }
}
