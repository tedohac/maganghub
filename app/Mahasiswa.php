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
}
