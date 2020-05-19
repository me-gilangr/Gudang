<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\StorageDataTable;
use App\Http\Controllers\Controller;
use App\Storage;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StorageDataTable $dataTable)
    {
        return $dataTable->render('backend.storage.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'detail' => 'nullable|string'
        ]);

        try {
            $storage = Storage::firstOrCreate([
                'name' => $request->name,
                'detail' => $request->detail
            ]);
            return response()->json([
                'success' => 'Data Berhasil di-Tambahkan !',
                'status' => 200,
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e, 400);
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
        try {
            $storage = Storage::findOrFail($id);
            return response()->json($storage, 200);
        } catch (\Exception $e) {
            return response()->json($e, 400);
        }
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
        try {
            $storage = Storage::findOrFail($id);
            $this->validate($request, [
                'name' => 'required|string',
                'detail' => 'nullable|string',
            ]);
            
            $storage->update([
                'name' => $request->name,
                'detail' => $request->detail
            ]);

            return response()->json([
                'success' => 'Data Berhasil di-Ubah !',
                'status' => 200,
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $storage = Storage::findOrFail($id);
            $storage->delete();

            return response()->json([
                'success' => 'Data Di-Hapus !',
                'status' => 200,
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e, 400);
        }
    }
}
