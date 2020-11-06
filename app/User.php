<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'user_email';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_email', 'user_password', 'user_role', 'user_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_password', 'user_remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_email_verified_at' => 'datetime',
    ];

    public function getUserRoleAttribute($value)
    {
        return $value;
    }

    public function getUserStatusAttribute($value)
    {
        return $value;
    }

    public function getUserEmailAttribute($value)
    {
        return $value;
    }
    public function getAuthPassword()
    {
        return $this->user_password;
    }
    /**
     * Check the role of authenticated user.
     * @param $role_names
     * @return bool
     */
    public static function hasRoles($role_names)
    {
        if (Auth::check())
        {
            $user = User::where('user_email', Auth::User()->user_email)->where('user_role', $role_names)->first();
            if(empty($user)) return false;
            else return true;
        }
        else return false;
    }
}
