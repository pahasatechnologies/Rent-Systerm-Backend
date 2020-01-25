<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use  Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    const ROLES = [
        'ADMIN' => 'admin',
        'TENANT' => 'tenant',
        'LANDLORD' => 'landlord',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email', 'phone', 'image', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    public function social_accounts()
    {
        return $this->hasMany('App\SocialAccount');
    }

    public function listings()
    {
        return $this->hasMany('App\Listing');
    }

    public  function  getJWTIdentifier()
    {
        return  $this->getKey();
    }
    public  function  getJWTCustomClaims()
    {
        return [];
    }
}
