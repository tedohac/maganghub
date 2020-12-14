<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Kegiatan extends Model
{
    public $timestamps = false;
    
    public static function getInfo($rekrut_id, $kegiatan_tgl)
    {
        $rekrut = Kegiatan::where('kegiatan_rekrut_id', $rekrut_id)
                      ->where('kegiatan_tgl', $kegiatan_tgl)
                      ->first();
        return $rekrut;
    }
    
    public static function getCountAll()
    {
        $kegiatan = Kegiatan::join('rekruts', 'rekruts.rekrut_id', '=', 'kegiatans.kegiatan_rekrut_id')
                            ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                            ->where('mahasiswa_user_email', Auth::user()->user_email )
                            ->get();
        return $kegiatan->count();
    }
}
