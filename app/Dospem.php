<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Dospem extends Model
{
    public static function getCount()
    {
        $dospem = Dospem::join('prodis', 'dospems.dospem_prodi_id', '=', 'prodis.prodi_id')
                      ->join('univs', 'prodis.prodi_univ_id', '=', 'univs.univ_id')
                      ->where('univ_user_email', Auth::User()->user_email)
                      ->get();
        return $dospem->count();
    }

    public static function getCountByProdi($prodi_id)
    {
        $dospem = Dospem::where('dospem_prodi_id', $prodi_id)
                                ->get();
        return $dospem->count();
    }
}
