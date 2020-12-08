<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\DiterimaEmail;
use App\Mail\UndanganEmail;
use App\Lowongan;
use App\Mahasiswa;
use App\Rekrut;
use App\Skill;
use Auth;
use DB;
use Mail;
use Session;
use Validator;

class PerekrutanController extends Controller
{
    public function apply($id)
    {
        $lowongan = Lowongan::where('lowongan_id', $id)->first();
        if(empty($lowongan)) return abort(404);
        
        $mahasiswa = Mahasiswa::where('mahasiswa_user_email', Auth::user()->user_email)->first();
        if(empty($lowongan)) return abort(404);

        if($mahasiswa->mahasiswa_status!='mencari') {
            Session::flash('error', 'Anda sudah mendapatkan tempat magang');
            return redirect()->back();
        }

        $rekrut = Rekrut::where('rekrut_mahasiswa_id', $mahasiswa->mahasiswa_id)
                        ->where('rekrut_lowongan_id', $lowongan->lowongan_id)->get();
        if(count($rekrut)) {
            Session::flash('error', 'Anda sudah melamar pada lowongan ini');
            return redirect()->back();
        }

        date_default_timezone_set('Asia/Jakarta');

        $rekrut = new Rekrut;
        $rekrut->rekrut_lowongan_id  = $lowongan->lowongan_id;
        $rekrut->rekrut_mahasiswa_id = $mahasiswa->mahasiswa_id;
        $rekrut->rekrut_waktu_melamar  = date("Y-m-d H:i:s");
        $rekrut->rekrut_status       = 'melamar';
        $simpanrekrut = $rekrut->save();
                            
        if($simpanrekrut)
        {
            Session::flash('success', 'Melamar lowongan berhasil, mohon tunggu perusahaan mengirim undangan test kepada anda.');
            return redirect()->back();
        } else {
            Session::flash('error', 'Melamar lowongan gagal! Mohon hubungi admin MagangHub');
            return redirect()->back();
        }
    }

    public function pelamar($id)
    {

        // DB::enableQueryLog();
        $lowongan = Lowongan::join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                            ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                            ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                            ->where('lowongan_id', $id)
                            ->where('perusahaan_user_email', Auth::user()->user_email )->first();
        // dd(DB::getQueryLog());
        if(empty($lowongan)) return abort(404);
        
        $rekruts = Rekrut::join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                        ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                        ->where('rekrut_lowongan_id', $id)->get();

    	return view('lowongan.pelamar', [
            'lowongan' => $lowongan,
            'rekruts' => $rekruts,
        ]);
    }
    
    public function lamaranlist()
    {

        // DB::enableQueryLog();
        $mahasiswa = Mahasiswa::join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                                ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                                ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                                ->where('mahasiswa_user_email', Auth::user()->user_email )->first();
        // dd(DB::getQueryLog());
        if(empty($mahasiswa)) abort(404);

        $rekruts = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                        ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->where('mahasiswa_user_email', Auth::user()->user_email )->get();
        
    	return view('lowongan.list_lamaran', [
            'mahasiswa' => $mahasiswa,
            'rekruts' => $rekruts,
        ]);
    }
    
    public function detailpelamar($id)
    {

        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                        ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                        ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                        ->where('perusahaan_user_email', Auth::user()->user_email )
                        ->where('rekrut_id', $id)->first();
        if(empty($rekrut)) return abort(404);

        $skills = Skill::where('skill_mahasiswa_id', $rekrut->rekrut_mahasiswa_id)
                        ->get();

        $rekrut->lowongan_requirement = htmlspecialchars_decode($rekrut->lowongan_requirement);
        $rekrut->lowongan_jobdesk     = htmlspecialchars_decode($rekrut->lowongan_jobdesk);

    	return view('lowongan.detail_pelamar', [
            'rekrut' => $rekrut,
            'skills' => $skills
        ]);
    }
    
