<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutHeader extends Model
{
    protected $fillable = [
        'code', 'date_out', 'destination', 'user_id', 'description'
    ];
}
