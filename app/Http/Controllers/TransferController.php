<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transfer;
// use App\MasterBank;
use App\Bank;
use App\User;

class TransferController extends Controller
{
    public $data = [];

    public function index()
    {
        $transfer = Transfer::with('User', 'Event', 'Bank','Tiket')->get();
        foreach($transfer as $trans) {
            $bank = Bank::where('master_bank_id', $trans->bank_id)->get();
            $this->data[] = [
                'id' => $trans->id,
                'nominal' => $trans->nominal,
                'desc' => $trans->desc,
                'status' => $trans->status,
                'user_id' => $trans->User->name,
                'bank_id' => $trans->Bank->MasterBank->name,
                'event_id' => $trans->Event->title,
                'jumlah_tiket' => $trans->jumlah_tiket,
                'tiket_id' => $trans->Tiket->harga
            ];
        }

        $dataJSON = ['data'=>$this->data];
        return response()->json($dataJSON, 200);
    }

    public function show($id)
    {
        $transfer = Transfer::findOrFail($id);

        return response()->json($transfer, 200);
    }

    public function store(Request $request)
    {
        $transfer = new Transfer;
        $transfer->user_id = $request->user_id;
        
        $transfer->nominal = $request->tiket_id*$request->$jumlah_tiket;
        $transfer->desc = $request->desc;
        $transfer->status = 'Belum Terverifikasi';
        $transfer->event_id = $request->event_id;
          $transfer->jumlah_tiket = $request->jumlah_tiket;
        $transfer->bank_id = $request->bank_id;
        $transfer->tiket_id= $request->tiket_id;
        $transfer->save();

        return response()->json($transfer, 201);
    }

    public function update(Request $request, $id)
    {
        $transfer = Transfer::findOrFail($id);
        $transfer->user_id = $request->user_id;
        $transfer->nominal = $request->tiket_id[$id]*$request->$jumlah_tiket[$id];
        $transfer->desc = $request->desc;
        $transfer->status = 'Belum Terverifikasi';
        $transfer->event_id = $request->event_id;
        $transfer->jumlah_tiket = $request->jumlah_tiket;
        $transfer->bank_id = $request->bank_id;
        $transfer->tiket_id= $request->tiket_id;
       
        $transfer->save();
        // $transfer->update($request->all());

        return response()->json($transfer, 200);
    }
    public function destroy($id)
    {
        $transfer = Transfer::findOrFail($id);
        $transfer->delete();

        return response()->json($transfer, 204);
    }

    public function publish($id)
    {
        $transfer = Transfer::findOrFail($id);

        if ($transfer->status === 'Belum Terverifikasi') {
            $transfer->status = 'Terverifikasi';
        }

        $transfer->save();
        return response()->json($transfer, 200);
    }
}
