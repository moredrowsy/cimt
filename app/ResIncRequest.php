<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResIncRequest extends Model
{
    protected $fillable = [
        'requester_id',
        'requestee_id',
        'resource_id',
        'incident_id',
        'status',
    ];


    public function requester_user()
    {
        return $this->belongsTo('App\User', 'requester_id');
    }

    public function requestee_user()
    {
        return $this->belongsTo('App\User', 'requestee_id');
    }

    public function resource()
    {
        return $this->belongsTo('App\Resource');
    }

    public function incident()
    {
        return $this->belongsTo('App\Incident');
    }
}
