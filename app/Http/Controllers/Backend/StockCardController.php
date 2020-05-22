<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Stuff;
use Illuminate\Http\Request;

class StockCardController extends Controller
{
    public function index($id)
    {
        try {
            $stuff = Stuff::findOrFail($id);
            dd($stuff);
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi Kesalahan !');
            return redirect()->back();
        }
    }
}
