<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockCard extends Model
{
    protected $fillable = [
        'stuff_id', 'stock_date', 'cap_stock', 'stock_entry', 'stock_out', 'stock_back_in', 'stock_back_out', 'stock_adjustment'
    ];

    public function stuff()
    {
        return $this->belongsTo('App\Stuff');
    }
}
