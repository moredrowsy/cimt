<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Capability extends Model
{
    protected $fillable = [
        'name',
        'resource_id',
    ];

    public function resource()
    {
        return $this->belongsTo('App\Resource');
    }
}
