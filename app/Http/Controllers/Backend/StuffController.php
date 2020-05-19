<?php

namespace App\Http\Controllers\Backend;

use App\Category;
use App\DataTables\StuffDataTable;
use App\Http\Controllers\Controller;
use App\Stuff;
use Illuminate\Http\Request;

class StuffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StuffDataTable $dataTable)
    {
        return $dataTable->render('backend.stuff.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::orderBy('name', 'ASC')->get();
        $storage = Category::orderBy('name', 'ASC')->get();
        return view('backend.stuff.create', compact('category', 'storage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'category_id' => 'required|numeric|exists:categories,id',
            'storage_id' => 'required|numeric|exists:storages,id',
            'description' => 'required|string'
        ]);

        try {
            $stuff = Stuff::firstOrCreate([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'storage_id' => $request->storage_id,
                'description' => $request->description
            ]);

            session()->flash('success', 'Data Berhasil di-Tambahkan !');
            return redirect(route('Stuff.index'));
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi Kesalahan !');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
