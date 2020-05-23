<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\OutDetail;
use App\OutHeader;
use App\StockCard;
use App\Stuff;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\DB;

class OutController extends Controller
{
    public function index()
    {
        $stuff = Stuff::orderBy('name', 'ASC')->get();
        $cart = Cart::session(auth()->user()->id);
        return view('backend.out.index', compact('stuff', 'cart'));
    }

    
    public function cancel(Request $request)
    {
        $cart = Cart::session(auth()->user()->id);
        foreach ($cart->getContent() as $item) {
            if ($item->attributes->destination == session('Destination_SO')) {
                $cart->remove($item->id);
            }
        }
        session()->forget('Destination_SO');
        session()->forget('Description_SO');

        session()->flash('warning', 'Transaksi di-Batalkan !');
        return redirect(route('Out.index'));
    }

    public function store(Request $request)
    {
        try {
            if (session()->has('Destination_SO')) {
                $destination = session('Destination_SO');
                $desc = session('Description_SO');
                $cart = Cart::session(auth()->user()->id);
                if (!$cart->isEmpty()) {
                    DB::beginTransaction();
                    $header = OutHeader::firstOrCreate([
                        'code' => 'TBK/'. time() . rand(1000, 9999),
                        'date_out' => date('Y-m-d'),
                        'destination' => $destination,
                        'description' => $desc,
                        'user_id' => auth()->user()->id
                    ]);

                    foreach ($cart->getContent() as $item) {
                        if ($item->attributes->destination == session('Destination_SO')) {
                            $stuff = Stuff::findOrFail($item->id);
                            $detail = OutDetail::firstOrCreate([
                                'out_header_id' => $header->id,
                                'stuff_id' => $stuff->id,
                                'stock_out' => $item->quantity,
                                'description' => $item->attributes->desc_d
                            ]);

                            $stock = StockCard::where('stuff_id', '=', $stuff->id)->whereMonth('stock_date', '=', date('m'))->whereYear('stock_date', '=', date('Y'))->first();
                            if ($stock == null) {
                                $prefStock = StockCard::where('stuff_id', '=', $stuff->id)->whereMonth('stock_date', '=', date('m', strtotime('-1 month')))->whereYear('stock_date', '=', date('Y'))->first();
                                if ($prefStock == null) {
                                    $stock = StockCard::firstOrCreate([
                                        'stuff_id' => $stuff->id,
                                        'stock_date' => date('Y-m-d'),
                                        'stock_out' => $item->quantity,
                                    ]);
                                } else {
                                    $modal = $prefStock->cap_stock + $prefStock->stock_entry - $prefStock->stock_out + $prefStock->stock_adjustment;
                                    $stock = StockCard::firstOrCreate([
                                        'stuff_id' => $stuff->id,
                                        'stock_date' => date('Y-m-d'),
                                        'cap_stock' => $modal,
                                        'stock_out' => $item->quantity, 
                                    ]);
                                }
                            } else {
                                $stock->update([
                                    'stock_out' => $stock->stock_out+$item->quantity
                                ]);
                            }
                        }
                    }

                    if (!$header || !$detail || !$stock) { 
                        DB::rollback();
                    } else {
                        DB::commit();
                    }

                    foreach ($cart->getContent() as $item) {
                        if ($item->attributes->destination == session('Destination_SO')) {
                            $cart->remove($item->id);
                        }
                    }

                    session()->forget('Destination_SO');
                    session()->forget('Description_SO');
                    session()->flash('success', 'Transaksi Selesai !');
                    return redirect(route('Out.index'));

                } else {
                    session()->flash('error', 'Transaksi Barang Kosong ! Silahkan Pilih Data Barang !');
                    return redirect()->back();
                }
            } else {
                session()->flash('error', 'Terjadi Kesalahan !');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            dd($e);
            session()->flash('error', 'Terjadi Kesalahan !');
            return redirect()->back();
        }
    }
}
