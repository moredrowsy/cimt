<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'date',
        'description',
    ];

    function user()
    {
        return $this->belongsTo('App\User');
    }

    function category()
    {
        return $this->belongsTo('App\Category');
    }
}
