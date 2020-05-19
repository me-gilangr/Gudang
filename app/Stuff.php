<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stuff extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'category_id', 'storage_id', 'description'
    ];
    
}
