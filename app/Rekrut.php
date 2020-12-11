<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Rekrut extends Model
{
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
}
