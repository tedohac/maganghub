<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Univ;
use App\City;
use Validator;
use Session;
use Storage;
use Artisan;
use Auth;

class KampusController extends Controller
{
    public function __construct()
    {
    }

    public function list()
    {
        $univs = Univ::join('users', 'univs.email', '=', 'users.email')
                    ->whereNotNull('email_verified_at')
                    ->get();

        return view('kampus.list', [
            'univs' => $univs,
        ]);
    }

    public function detail($id)
    {
        $univ = Univ::leftJoin('cities', 'univs.city_id', '=', 'cities.id')
                    ->where('univs.id', $id)
                    ->first();

    	return view('kampus.detail', [
            'univ' => $univ,
        ]);
    }

    public function edit()
    {
        $this->middleware('auth');

        if(Auth::user()->role != 'admin kampus') abort(404);
        $univ = Univ::where('email', Auth::user()->email )->first();

        $city_name="";
        if($univ->city_id!="") $city_name = City::where('id', $univ->city_id)->first()->city_nama;

    	return view('kampus.edit', [
            'univ' => $univ,
            'city_name' => $city_name
        ]);
    }

    public function update(Request $request)
    {
        $univ = Univ::where('email', Auth::user()->email )->first();

        $rules = [
            'univ_npsn'       => 'required|unique:univs,npsn,'.$univ->id,
        ];
 
        $messages = [
            'univ_npsn.unique'    => 'Nomor NPSN sudah terdaftar pada kampus lain',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
 
        try
        {
            $filename = "";
            if($request->univ_profilepict!="") 
            {
                $filename = $univ->id.'.'.$request->file('univ_profilepict')->getClientOriginalExtension();
                
                // delete if exists
                if (Storage::disk('public')->exists( 'univ/'.$univ->profile_pict )) Storage::delete('public/univ/'.$univ->profile_pict);
                $request->file('univ_profilepict')->storeAs('public/univ', $filename);

                Artisan::call('cache:clear');
            }

            Univ::where('id',$univ->id)
                ->update([
                    'nama' => $request->univ_nama,
                    'npsn' => $request->univ_npsn,
                    'akreditasi' => isset($request->univ_akreditasi) ? $request->univ_akreditasi : null,
                    'tgl_berdiri' => $request->univ_tglberdiri!="" ? $request->univ_tglberdiri : null,
                    'alamat' => $request->univ_alamat!="" ? $request->univ_alamat : null,
                    'no_tlp' => $request->univ_notlp!="" ? $request->univ_notlp : null,
                    'website' => $request->univ_website!="" ? $request->univ_website : null,
                    'profile_pict' => $request->univ_profilepict!="" ? $filename : $univ->profile_pict,
                    'city_id' => $request->univ_city!="" ? $request->univ_city : null,
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi ');
            return redirect()->back();
        }

        Session::flash('success', 'Ubah data kampus berhasil, menunggu verifikasi MagangHub');
        return redirect('kampus/detail/'.$univ->id);
    }
}
