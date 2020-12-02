<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perusahaan;
use App\Lowongan;
use Auth;
use DB;
use Session;
use Validator;

class ManageLowonganController extends Controller
{
    public function manage()
    {
        if(Auth::user()->user_role != 'perusahaan') return abort(404);

        $perusahaan = Perusahaan::where('perusahaan_user_email', Auth::user()->user_email )->first();
        if(empty($perusahaan)) return abort(404);

        $lowongans = Lowongan::join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                       ->where('perusahaan_user_email', Auth::user()->user_email)->get();

    	return view('perusahaan.manage_lowongan', [
            'perusahaan' => $perusahaan,
            'lowongans' => $lowongans
        ]);
    }
    
    public function list()
    {
        $lowongans = Lowongan::join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                             ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                             ->where('lowongan_status', 'post')
                             ->get();

        return view('perusahaan.list_lowongan', [
            'lowongans' => $lowongans,
        ]);
    }

    public function add()
    {
        if(Auth::user()->user_role != 'perusahaan') return abort(404);

        $perusahaan = Perusahaan::where('perusahaan_user_email', Auth::user()->user_email )->first();
        if(empty($perusahaan)) return abort(404);

    	return view('perusahaan.add_lowongan', [
            'perusahaan' => $perusahaan
        ]);
    }
    
    public function save(Request $request)
    {
        $rules = [
            'lowongan_judul'    => 'required',
            'lowongan_city_id'  => 'required|exists:cities,city_id',
            'lowongan_tgl_mulai'=> 'required',
        ];
 
        $messages = [
            'lowongan_judul.required'   => 'Masukan judul lowongan',
            'lowongan_city_id.required' => 'Pilih kota penempatan',
            'dospem_prodi_id.exists'    => 'Kota tidak terdaftar',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
 
        $perusahaan = Perusahaan::where('perusahaan_user_email', Auth::user()->user_email )->first();
        if(empty($perusahaan)) return abort(404);

        $lowongan = new Lowongan;
        $lowongan->lowongan_perusahaan_id= $perusahaan->perusahaan_id;
        $lowongan->lowongan_status       = $request->lowongan_status;
        $lowongan->lowongan_judul        = $request->lowongan_judul;
        $lowongan->lowongan_city_id      = $request->lowongan_city_id;
        $lowongan->lowongan_tgl_mulai    = $request->lowongan_tgl_mulai;
        $lowongan->lowongan_durasi       = $request->lowongan_durasi_a.'-'.$request->lowongan_durasi_b;
        $lowongan->lowongan_requirement  = htmlspecialchars($request->lowongan_requirement);
        $lowongan->lowongan_jobdesk      = htmlspecialchars($request->lowongan_jobdesk);
        $lowongan->lowongan_jlh_dibutuhkan= $request->lowongan_jlh_dibutuhkan;
        $simpanlowongan = $lowongan->save();

        if($simpanlowongan)
        {
            if($request->lowongan_status=='draft') Session::flash('success', 'Lowongan berhasil disimpan sebagai draft');
            elseif($request->lowongan_status=='post') Session::flash('success', 'Lowongan berhasil disimpan dan dipublikasikan');
            return redirect()->route('lowongan.manage');
        } else {
            Session::flash('error', 'Tambah program studi gagal! Mohon hubungi admin MagangHub');
            return redirect()->back();
        }
    }
    
    public function update(Request $request)
    {
        if(empty($request->lowongan_id)) abort(404);

        $rules = [
            'lowongan_judul'    => 'required',
            'lowongan_city_id'  => 'required|exists:cities,city_id',
            'lowongan_tgl_mulai'=> 'required',
        ];
 
        $messages = [
            'lowongan_judul.required'   => 'Masukan judul lowongan',
            'lowongan_city_id.required' => 'Pilih kota penempatan',
            'dospem_prodi_id.exists'    => 'Kota tidak terdaftar',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
 
        $perusahaan = Perusahaan::where('perusahaan_user_email', Auth::user()->user_email )->first();
        if(empty($perusahaan)) return abort(404);

        try
        {
            Lowongan::where('lowongan_id',$request->lowongan_id)
                    ->where('lowongan_perusahaan_id',$perusahaan->perusahaan_id)
                ->update([
                    'lowongan_status'        => $request->lowongan_status,
                    'lowongan_judul'        => $request->lowongan_judul,
                    'lowongan_city_id'        => $request->lowongan_city_id,
                    'lowongan_tgl_mulai'        => $request->lowongan_tgl_mulai,
                    'lowongan_durasi'        => $request->lowongan_durasi_a.'-'.$request->lowongan_durasi_b,
                    'lowongan_requirement'        => htmlspecialchars($request->lowongan_requirement),
                    'lowongan_jobdesk'        => htmlspecialchars($request->lowongan_jobdesk),
                    'lowongan_jlh_dibutuhkan'        => $request->lowongan_jlh_dibutuhkan,
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub');
            return redirect()->back();
        }

        if($request->lowongan_status=='draft') Session::flash('success', 'Lowongan berhasil diedit sebagai draft');
        elseif($request->lowongan_status=='post') Session::flash('success', 'Lowongan berhasil diedit dan dipublikasikan');
        return redirect()->back();
    }
    
    public function edit($id)
    {
        if(Auth::user()->user_role != 'perusahaan') return abort(404);
        // DB::enableQueryLog();
        $lowongan = Lowongan::join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                            ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                            ->where('perusahaan_user_email', Auth::user()->user_email )
                            ->where('lowongan_id', $id)
                            ->first();
                            
        // dd(DB::getQueryLog());
        if(empty($lowongan)) return abort(404);

    	return view('perusahaan.edit_lowongan', [
            'lowongan' => $lowongan
        ]);
    }
    
    public function delete(Request $request)
    {
        if(empty($request->id)) abort(404);
        
        try
        {
            Lowongan::where('lowongan_status','draft')->where('lowongan_id',$request->id)->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub');
            return redirect()->back();
        }

        Session::flash('success', 'Hapus lowongan berhasil');
        return redirect()->back();
    }
}
