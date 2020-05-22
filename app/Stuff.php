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
    

    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'category_id');
    }

    public function storage()
    {
        return $this->hasOne('App\Storage', 'id', 'storage_id');
    }

    public function stock()
    {
        return $this->hasMany('App\StockCard', 'stuff_id', 'id');
    }
    
    public function image()
    {
        return $this->hasMany('App\StuffImage', 'stuff_id', 'id');
    }
}
