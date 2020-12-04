<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Rekrut extends Model
{
    public static function getCount()
    {
        $rekrut = Rekrut::join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                      ->where('mahasiswa_user_email', Auth::User()->user_email)
                      ->get();
        return $rekrut->count();
    }
}
