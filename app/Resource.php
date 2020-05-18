<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'pri_func_id',
        'sec_func_id',
        'description',
        'distance',
        'cost',
        'unit_cost_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function pri_func()
    {
        return $this->belongsTo('App\Func', 'pri_func_id');
    }

    public function sec_func()
    {
        return $this->belongsTo('App\Func', 'sec_func_id');
    }

    public function capabilities()
    {
        return $this->hasMany('App\Capability');
    }

    public function unit_cost()
    {
        return $this->belongsTo('App\UnitCost');
    }
}
