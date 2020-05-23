<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Stuff;
use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{
    public function EntryGet()
    {
        $cart = Cart::session(auth()->user()->id)->getContent();
        return response()->json($cart, 200);
    }
    
    public function EntryDetail(Request $request)
    {
        $cart = Cart::session(auth()->user()->id)->get($request->rowId);
        return response()->json($cart, 200);
    }

    public function EntryUpdate(Request $request)
    {
        $cart = Cart::session(auth()->user()->id)->update($request->rowId, [
            'quantity' => [
                'relative' => false,
                'value' => $request->stock_in,
            ],
            'attributes' => [
                'desc_d' => $request->desc_d,
                'desc_h'=> $request->desc_h,
                'supplier'=> $request->supplier,
                'transaksi'=> "Stock Entry",
            ]
        ]);
        return response()->json($cart, 200);
    }

    public function EntryDelete(Request $request)
    {
        $cart = Cart::session(auth()->user()->id)->remove($request->rowId);
        return response()->json($cart, 200);
    }

    public function EntryStore(Request $request)
    {
        try {
            $stuff = Stuff::with('category')->with('storage')->findOrFail($request->stuff);

            $cart = Cart::session(auth()->user()->id)->add([
                'id' => $stuff->id,
                'name' => $stuff->name,
                'price' => 1,
                'quantity' => $request->stock_entry,
                'attributes' => [
                    'transaksi' => 'Stock Entry',
                    'supplier' => $request->supplier,
                    'desc_h' => $request->desc_h,
                    'desc_d' => $request->desc_d,
                ],
                'associatedModel' => $stuff,
            ]);
            
            session(['Supplier_SE' => $request->supplier]);
            session(['Description_SE' => $request->desc_h]);

            $allCart = Cart::getContent();
            return response()->json($allCart, 200);
        } catch (\Exception $e) {
            return response()->json($e->__toString(), 400);
        }
    }

    public function OutGet()
    {
        $cart = Cart::session(auth()->user()->id)->getContent();
        return response()->json($cart, 200);
    }

    public function OutDetail(Request $request)
    {
        $cart = Cart::session(auth()->user()->id)->get($request->rowId);
        return response()->json($cart, 200);
    }

    public function OutUpdate(Request $request)
    {
        $cart = Cart::session(auth()->user()->id)->update($request->rowId, [
            'quantity' => [
                'relative' => false,
                'value' => $request->stock_out,
            ],
            'attributes' => [
                'desc_d' => $request->desc_d,
                'desc_h'=> $request->desc_h,
                'destination'=> $request->destination,
                'transaksi'=> "Stock Out",
            ]
        ]);
        return response()->json($cart, 200);
    }

    public function OutDelete(Request $request)
    {
        $cart = Cart::session(auth()->user()->id)->remove($request->rowId);
        return response()->json($cart, 200);
    }

    public function OutStore(Request $request)
    {
        try {
            $stuff = Stuff::with('category')->with('storage')->findOrFail($request->stuff);

            $cart = Cart::session(auth()->user()->id)->add([
                'id' => $stuff->id,
                'name' => $stuff->name,
                'price' => 1,
                'quantity' => $request->stock_out,
                'attributes' => [
                    'transaksi' => 'Stock Out',
                    'destination' => $request->destination,
                    'desc_h' => $request->desc_h,
                    'desc_d' => $request->desc_d,
                ],
                'associatedModel' => $stuff,
            ]);
            
            session(['Destination_SO' => $request->destination]);
            session(['Description_SO' => $request->desc_h]);

            $allCart = Cart::getContent();
            return response()->json($allCart, 200);
        } catch (\Exception $e) {
            return response()->json($e->__toString(), 400);
        }
    }
}
