<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleCimt extends Model
{
    protected $fillable = [
        'user_id',
        'tel',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
