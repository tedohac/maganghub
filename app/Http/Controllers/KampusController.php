<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Univ;
use Validator;
use Session;
use Storage;
use Auth;

class KampusController extends Controller
{
    public function __construct()
    {
    }

    public function manage()
    {
        $this->middleware('auth');

        if(Auth::user()->role != 'admin kampus') abort(404);
        $univ = Univ::where('email', Auth::user()->email )->first();
        // echo $univ->nama;

    	return view('kampus.edit', [
            'univ' => $univ,
        ]);
    }

    public function update(Request $request)
    {
        $univ = Univ::where('email', Auth::user()->email )->first();

        $rules = [
            'univ_noskpt'       => 'required|unique:univs,no_skpt,'.$univ->id,
        ];
 
        $messages = [
            'univ_noskpt.unique'    => 'Nomor SKPT sudah terdaftar pada kampus lain',
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
                if (Storage::exists($filename)) Storage::delete($filename);
                $request->file('univ_profilepict')->storeAs('public/univ', $filename);
            }

            Univ::where('id',$univ->id)
                ->update([
                    'nama' => $request->univ_nama,
                    'no_skpt' => $request->univ_noskpt,
                    'tgl_skpt' => $request->univ_tglskpt!="" ? $request->univ_tglskpt : null,
                    'akreditasi' => isset($request->univ_akreditasi) ? $request->univ_akreditasi : null,
                    'tgl_berdiri' => $request->univ_tglberdiri!="" ? $request->univ_tglberdiri : null,
                    'alamat' => $request->univ_alamat!="" ? $request->univ_alamat : null,
                    'no_tlp' => $request->univ_notlp!="" ? $request->univ_notlp : null,
                    'website' => $request->univ_website!="" ? $request->univ_website : null,
                    'profile_pict' => $request->univ_profilepict!="" ? $filename : null,
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi ');
            return redirect()->route('kampus.manage');
        }

        Session::flash('success', 'Ubah data kampus berhasil, menunggu verifikasi MagangHub');
        return redirect()->route('kampus.manage');
    }
}
