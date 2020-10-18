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

        $param = [
            'url' => route('verify', [
                'token' => $user->verify_token, 
                'email' => $user->email
            ]),
            'role' => $user->role,
        ];

        Mail::to($user->email)->send(new VerificationEmail($param));

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
            Session::flash('error', 'URL verifikasi salah');
            return redirect()->route('login');
        }
        else
        {
            if($user->status == 1)
            {
                $user->update([
                    'status' => 2,
                    'email_verified_at' => Carbon::now(),
                    'verify_token' => ''
                ]);
            }

            Session::flash('success', 'Verifikasi e-mail berhasil, silahkan Login');
            return redirect()->route('login');
        }

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
                    
        $param = [
            'url' => route('verify', [
                'token' => $user->verify_token, 
                'email' => $user->email
            ]),
            'role' => $user->role,
        ];

        Mail::to($user->email)->send(new VerificationEmail($param));

        Session::flash('success', 'Tautan verifikasi telah kami kirim kembali');
        return redirect()->back();
    }
}
