<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Univ extends Model
{
    public static function getUnverified()
    {
        $univ = Univ::where('univ_verified', null)->get();
        return $univ->count();
    }

    public static function getIsVerified($univ_id)
    {
        $univ = Univ::where('univ_id', $univ_id)->first();
        if(!empty($univ)) return $univ->univ_verified;
        else return null;
    }
}
