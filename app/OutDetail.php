<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutDetail extends Model
{
    protected $fillable = [
        'out_header_id', 'stuff_id', 'stock_out', 'description'
    ];
}
