<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StuffImage extends Model
{
    protected $fillable = [
        'stuff_id', 'name' 
    ];

    public function stuff()
    {
        return $this->belongsTo('App\Stuff');
    }
}
