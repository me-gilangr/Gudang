<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntryDetail extends Model
{
    protected $fillable = [
        'entry_header_id', 'stuff_id', 'stock_in', 'description'
    ];

    public function header()
    {
        return $this->belongsTo('App\EntryHeader');
    }

    public function stuff()
    {
        return $this->belongsTo('App\Stuff');
    }
}
