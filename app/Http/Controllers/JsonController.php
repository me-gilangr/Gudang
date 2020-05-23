<?php

namespace App\Http\Controllers;

use App\Category;
use App\Storage;
use App\Stuff;
use App\User;
use Illuminate\Http\Request;
use Datatables;

class JsonController extends Controller
{
    public function storage()
    {
        $storage = Storage::orderBy('name', 'ASC')->get();
        return response()->json($storage, 200);
    }

    public function trashedStorage()
    {
        $category = Storage::onlyTrashed()->orderBy('name', 'ASC');
        return Datatables::eloquent($category)
            ->editColumn('detail', function($data) {
                if ($data->detail == null) {
                    return '<i>Belum Ada Data</i>';
                } else {
                    return $data->detail;
                }
            })
            ->editColumn('deleted_at', function($data) {
                return date('d-m-Y | H:i:s', strtotime($data->deleted_at));
            })
            ->addColumn('action', function($data) {
                $btn = '
                <div class="btn-group text-center">  
                    <button class="btn btn-outline-info btn-sm flat ml-1" id="data-restore" data-id="'.$data->id.'">
                        <i class="fa fa-undo"></i> Pulihkan
                    </button> 
                    <button class="btn btn-outline-danger btn-sm flat ml-1" id="data-permanent" data-id="'.$data->id.'">
                        <i class="fa fa-times"></i>
                    </button> 
                </div>
                ';
                return $btn;
            })
            ->rawColumns(['detail', 'action'])
            ->make(true);
    }
    
    public function category()
    {
        $category = Category::orderBy('name', 'ASC')->get();
        return response()->json($category, 200);
    }

    public function trashedCategory()
    {
        $category = Category::onlyTrashed()->orderBy('name', 'ASC');
        return Datatables::eloquent($category)
            ->editColumn('detail', function($data) {
                if ($data->detail == null) {
                    return '<i>Belum Ada Data</i>';
                } else {
                    return $data->detail;
                }
            })
            ->editColumn('deleted_at', function($data) {
                return date('d-m-Y | H:i:s', strtotime($data->deleted_at));
            })
            ->addColumn('action', function($data) {
                $btn = '
                <div class="btn-group text-center">  
                    <button class="btn btn-outline-info btn-sm flat ml-1" id="data-restore" data-id="'.$data->id.'">
                        <i class="fa fa-undo"></i> Pulihkan
                    </button> 
                    <button class="btn btn-outline-danger btn-sm flat ml-1" id="data-permanent" data-id="'.$data->id.'">
                        <i class="fa fa-times"></i>
                    </button> 
                </div>
                ';
                return $btn;
            })
            ->rawColumns(['detail', 'action'])
            ->make(true);
    }

    
    public function trashedUser()
    {
        $category = User::onlyTrashed()->orderBy('deleted_at', 'DESC');
        return Datatables::eloquent($category)
            ->addColumn('level', function($data) {
                return $data->roles->first()->name;
            })
            ->editColumn('deleted_at', function($data) {
                return date('d-m-Y | H:i:s', strtotime($data->deleted_at));
            })
            ->addColumn('action', function($data) {
                $btn = '
                <div class="btn-group text-center">  
                    <button class="btn btn-outline-info btn-sm flat ml-1" id="data-restore" data-id="'.$data->id.'">
                        <i class="fa fa-undo"></i> Pulihkan
                    </button> 
                    <button class="btn btn-outline-danger btn-sm flat ml-1" id="data-permanent" data-id="'.$data->id.'">
                        <i class="fa fa-times"></i>
                    </button> 
                </div>
                ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function stuff()
    {
        $stuff = Stuff::orderBy('name', 'ASC')->get();
        return response()->json($stuff, 200);
    }

    public function detailStuff(Request $request)
    {
        $this->validate($request, [
            'id_for_detail' => 'required|numeric'
        ]);
        try {
            $stuff = Stuff::with('category')->with('storage')->findOrFail($request->id_for_detail);
            return response()->json($stuff, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Data Barang Tidak Ada !',
                'status' => 400,
            ], 400);
        }
    }

    public function trashedStuff()
    {
        $stuff = Stuff::onlyTrashed()->orderBy('deleted_at', 'DESC');
        return Datatables::eloquent($stuff)
            ->addColumn('kategori', function($data) {
                return $data->category->name;
            })
            ->addColumn('gudang', function($data) {
                return $data->storage->name;
            })
            ->editColumn('deleted_at', function($data) {
                return date('d-m-Y | H:i:s', strtotime($data->deleted_at));
            })
            ->addColumn('action', function($data) {
                $btn = '
                <div class="btn-group text-center">  
                    <button class="btn btn-outline-info btn-sm flat ml-1" id="data-restore" data-id="'.$data->id.'">
                        <i class="fa fa-undo"></i> Pulihkan
                    </button> 
                    <button class="btn btn-outline-danger btn-sm flat ml-1" id="data-permanent" data-id="'.$data->id.'">
                        <i class="fa fa-times"></i>
                    </button> 
                </div>
                ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
