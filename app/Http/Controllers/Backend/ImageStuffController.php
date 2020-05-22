<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Stuff;
use App\StuffImage;
use Illuminate\Http\Request;
use File;

class ImageStuffController extends Controller
{
    public function store(Request $request, $id)
    {
        try {
			$stuff = Stuff::findOrFail($id);

			$imageName = null;

			if ($request->hasFile('file')) {
				$image = $request->file('file');
				$imageName = time() . rand(10, 99) . $stuff->id . '.' . $image->getClientOriginalExtension();
				$image->storeAs('stuff', $imageName, 'image');
	
				$stuffImage = StuffImage::create([
					'stuff_id' => $stuff->id,
					'name' => $imageName
				]);
				return response()->json(['success' => 'Foto Berhasil di-Upload.'], 200);
			} else {
				return response()->json(['error' => 'Terjadi Kesalahan !'], 200);
			}
		} catch (\Exception $e) {
			// return response()->json(['error' => 'Terjadi Kesalahan !'], 200);										
			return response()->json($e->__toString(), 400);										
		}
    }

    public function image($id)
    {
        try {
			$stuff = Stuff::findOrFail($id);
			if (count($stuff->image) == 0) {
				return response()->json(['empty' => 'Belum Ada Photo'], 200);
			} else {
				$data = $stuff->image;
				return response()->json($data, 200);
			}
		} catch (\Exception $e) {
			return response()->json(['error' => 'Terjadi Kesalahan !'], 400);										
		}
    }

    public function delete(Request $request, $id)
    {
		$this->validate($request, [
			'id' => 'required|numeric'
		]);

		try {
			$stuff = Stuff::findOrFail($id);
            $stuffImage = StuffImage::where('id', '=', $request->id)->where('stuff_id', '=', $stuff->id)->firstOrFail();
            $path = 'images/stuff/'.$stuffImage->name;
            if (File::exists($path)) {
                File::delete($path);
            }
			$stuffImage->delete();

			return response()->json(['success' => 'Photo di-Hapus.'], 200);													
		} catch (\Exception $e) {
			return response()->json(['error' => 'Terjadi Kesalahan !'], 200);										
		}
    }
}
