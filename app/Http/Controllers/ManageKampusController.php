<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\Prodi;
use App\Univ;
use App\User;
use Artisan;
use Auth;
use Session;
use Storage;
use Validator;

class ManageKampusController extends Controller
{
    public function __construct()
    {
    }

    public function list()
    {
        $univs = Univ::join('users', 'univs.univ_user_email', '=', 'users.user_email')
                    ->whereNotNull('user_email_verified_at')
                    ->paginate(5);

        return view('kampus.list', [
            'univs' => $univs,
        ]);
    }

    public function detail($id)
    {
        $univ = Univ::leftJoin('cities', 'univs.univ_city_id', '=', 'cities.city_id')
                    ->where('univs.univ_id', $id)
                    ->first();

        $prodis = Prodi::where('prodi_univ_id', $id)->get();

    	return view('kampus.detail', [
            'univ' => $univ,
            'prodis' => $prodis,
        ]);
    }

    public function edit()
    {
        $univ = Univ::leftJoin('cities', 'cities.city_id', '=', 'univs.univ_city_id')
                    ->where('univ_user_email', Auth::user()->user_email )->first();
        if(empty($univ)) abort(404);

    	return view('kampus.edit', [
            'univ' => $univ,
            'city_name' => $city_name
        ]);
    }

    public function update(Request $request)
    {
        $univ = Univ::where('univ_user_email', Auth::user()->user_email )->first();
        if(empty($univ)) abort(404);

        $rules = [
            'univ_npsn'       => 'required|unique:univs,univ_npsn,'.$univ->univ_id.',univ_id',
        ];
 
        $messages = [
            'univ_npsn.unique'    => 'NPSN sudah terdaftar pada kampus lain',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
 
        try
        {
            $filename = "";
            if($request->univ_profile_pict!="") 
            {
                $filename = $univ->univ_id.'.'.$request->file('univ_profile_pict')->getClientOriginalExtension();
                
                // delete if exists
                if (Storage::disk('public')->exists( 'univ/'.$univ->univ_profile_pict )) Storage::delete('public/univ/'.$univ->univ_profile_pict);
                $request->file('univ_profile_pict')->storeAs('public/univ', $filename);

                Artisan::call('cache:clear');
            }

            Univ::where('univ_id',$univ->univ_id)
                ->update([
                    'univ_nama'          => $request->univ_nama,
                    'univ_npsn'          => $request->univ_npsn,
                    'univ_akreditasi'    => isset($request->univ_akreditasi) ? $request->univ_akreditasi : null,
                    'univ_tgl_berdiri'   => $request->univ_tgl_berdiri!="" ? $request->univ_tgl_berdiri : null,
                    'univ_alamat'        => $request->univ_alamat!="" ? $request->univ_alamat : null,
                    'univ_no_tlp'        => $request->univ_no_tlp!="" ? $request->univ_no_tlp : null,
                    'univ_website'       => $request->univ_website!="" ? $request->univ_website : null,
                    'univ_profile_pict'  => $request->univ_profile_pict!="" ? $filename : $univ->univ_profile_pict,
                    'univ_city_id'       => $request->univ_city_id!="" ? $request->univ_city_id : null,
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi ');
            return redirect()->back();
        }

        Session::flash('success', 'Ubah data kampus berhasil, menunggu verifikasi MagangHub');
        return redirect('kampus/detail/'.$univ->univ_id);
    }
}
