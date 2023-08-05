<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{

    public function index()
    {
        return User::all();
    }

    public function show($id)
    {
        return User::find($id);
    }

    public function store(UserRequest $req)
    {
        User::create($req->all());
        return response()->json([
            'message' => 'User successfully created'
        ], 201);
    }

    public function edit(UserRequest $req)
    {
        $user = User::find($req->id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $user->update($req->all());

        return response()->json([
            'message' => 'User successfully updated'
        ], 201);


    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->tokens()->delete();
        if(!$user){
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
        $user->delete();

        return response()->json([
            'message' => 'User successfully deleted'
        ], 201);
    }
}
