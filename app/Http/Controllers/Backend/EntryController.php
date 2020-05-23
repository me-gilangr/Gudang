<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\EntryHeaderDataTable;
use App\EntryDetail;
use App\EntryHeader;
use App\Http\Controllers\Controller;
use App\StockCard;
use App\Stuff;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\DB;

class EntryController extends Controller
{
    public function index()
    {
        $stuff = Stuff::orderBy('name', 'ASC')->get();
        $cart = Cart::session(auth()->user()->id);
        return view('backend.entry.index', compact('stuff', 'cart'));
    }

    public function cancel(Request $request)
    {
        $cart = Cart::session(auth()->user()->id);
        foreach ($cart->getContent() as $item) {
            if ($item->attributes->supplier == session('Supplier_SE')) {
                $cart->remove($item->id);
            }
        }
        session()->forget('Supplier_SE');
        session()->forget('Description_SE');

        session()->flash('warning', 'Transaksi di-Batalkan !');
        return redirect(route('Entry.index'));
    }

    public function store(Request $request)
    {
        try {
            if (session()->has('Supplier_SE')) {
                $supplier = session('Supplier_SE');
                $desc = session('Description_SE');
                $cart = Cart::session(auth()->user()->id);
                if (!$cart->isEmpty()) {
                    DB::beginTransaction();
                    $header = EntryHeader::firstOrCreate([
                        'code' => 'TBM/'. time() . rand(1000, 9999),
                        'date_entry' => date('Y-m-d'),
                        'supplier' => $supplier,
                        'description' => $desc,
                        'user_id' => auth()->user()->id
                    ]);

                    foreach ($cart->getContent() as $item) {
                        if ($item->attributes->supplier == session('Supplier_SE')) {
                            $stuff = Stuff::findOrFail($item->id);
                            $detail = EntryDetail::firstOrCreate([
                                'entry_header_id' => $header->id,
                                'stuff_id' => $stuff->id,
                                'stock_in' => $item->quantity,
                                'description' => $item->attributes->desc_d
                            ]);

                            $stock = StockCard::where('stuff_id', '=', $stuff->id)->whereMonth('stock_date', '=', date('m'))->whereYear('stock_date', '=', date('Y'))->first();
                            if ($stock == null) {
                                $prefStock = StockCard::where('stuff_id', '=', $stuff->id)->whereMonth('stock_date', '=', date('m', strtotime('-1 month')))->whereYear('stock_date', '=', date('Y'))->first();
                                if ($prefStock == null) {
                                    $stock = StockCard::firstOrCreate([
                                        'stuff_id' => $stuff->id,
                                        'stock_date' => date('Y-m-d'),
                                        'stock_entry' => $item->quantity,
                                    ]);
                                } else {
                                    $modal = $prefStock->cap_stock + $prefStock->stock_entry - $prefStock->stock_out + $prefStock->stock_adjustment;
                                    $stock = StockCard::firstOrCreate([
                                        'stuff_id' => $stuff->id,
                                        'stock_date' => date('Y-m-d'),
                                        'cap_stock' => $modal,
                                        'stock_entry' => $item->quantity, 
                                    ]);
                                }
                            } else {
                                $stock->update([
                                    'stock_entry' => $stock->stock_entry+$item->quantity
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
                        if ($item->attributes->supplier == session('Supplier_SE')) {
                            $cart->remove($item->id);
                        }
                    }

                    session()->forget('Supplier_SE');
                    session()->forget('Description_SE');
                    session()->flash('success', 'Transaksi Selesai !');
                    return redirect(route('Entry.index'));

                } else {
                    session()->flash('error', 'Transaksi Barang Kosong ! Silahkan Pilih Data Barang !');
                    return redirect()->back();
                }
            } else {
                session()->flash('error', 'Terjadi Kesalahan !');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi Kesalahan !');
            return redirect()->back();
        }
    }

    public function data(EntryHeaderDataTable $dataTable)
    {
        return $dataTable->render('backend.entry.data');
    }
}
