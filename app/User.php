<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'address', 'tel', 'role_id',
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

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function admin()
    {
        return $this->hasOne('App\RoleAdmin');
    }

    public function cimt()
    {
        return $this->hasOne('App\RoleCimt');
    }

    public function res_provider()
    {
        return $this->hasOne('App\RoleResProvider');
    }

    public function resources()
    {
        return $this->hasMany('App\Resource');
    }

    public function incidents()
    {
        return $this->hasMany('App\Incident');
    }

    public function resinc_requesters()
    {
        return $this->hasMany('App\ResIncRequest', 'requester_id');
    }

    public function resinc_requestees()
    {
        return $this->hasMany('App\ResIncRequest', 'requestee_id');
    }
}
