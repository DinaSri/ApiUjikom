<?php

namespace App\Http\Controllers;

use App\Event;
use App\Transfer;
use App\Categori;
use File;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public $data = [];

    public function index()
    {
        $event = Event::with('Categori', 'Transfer', 'User')->get();
        foreach ($event as $eventini) {
           
            $this->data[] = [
                'id' => $eventini->id,
                'title' => $eventini->title,
                'desc' => $eventini->desc,
                'penyelenggara' => $eventini->penyelenggara,
                'tanggal' => $eventini->tanggal,
                'waktu' => $eventini->waktu,
                'lokasi' => $eventini->lokasi,
                'image' => $eventini->image,
                'category_id' => $eventini->Categori->name,
                'status' => $eventini->status,
                'user_id' => $eventini->User->name
            ];  
        }

        $dataJSON = ['data'=>$this->data];
        return response()->json($dataJSON, 200);
    }


  public function edit($id)
    {
        $event = Event::findOrFail($id);

        return response()->json($event, 200);
    }
    public function show($id)
    {
        $event = Transfer::where('event_id', $id)->get();

        return response()->json($event, 200);
    }

   
    public function store(Request $request)
    {
        $event = new Event;
        $event->title = $request->title;
        $event->desc = $request->desc;
        $event->penyelenggara = $request->penyelenggara;
        $event->tanggal = $request->tanggal;
        $event->waktu = $request->waktu;
        $event->lokasi = $request->lokasi;
         $event->category_id = $request->category_id;
        $event->status = 'Belum Terverifikasi';
        $event->user_id = $request->user_id;
        if ($request->hasFile('image')) {
            $uploaded_gambar = $request->file('image');
            $extension = $uploaded_gambar->getClientOriginalExtension();
            $filename = md5(time()) . '.' . $extension;
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'assets/images/event';
            $uploaded_gambar->move($destinationPath, $filename);
            $event->image = $filename;
        }
        $event->save();

        return response()->json($event, 201);
    }


   



    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->title = $request->title;
        $event->desc = $request->desc;
        $event->penyelenggara = $request->penyelenggara;
        $event->tanggal = $request->tanggal;
        $event->waktu = $request->waktu;
        $event->lokasi = $request->lokasi;
         $event->category_id = $request->category_id;
        $event->status = 'Belum Terverifikasi';
        $event->user_id = $request->user_id;
        if ($request->hasFile('image')) {
            $uploaded_gambar = $request->file('image');
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'assets/images/event';
            $extension = $uploaded_gambar->getClientOriginalExtension();
            $filename = md5(time()) . '.' . $extension;
            $uploaded_gambar->move($destinationPath, $filename);
            if ($event->image) {
                $old_image = $event->image;
                $filePath = public_path() . DIRECTORY_SEPARATOR . 'assets/images/event/' . DIRECTORY_SEPARATOR . $event->image;
                try {
                    file::delete($filePath);
                }  catch (FileNotFoundException $e) {

                }
            }
            $event->image = $filename;
        }
        $event->save();

        return response()->json($event, 200);
    }


    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json($event, 204);
    }

    public function publish($id)
    {
        $event = Event::findOrFail($id);

        if ($event->status === 'Belum Terverifikasi') {
            $event->status = 'Terverifikasi';
        }

        $event->save();
        return response()->json($event, 200);
    }
}
