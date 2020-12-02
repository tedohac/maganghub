<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Lowongan extends Model
{
    public static function getCountPosted()
    {
        $lowongan = Lowongan::join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                      ->where('lowongan_status', 'post')
                      ->where('perusahaan_user_email', Auth::User()->user_email)
                      ->get();
        return $lowongan->count();
    }
}
