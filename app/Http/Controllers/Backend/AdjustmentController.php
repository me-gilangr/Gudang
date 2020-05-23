<?php

namespace App\Http\Controllers\Backend;

use App\EntryHeader;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdjustmentController extends Controller
{
    public function index()
    {
        $bm = EntryHeader::orderBy('created_at', 'DESC')->get();
        return view('backend.adjustment.index', compact('bm'));
    }
}
