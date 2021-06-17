<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Rekrut extends Model
{
    public static function getCountAll()
    {
        $rekrut = Rekrut::join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                      ->where('mahasiswa_user_email', Auth::User()->user_email)
                      ->get();
        return $rekrut->count();
    }

    public static function getCount($status)
    {
        $rekrut = Rekrut::join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                      ->where('mahasiswa_user_email', Auth::User()->user_email)
                      ->where('rekrut_status', $status)
                      ->get();
        return $rekrut->count();
    }
    
    public static function getCountPerusahaan($status)
    {
        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->where('perusahaan_user_email', Auth::User()->user_email)
                        ->where('rekrut_status', $status);
        return $rekrut->count();
    }
    
    public static function getCountPerusahaanAll()
    {
        $rekrut = Rekrut::join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                        ->where('perusahaan_user_email', Auth::User()->user_email);
        return $rekrut->count();
    }
    
    public static function getRatingKampus($univ_id)
    {
        $rekrut = Rekrut::join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                        ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->groupBy('prodi_univ_id')
                        ->where('prodi_univ_id', $univ_id)
                        ->select(DB::raw('avg(rekrut_ratingto_mahasiswa) AS rating'));
        return $rekrut->first();
    }
}
