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
    
    public static function getCountUnverif()
    {
        $kegiatan = Kegiatan::join('rekruts', 'rekruts.rekrut_id', '=', 'kegiatans.kegiatan_rekrut_id')
                            ->join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                            ->where('mahasiswa_user_email', Auth::user()->user_email )
                            ->whereNull('kegiatan_verify_mentor')
                            ->get();
        return $kegiatan->count();
    }
    
    public static function getCountById($rekrut_id)
    {
        $kegiatan = Kegiatan::where('kegiatan_rekrut_id', $rekrut_id )
                            ->get();
        return $kegiatan->count();
    }
    
    public static function getCountUnverifById($rekrut_id)
    {
        $kegiatan = Kegiatan::where('kegiatan_rekrut_id', $rekrut_id )
                            ->whereNull('kegiatan_verify_mentor')
                            ->get();
        return $kegiatan->count();
    }
}
