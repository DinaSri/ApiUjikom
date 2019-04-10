<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Bank;
use App\User;
class BankController extends Controller
{
   public $data = [];

    public function index()
    {
        $bank = Bank::with('MasterBank',  'User')->get();
        foreach($bank as $banks)
        {
            $this->data[] = [
                 'id' => $banks->id,
                'number' => $banks->number,
               'user_id' => $banks->User->name,
                'master_bank_id' => $banks->MasterBank->name
            ];
        }

       $dataJSON = ['data'=>$this->data];
        return response()->json($dataJSON, 200);
    }

    public function show($id)
    {
        $bank = Bank::findOrFail($id);

        return response()->json($bank, 200);
    }

    public function store(Request $request)
   {
        $bank = new Bank;
        $bank->number = $request->number;
        $bank->user_id = $request->user_id;
        $bank->master_bank_id = $request->master_bank_id;

        $bank->save();

        return response()->json($bank, 201);
    }

    public function update(Request $request, $id)
    {
        $bank = Bank::findOrFail($id);
        $bank->update($request->except('image'));
        if ($request->hasFile('image')) {
            $uploaded_gambar = $request->file('image');
            $extension = $uploaded_gambar->getClientOriginalExtension();
            $filename = md5(time()) . '.' . $extension;
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . '/assets/images/bank';
            $uploaded_gambar->move($destinationPath, $filename);
            $bank->image = $filename;
        }
        $bank->save();

        return response()->json($bank, 200);
    }

    public function destroy($id)
    {
        $bank = Bank::findOrFail($id);
        $bank->delete();

        return response()->json($bank, 204);
    }
}
