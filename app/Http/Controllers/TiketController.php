<?php

namespace App\Http\Controllers;

use App\Tiket;
use App\Transfer;
use App\Kategoritiket;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    public $data = [];

    public function index()
    {
        $tiket = Tiket::with('Kategoritiket', 'Transfer', 'Event')->get();
        foreach ($tiket as $tiketini) {
           
            $this->data[] = [
                'id' => $tiketini->id,
                'harga' => $tiketini->harga,
                'stok' => $tiketini->stok,
                'katiket_id' => $tiketini->Kategoritiket->name,
                'event_id' => $tiketini->Event->title
            ];  
        }

        $dataJSON = ['data'=>$this->data];
        return response()->json($dataJSON, 200);
    }


  public function edit($id)
    {
        $tiket = Tiket::findOrFail($id);

        return response()->json($tiket, 200);
    }
    public function show($id)
    {
        $tiket = Transfer::where('tiket_id', $id)->get();

        return response()->json($tiket, 200);
    }

    public function store(Request $request)
    {
        $tiket = Tiket::create($request->except('image'));
        if ($request->hasFile('image')) {
            $uploaded_gambar = $request->file('image');
            $extension = $uploaded_gambar->getClientOriginalExtension();
            $filename = md5(time()) . '.' . $extension;
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . '/assets/images/tiket';
            $uploaded_gambar->move($destinationPath, $filename);
            $tiket->image = $filename;
        }
        $tiket->save();

        return response()->json($tiket, 201);
    }

    public function update(Request $request, $id)
    {
        $tiket = Tiket::findOrFail($id);
        $tiket->update($request->except('image'));
        if ($request->hasFile('image')) {
            $uploaded_gambar = $request->file('image');
            $extension = $uploaded_gambar->getClientOriginalExtension();
            $filename = md5(time()) . '.' . $extension;
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . '/assets/images/tiket';
            $uploaded_gambar->move($destinationPath, $filename);
            $tiket->image = $filename;
        }
        $tiket->save();

        return response()->json($tiket, 200);
    }

    public function destroy($id)
    {
        $tiket = Tiket::findOrFail($id);
        $tiket->delete();

        return response()->json($tiket, 204);
    }
}