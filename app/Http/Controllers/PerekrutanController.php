<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lowongan;
use App\Mahasiswa;
use App\Rekrut;
use App\Skill;
use Auth;
use DB;
use Session;

class PerekrutanController extends Controller
{
    public function apply($id)
    {
        $user_role = Auth::user()->user_role;
        if($user_role != 'mahasiswa') return abort(404);

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
        

        $rekrut = new Rekrut;
        $rekrut->rekrut_lowongan_id  = $lowongan->lowongan_id;
        $rekrut->rekrut_mahasiswa_id = $mahasiswa->mahasiswa_id;
        $rekrut->rekrut_tgl_melamar  = date("Y-m-d");
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
        $user_role = Auth::user()->user_role;
        if($user_role != 'perusahaan') return abort(404);

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
    
    public function detailpelamar($id)
    {
        $user_role = Auth::user()->user_role;
        if($user_role != 'perusahaan') return abort(404);

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

    	return view('lowongan.detail_pelamar', [
            'rekrut' => $rekrut,
            'skills' => $skills
        ]);
    }
    
    public function tolak($id)
    {
        if(empty($id)) abort(404);
        
        $user_role = Auth::user()->user_role;
        if($user_role != 'perusahaan') return abort(404);

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
}
