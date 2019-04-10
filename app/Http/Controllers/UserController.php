<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public $data = [];

    public function index()
    {
        $user = User::with('Transfer')->get();
        foreach($user as $users) {
            $this->data[] = [
                'id' => $users->id,
                'name' => $users->name,
                'email' => $users->email,
                'transfer' => $users->Transfer
            ];
        }

        $dataJSON = ['data'=>$this->data];
        return response()->json($dataJSON, 200);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user, 200);
    }

    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'role' =>'member',
        ]);

        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json($user, 204);
    }
}
