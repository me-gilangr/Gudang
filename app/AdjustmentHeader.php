<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdjustmentHeader extends Model
{
    protected $fillable = [
        'code', 'user_id'
    ];
}
