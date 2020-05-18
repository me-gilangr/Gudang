<?php

namespace App\Http\Controllers\Backend;

use App\Category;
use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('backend.category.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'detail' => 'nullable|string'
        ]);

        try {
            $category = Category::firstOrCreate([
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

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json([
                'success' => 'Data Berhasil di-Tambahkan !',
                'status' => 200,
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e, 400);
        }
    }

    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);
            return response()->json($category, 200);
        } catch (\Exception $e) {
            return response()->json($e, 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $this->validate($request, [
                'name' => 'required|string',
                'detail' => 'nullable|string',
            ]);
            
            $category->update([
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
}
