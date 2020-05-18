<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'table_name',
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function admins()
    {
        return $this->hasMany('App\RoleAdmin');
    }

    public function cimts()
    {
        return $this->hasMany('App\RoleCimt');
    }

    public function res_providers()
    {
        return $this->hasMany('App\RoleResProvider');
    }
}
