<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Func extends Model
{
    protected $fillable = [
        'name',
    ];

    public function resources_pri()
    {
        return $this->hasMany('App\Resource', 'pri_func_id');
    }

    public function resources_sec()
    {
        return $this->hasMany('App\Resource', 'sec_func_id');
    }
}
