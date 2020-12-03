<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\Lowongan;
use App\Perusahaan;
use Artisan;
use Auth;
use Session;
use Storage;
use Validator;

class ProfilPerusahaanController extends Controller
{
    public function detail($id)
    {
        $perusahaan = Perusahaan::leftJoin('cities', 'cities.city_id', '=', 'perusahaans.perusahaan_city_id')
                                ->where('perusahaan_id', $id )->first();
        if(empty($perusahaan)) abort(404);

        $lowongans = Lowongan::where('lowongan_perusahaan_id', $id )
                             ->where('lowongan_status', 'post')
                             ->get();

    	return view('perusahaan.detail', [
            'perusahaan' => $perusahaan,
            'lowongans' => $lowongans
        ]);
    }
    
    public function edit()
    {
        $perusahaan = Perusahaan::leftJoin('cities', 'cities.city_id', '=', 'perusahaans.perusahaan_city_id')
                                ->where('perusahaan_user_email', Auth::user()->user_email )->first();
        if(empty($perusahaan)) abort(404);

    	return view('perusahaan.edit', [
            'perusahaan' => $perusahaan
        ]);
    }
    
    public function update(Request $request)
    {
        $perusahaan = Perusahaan::where('perusahaan_user_email', Auth::user()->user_email )->first();
        if(empty($perusahaan)) abort(404);

        $rules = [
            'perusahaan_nib' => 'required|unique:perusahaans,perusahaan_nib,'.$perusahaan->perusahaan_id.',perusahaan_id',
        ];
 
        $messages = [
            'perusahaan_nib.unique' => 'NIB sudah terdaftar pada perusahaan lain',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
 
        try
        {
            $filename_perusahaan_profile_pict = "";
            if($request->perusahaan_profile_pict!="") 
            {
                $filename_perusahaan_profile_pict = $perusahaan->perusahaan_id.'.'.$request->file('perusahaan_profile_pict')->getClientOriginalExtension();
                
                // delete if exists
                if (Storage::disk('public')->exists( 'perusahaan_profile/'.$perusahaan->perusahaan_profile_pict )) Storage::delete('public/perusahaan_profile/'.$perusahaan->perusahaan_profile_pict);
                $request->file('perusahaan_profile_pict')->storeAs('public/perusahaan_profile', $filename_perusahaan_profile_pict);

                Artisan::call('cache:clear');
            }

            $filename_perusahaan_nib_path = "";
            if($request->perusahaan_nib_path!="") 
            {
                $filename_perusahaan_nib_path = $perusahaan->perusahaan_id.'.'.$request->file('perusahaan_nib_path')->getClientOriginalExtension();
                
                // delete if exists
                if (Storage::disk('public')->exists( 'perusahaan_nib/'.$perusahaan->perusahaan_nib_path )) Storage::delete('public/perusahaan_nib/'.$perusahaan->perusahaan_nib_path);
                $request->file('perusahaan_nib_path')->storeAs('public/perusahaan_nib', $filename_perusahaan_nib_path);

                Artisan::call('cache:clear');
            }

            Perusahaan::where('perusahaan_id',$perusahaan->perusahaan_id)
                ->update([
                    'perusahaan_nama'        => $request->perusahaan_nama,
                    'perusahaan_nib'         => $request->perusahaan_nib,
                    'perusahaan_no_tlp'      => $request->perusahaan_no_tlp!="" ? $request->perusahaan_no_tlp : null,
                    'perusahaan_website'     => $request->perusahaan_website!="" ? $request->perusahaan_website : null,
                    'perusahaan_city_id'     => $request->perusahaan_city_id!="" ? $request->perusahaan_city_id : null,
                    'perusahaan_alamat'      => $request->perusahaan_alamat!="" ? $request->perusahaan_alamat : null,
                    'perusahaan_profile_pict'=> $request->perusahaan_profile_pict!="" ? $filename_perusahaan_profile_pict : $perusahaan->perusahaan_profile_pict,
                    'perusahaan_nib_path'    => $request->perusahaan_nib_path!="" ? $filename_perusahaan_nib_path : $perusahaan->perusahaan_nib_path,
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi ');
            return redirect()->back();
        }

        Session::flash('success', 'Ubah profil perusahaan berhasil, menunggu verifikasi MagangHub');
        return redirect('perusahaan/detail/'.$perusahaan->perusahaan_id);
    }
}
