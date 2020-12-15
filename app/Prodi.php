<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Prodi extends Model
{
    public static function getCount()
    {
        $prodi = Prodi::join('univs', 'prodis.prodi_univ_id', '=', 'univs.univ_id')
                      ->where('univ_user_email', Auth::User()->user_email)
                      ->get();
        return $prodi->count();
    }
    
    public static function getCountByUniv($univ_id)
    {
        $prodi = Prodi::where('prodi_univ_id', $univ_id)
                                ->get();
        return $prodi->count();
    }
}
