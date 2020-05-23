<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntryHeader extends Model
{
    protected $fillable = [
        'code', 'date_entry', 'supplier', 'user_id', 'description'
    ];

    public function detail()
    {
        return $this->hasMany('App\EntryDetail', 'entry_header_id', 'id');
    }
}
