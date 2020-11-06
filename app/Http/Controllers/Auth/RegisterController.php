<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\RoleTrait;
use App\User;
use App\Univ;
use Validator;
use Session;
use Hash;
use Mail;
use Auth;

class RegisterController extends Controller
{
    use RoleTrait;

    public function kampusform()
    {
        if(Auth::check()) return $this->redirectRole();
        return view('auth.registkampus');
    }
 
    public function kampusprocess(Request $request)
    {
        $rules = [
            'univ_nama'     => 'required|max:200',
            'univ_npsn'     => 'required|unique:univs,univ_npsn',
            'user_email'    => 'required|email|unique:users,user_email',
            'user_password' => 'required|confirmed'
        ];
 
        $messages = [
            'univ_nama.required'        => 'Masukan nama kampus',
            'univ_nama.max'             => 'Max nama kampus 200 karakter',
            'univ_npsn.required'        => 'Masukan nomor NPSN',
            'univ_npsn.unique'          => 'Nomor NPSN sudah terdaftar',
            'user_email.required'       => 'Masukan e-mail admin kampus',
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
        $user->user_role         = 'admin kampus';
        $user->user_status       = '1';
        $user->user_password     = Hash::make($request->user_password);
        $user->user_verify_token = Str::random(32);
        $simpanuser = $user->save();

        $univ = new Univ;
        $univ->univ_user_email  = strtolower($request->user_email);
        $univ->univ_nama        = ucwords(strtolower($request->univ_nama));
        $univ->univ_npsn        = $request->univ_npsn;
        $simpanuniv = $univ->save();

        if($simpanuser && $simpanuniv)
        {
            Mail::to($request->user_email)->send(new VerificationEmail($request->user_email, $user->user_verify_token, $user->user_role));

            Session::flash('success', 'Register berhasil! Periksa email anda untuk melakukan verifikasi');
            return redirect()->route('registkampus');
        } else {
            Session::flash('error', 'Register gagal! Mohon hubungi admin MagangHub');
            return redirect()->route('registkampus');
        }
    }
}
