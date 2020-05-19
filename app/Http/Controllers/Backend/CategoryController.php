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
        $trashed = Category::onlyTrashed()->get();
        return $dataTable->render('backend.category.index', ['trashed' => $trashed]);
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
                'message' => 'Data Berhasil di-Tambahkan !',
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
                'message' => 'Data Di-Hapus !',
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
                'message' => 'Data Berhasil di-Ubah !',
                'status' => 200,
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e, 200);
        }
    }
    
    public function restore(Request $request)
    {
        $this->validate($request, [
            'restore_id' => 'required|numeric',
        ]);

        try {
            $category = Category::onlyTrashed()->where('id', '=', $request->restore_id)->firstOrFail();
            $category->restore();
            return response()->json([
                'message' => 'Data Berhasil di-Pulihkan !',
                'status' => 200,
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e, 400);
        }
    }

    public function permanent(Request $request)
    {
        $this->validate($request, [
            'permanent_id' => 'required|numeric',
        ]);
        try {
            $category = Category::onlyTrashed()->where('id', '=', $request->permanent_id)->firstOrFail();
            $category->forceDelete();

            return response()->json([
                'message' => 'Data di-Hapus Permanen !',
                'status' => 200,
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e, 400);
        }
    }
}
