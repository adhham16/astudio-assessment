<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return response()->json(["user" => $users]);
    }
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json(["user" => $user]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'user not found'
            ], 404);
        }
    }

    public function store(UserCreateRequest $request)
    {
        $request['password'] = Hash::make($request['password']);

        $user = User::create($request->toArray());

        return response()->json(["message" => "User created successfully","user" => $user], 201);
    }


    public function update($id,UserUpdateRequest $request)
    {
        try {
            $user = User::findOrFail($id);
            if (isset($request['password'])) {
                $request['password'] = Hash::make($request['password']);
            }
            $user->update($request->toArray());
            return response()->json(["message" => "User updated successfully","user" => $user]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'user not found'
            ], 404);
        }

    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->timesheets()->delete();
            $user->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'user not found'
            ], 404);
        }

    }
}
