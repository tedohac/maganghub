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
    

    public function demoverify()
    {

        $myEmail = 'tedohac@gmail.com';

        $user = new User;
        $user->email = 'tedohac@gmail.com';
        $user->role = 'adminkampus';
        $user->status = '1';
        $user->password = Hash::make('polman');
        $user->verify_token = Str::random(32);

        Mail::to($user->email)->send(new VerificationEmail($user->email, $user->verify_token, $user->role));

        dd("Mail Send Successfully");

    }

    public function verifyemail($email = null, $token = null)
    {
        if($email == null || $token == null)
        {
            Session::flash('error', 'Silahkan login');
            return redirect()->route('login');
        }

        $user = User::where('email',$email)
                    ->where('verify_token',$token)
                    ->first();

        if($user == null )
        {
            Session::flash('error', 'Tautan salah atau anda sudah melalukan verifikasi sebelumnya');
            return redirect()->route('login');
        }

        if($user->status == 1)
        {
            try
            {
                User::where('email',$email)
                    ->where('verify_token',$token)
                    ->update([
                        'status' => '2',
                        'email_verified_at' => Carbon::now(),
                        'verify_token' => null,
                    ]);
            } catch (\Illuminate\Database\QueryException $e) {
                Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi');
                return redirect()->route('login');
            }
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
                    
        Mail::to($user->email)->send(new VerificationEmail($user->email, $user->verify_token, $user->role));

        Session::flash('success', 'Tautan verifikasi telah kami kirim kembali');
        return redirect()->back();
    }
}