    public function tolak($id)
    {
        if(empty($id)) abort(404);

        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->where('perusahaan_user_email', Auth::user()->user_email )
                        ->where('rekrut_id', $id)->first();
        if(empty($rekrut)) return abort(404);

        try
        {
            Rekrut::where('rekrut_id',$id)
                ->update([
                    'rekrut_status' => 'ditolak',
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub');
            return redirect()->back();
        }

        Session::flash('success', 'Tolak lamaran berhasil.');
        return redirect()->back();
    }
    
    
    public function bataltolak($id)
    {
        if(empty($id)) abort(404);

        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->where('perusahaan_user_email', Auth::user()->user_email )
                        ->where('rekrut_id', $id)->first();
        if(empty($rekrut)) return abort(404);

        try
        {
            Rekrut::where('rekrut_id',$id)
                ->update([
                    'rekrut_status' => 'melamar',
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub');
            return redirect()->back();
        }

        Session::flash('success', 'Batal tolak lamaran berhasil.');
        return redirect()->back();
    }
    
    
    public function undang(Request $request)
    {
        if(empty($request->rekrut_id)) abort(404);

        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                        ->where('perusahaan_user_email', Auth::user()->user_email )
                        ->where('rekrut_id', $request->rekrut_id)->first();
        if(empty($rekrut)) return abort(404);

        $rules = [
            'undangan_desc'     => 'required',
            'undangan_tanggal'  => 'required',
            'undangan_waktu'    => 'required',
            'undangan_alamat'   => 'required',
        ];
 
        $messages = [
            'undangan_desc.required'    => 'Masukan detail undangan',
            'undangan_tanggal.required' => 'Pilih tanggal undangan',
            'undangan_waktu.required'   => 'Pilih waktu undangan',
            'undangan_alamat.required'  => 'Masukan alamat undangan',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        

        try
        {
            date_default_timezone_set('Asia/Jakarta');

            Rekrut::where('rekrut_id', $request->rekrut_id)
                ->update([
                    'rekrut_status'         => 'diundang',
                    'rekrut_undangan_desc'  => htmlspecialchars($request->undangan_desc),
                    'rekrut_undangan_waktu' => $request->undangan_tanggal.' '.$request->undangan_waktu,
                    'rekrut_undangan_alamat'=> $request->undangan_alamat,
                    'rekrut_waktu_diundang' => date("Y-m-d H:i:s"),
                ]);
                
            Mail::to($rekrut->mahasiswa_user_email)->send(new UndanganEmail($rekrut, $request));

        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub');
            return redirect()->back();
        }

        Session::flash('success', 'Undangan test berhasil dikirim, menunggu mahasiswa konfirmasi kehadiran test.');
        return redirect()->back();
    }
    
    public function detailundangan($id)
    {
        
        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                        ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                        ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                        ->where('mahasiswa_user_email', Auth::user()->user_email )
                        ->where('rekrut_id', $id)->first();
        if(empty($rekrut)) return abort(404);

        $rekrut->lowongan_requirement = htmlspecialchars_decode($rekrut->lowongan_requirement);
        $rekrut->lowongan_requirement = htmlspecialchars_decode($rekrut->lowongan_requirement);
        $rekrut->rekrut_undangan_desc = htmlspecialchars_decode($rekrut->rekrut_undangan_desc);

    	return view('lowongan.detail_undangan', [
            'rekrut' => $rekrut
        ]);
    }
    
    public function confirmundangan($id)
    {
        if(empty($id)) abort(404);
        
        $rekrut = Rekrut::join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->where('mahasiswa_user_email', Auth::user()->user_email )
                        ->where('rekrut_id', $id)->first();
        if(empty($rekrut)) return abort(404);

        try
        {
            date_default_timezone_set('Asia/Jakarta');

            Rekrut::where('rekrut_id', $id)
                ->update([
                    'rekrut_status'                 => 'siap test',
                    'rekrut_waktu_konfirmundangan'  => date("Y-m-d H:i:s"),
                ]);

        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub ');
            return redirect()->back();
        }

        Session::flash('success', 'Undangan berhasil dikonfirmasi, semoga sukses!');
        return redirect()->back();
    }

    public function lolos($id)
    {
        if(empty($id)) abort(404);
        
        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                        ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                        ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->where('perusahaan_user_email', Auth::user()->user_email )
                        ->where('rekrut_id', $id)->first();
        if(empty($rekrut)) return abort(404);

        try
        {
            date_default_timezone_set('Asia/Jakarta');

            Rekrut::where('rekrut_id', $id)
                ->update([
                    'rekrut_status'                 => 'diterima',
                    'rekrut_waktu_diterima'  => date("Y-m-d H:i:s"),
                ]);

            Mail::to($rekrut->mahasiswa_user_email)->send(new DiterimaEmail($rekrut));

        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', 'Proses gagal, mohon coba kembali beberapa saat lagi atau hubungi admin MagangHub ');
            return redirect()->back();
        }

        Session::flash('success', 'Penerimaan mahasiswa magang berhasil, menunggu konfirmasi dari mahasiswa untuk mulai magang');
        return redirect()->back();
    }
}
