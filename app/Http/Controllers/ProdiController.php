<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Univ;
use App\Prodi;
use Validator;
use Session;
use Auth;

class ProdiController extends Controller
{
    public function manage()
    {
        if(Auth::user()->user_role != 'admin kampus') return abort(404);

        $univ = Univ::where('univ_user_email', Auth::user()->user_email )->first();
        if(empty($univ)) return abort(404);

        $prodis = Prodi::join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                       ->where('univ_user_email', Auth::user()->user_email)->get();

    	return view('kampus.prodi', [
            'univ' => $univ,
            'prodis' => $prodis
        ]);
    }
    
    public function save(Request $request)
    {
        $rules = [
            'prodi_nama'      => 'required',
            'prodi_jenjang'   => 'required',
        ];
 
        $messages = [
            'prodi_nama.required'       => 'Masukan nama program studi',
            'prodi_jenjang.required'    => 'Pilih jenjang',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
 
        $univ = Univ::where('univ_user_email', Auth::user()->user_email )->first();
        if(empty($univ)) abort(404);

        $prodi = new Prodi;
        $prodi->prodi_univ_id   = $univ->univ_id;
        $prodi->prodi_nama      = $request->prodi_nama;
        $prodi->prodi_fakultas  = $request->prodi_fakultas!="" ? $request->prodi_fakultas : null;
        $prodi->prodi_jenjang   = $request->prodi_jenjang;
        $prodi->prodi_akreditasi= $request->prodi_akreditasi;
        $simpanprodi = $prodi->save();

        if($simpanprodi)
        {
            Session::flash('success', 'Tambah program studi berhasil');
            return redirect()->back();
        } else {
            Session::flash('error', 'Tambah program studi gagal! Mohon hubungi admin MagangHub');
            return redirect()->back();
        }
    }
    
    public function update(Request $request)
    {
        if(empty($request->edit_id)) abort(404);

        $rules = [
            'prodi_nama'      => 'required',
            'prodi_jenjang'   => 'required',
        ];
 
        $messages = [
            'prodi_nama.required'       => 'Masukan nama program studi',
            'prodi_jenjang.required'    => 'Pilih jenjang',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
 
        try
        {
            Prodi::where('prodi_id',$request->edit_id)
                ->update([
                    'prodi_nama'        => $request->prodi_nama,
                    'prodi_fakultas'    => isset($request->prodi_fakultas) ? $request->prodi_fakultas : null,
                    'prodi_jenjang'     => $request->prodi_jenjang,
                    'prodi_akreditasi'  => $request->prodi_akreditasi,
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub');
            return redirect()->back();
        }

        Session::flash('success', 'Edit program studi berhasil');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        if(empty($request->id)) abort(404);
        
        // try
        // {
            Prodi::where('prodi_id',$request->id)->delete();
        // } catch (\Illuminate\Database\QueryException $e) {
        //     Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub');
        //     return redirect()->back();
        // }

        Session::flash('success', 'Hapus program studi berhasil');
        return redirect()->back();
    }

    public function detailjson(Request $request)
    {
        $json = [];

        if(!empty($request->query('id'))){
            // DB::enableQueryLog();
            $json = Prodi::where('prodi_id', $request->query('id'))
                        ->first();
            // dd(DB::getQueryLog());
        }
        echo json_encode($json);
    }
}
