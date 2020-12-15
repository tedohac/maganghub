<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    public static function getUnverified()
    {
        $perusahaan = Perusahaan::where('perusahaan_verified', null)->get();
        return $perusahaan->count();
    }
    
    public static function getIsVerified($perusahaan_id)
    {
        $perusahaan = Perusahaan::where('perusahaan_id', $perusahaan_id)->first();
        if(!empty($perusahaan)) return $perusahaan->perusahaan_verified;
        else return null;
    }
}
