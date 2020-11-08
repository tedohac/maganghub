<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\NewDospemEmail;
use App\Rules\NikDospemRule;
use App\Univ;
use App\Prodi;
use App\User;
use App\Dospem;
use Validator;
use Session;
use Hash;
use Mail;
use Auth;

class DospemController extends Controller
{
    public function manage()
    {
        $univ = Univ::where('univ_user_email', Auth::user()->user_email )->first();
        if(empty($univ)) abort(404);

        $dospems = Dospem::join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->join('users', 'users.user_email', '=', 'dospems.dospem_user_email')
                        ->where('prodis.prodi_univ_id', $univ->univ_id)
                        ->get();

    	return view('kampus.dospem', [
            'univ' => $univ,
            'dospems' => $dospems
        ]);
    }
    
    public function save(Request $request)
    {
        $univ = Univ::where('univ_user_email', Auth::user()->user_email )->first();
        if(empty($univ)) abort(404);

        $rules = [
            'dospem_nik'        => ['required', new NikDospemRule($univ->univ_id)],
            'dospem_nama'       => 'required',
            'dospem_prodi_id'   => 'required|exists:prodis,prodi_id,prodi_univ_id,'.$univ->univ_id,
            'dospem_user_email' => 'required|email|unique:users,user_email',
        ];
 
        $messages = [
            'dospem_nik.required'       => 'Masukan NIK Dosen Pembimbing',
            'dospem_nama.required'      => 'Masukan nama Dosen Pembimbing',
            'dospem_prodi_id.required'  => 'Pilih PRODI Dosen Pembimbing',
            'dospem_prodi_id.exists'    => 'PRODI Tidak Terdaftar',
            'dospem_user_email.required'=> 'Masukan e-mail Dosen Pembimbing',
            'dospem_user_email.email'   => 'Format e-mail tidak valid',
            'dospem_user_email.unique'  => 'E-mail sudah terdaftar',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
 
        $passwordTemp = Str::random(6);

        $user = new User;
        $user->user_email        = strtolower($request->dospem_user_email);
        $user->user_role         = 'dospem';
        $user->user_status       = '1';
        $user->user_password     = Hash::make($passwordTemp);
        $user->user_verify_token = Str::random(32);
        $simpanuser = $user->save();

        $dospem = new Dospem;
        $dospem->dospem_user_email  = strtolower($request->dospem_user_email);
        $dospem->dospem_prodi_id    = $request->dospem_prodi_id;
        $dospem->dospem_nik         = $request->dospem_nik;
        $dospem->dospem_nama        = $request->dospem_nama;
        $simpandospem = $dospem->save();

        if($simpanuser && $simpandospem)
        {
            $prodi = Prodi::where('prodi_id', $request->dospem_prodi_id)->first();
            Mail::to($request->dospem_user_email)->send(new NewDospemEmail($request, $univ->univ_nama, $prodi->prodi_nama, $user->user_verify_token, $passwordTemp));

            Session::flash('success', 'Tambah program studi berhasil');
            return redirect()->back();
        } else {
            Session::flash('error', 'Tambah program studi gagal! Mohon hubungi admin MagangHub');
            return redirect()->back();
        }
    }
    
}
