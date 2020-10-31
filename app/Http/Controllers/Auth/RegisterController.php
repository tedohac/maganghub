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
            'univ_nama'     => 'required|max:100',
            'univ_npsn'     => 'required|unique:univs,npsn',
            'univ_email'    => 'required|email|unique:users,email',
            'univ_pass'     => 'required|confirmed'
        ];
 
        $messages = [
            'univ_nama.required'    => 'Masukan nama kampus',
            'univ_nama.max'         => 'Nama kampus maksimal 100 karakter',
            'univ_npsn.required'    => 'Masukan nomor NPSN',
            'univ_npsn.unique'      => 'Nomor NPSN sudah terdaftar',
            'univ_email.required'   => 'Masukan e-mail admin kampus',
            'univ_email.email'      => 'E-mail tidak valid',
            'univ_email.unique'     => 'E-mail sudah terdaftar',
            'univ_pass.required'    => 'Masukan password',
            'univ_pass.confirmed'   => 'Password tidak sama dengan konfirmasi password'
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
 
        $user = new User;
        $user->email = strtolower($request->univ_email);
        $user->role = 'admin kampus';
        $user->status = '1';
        $user->password = Hash::make($request->univ_pass);
        $user->verify_token = Str::random(32);
        $simpanuser = $user->save();

        $univ = new Univ;
        $univ->email = strtolower($request->univ_email);
        $univ->nama = ucwords(strtolower($request->univ_nama));
        $univ->npsn = $request->univ_npsn;
        $simpanuniv = $univ->save();

        if($simpanuser && $simpanuniv)
        {
            Mail::to($request->univ_email)->send(new VerificationEmail($request->univ_email, $user->verify_token, $user->role));

            Session::flash('success', 'Register berhasil! Periksa email anda untuk melakukan verifikasi');
            return redirect()->route('registkampus');
        } else {
            Session::flash('error', 'Register gagal! Mohon hubungi admin MagangHub');
            return redirect()->route('registkampus');
        }
    }
}
