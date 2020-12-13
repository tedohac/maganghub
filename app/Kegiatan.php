<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Kegiatan extends Model
{
    public $timestamps = false;
    
    public static function getVerify($rekrut_id, $kegiatan_tgl)
    {
        $rekrut = Kegiatan::where('kegiatan_rekrut_id', $rekrut_id)
                      ->where('kegiatan_tgl', $kegiatan_tgl)
                      ->first();
        return $rekrut;
    }
}
