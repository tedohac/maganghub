<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Mahasiswa extends Model
{
    public static function getCount()
    {
        $mahasiswa = Mahasiswa::join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                                ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                                ->join('univs', 'prodis.prodi_univ_id', '=', 'univs.univ_id')
                                ->where('univ_user_email', Auth::User()->user_email)
                                ->get();
        return $mahasiswa->count();
    }
    
    public static function getStatus()
    {
        $mahasiswa = Mahasiswa::where('mahasiswa_user_email', Auth::User()->user_email)->first();
        return $mahasiswa->mahasiswa_status;
    }
    
    public static function getCountByProdi($prodi_id)
    {
        $mahasiswa = Mahasiswa::join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                                ->where('dospem_prodi_id', $prodi_id)
                                ->get();
        return $mahasiswa->count();
    }
    
    public static function getCountByDospem($dospem_id)
    {
        $mahasiswa = Mahasiswa::where('mahasiswa_dospem_id', $dospem_id)
                                ->get();
        return $mahasiswa->count();
    }
    
    public static function isLengkap($mahasiswa_user_email)
    {
        $mahasiswa = Mahasiswa::where('mahasiswa_user_email', $mahasiswa_user_email)
                                ->first();
        if(empty($mahasiswa)) return false;

        if($mahasiswa->mahasiswa_city_id!="" && 
            $mahasiswa->mahasiswa_no_tlp!="" && 
            $mahasiswa->mahasiswa_alamat!="" && 
            $mahasiswa->mahasiswa_tempat_lahir!="" && 
            $mahasiswa->mahasiswa_tgl_lahir!="" && 
            $mahasiswa->mahasiswa_profile_pict!="" && 
            $mahasiswa->mahasiswa_cv!="" && 
            $mahasiswa->mahasiswa_khs!="")
            return true;
        else return false;
    }
}
