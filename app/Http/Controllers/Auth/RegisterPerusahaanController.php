<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\RoleTrait;
use App\User;
use App\Perusahaan;
use Validator;
use Session;
use Hash;
use Mail;
use Auth;

class RegisterPerusahaanController extends Controller
{
    use RoleTrait;

    public function form()
    {
        if(Auth::check()) return $this->redirectRole();
        return view('auth.regist_perusahaan');
    }
    
    public function process(Request $request)
    {
        $rules = [
            'perusahaan_nama'=> 'required|max:200',
            'perusahaan_nib' => 'required|unique:perusahaans,perusahaan_nib',
            'user_email'     => 'required|email|unique:users,user_email',
            'user_password'  => 'required|confirmed'
        ];
 
        $messages = [
            'perusahaan_nama.required'  => 'Masukan nama perusahaan',
            'perusahaan_nama.max'       => 'Max nama perusahaan 200 karakter',
            'perusahaan_nib.required'   => 'Masukan NIB',
            'perusahaan_nib.unique'     => 'NIB sudah terdaftar',
            'user_email.required'       => 'Masukan e-mail admin perusahaan',
            'user_email.email'          => 'E-mail tidak valid',
            'user_email.unique'         => 'E-mail sudah terdaftar',
            'user_password.required'    => 'Masukan password',
            'user_password.confirmed'   => 'Password tidak sama dengan konfirmasi password'
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
 
        $user = new User;
        $user->user_email        = strtolower($request->user_email);
        $user->user_role         = 'perusahaan';
        $user->user_status       = '1';
        $user->user_password     = Hash::make($request->user_password);
        $user->user_verify_token = Str::random(32);
        $simpanuser = $user->save();

        $perusahaan = new Perusahaan;
        $perusahaan->perusahaan_user_email  = strtolower($request->user_email);
        $perusahaan->perusahaan_nama        = ucwords(strtolower($request->perusahaan_nama));
        $perusahaan->perusahaan_nib         = $request->perusahaan_nib;
        $simpanperusahaan = $perusahaan->save();

        if($simpanuser && $simpanperusahaan)
        {
            Mail::to($request->user_email)->send(new VerificationEmail($request->user_email, $user->user_verify_token, $user->user_role));

            Session::flash('success', 'Register berhasil! Periksa email anda untuk melakukan verifikasi');
            return redirect()->route('registperusahaan');
        } else {
            Session::flash('error', 'Register gagal! Mohon hubungi admin MagangHub');
            return redirect()->route('registperusahaan');
        }
    }
}
