<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdjustmentDetail extends Model
{
    protected $fillable = [
        'adjustment_id', 'stuff_id', 'stock_adjustment', 'description'
    ];
}
