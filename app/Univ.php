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

    public static function getIsBanned($univ_id)
    {
        $univ = Univ::join('users', 'univs.univ_user_email', '=', 'users.user_email')
                    ->where('univ_id', $univ_id)->first();
        
        if(!empty($univ)) return $univ->user_status==0;
        else return null;
    }
}
