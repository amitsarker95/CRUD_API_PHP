<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'role'=> 'required|in:admin,teacher,student',
        ]);

        $user = User::create(
            [
                'name' => $data['name'],
                'password'=> $data['password'],
                'role'=> $data['role'],
                'api_token' => Str::random(60)
            ]
        );

        return response()->json(['Message' => 'User created Successfully !', 'token' => $user->api_token, 'user' => $user]);
        
    }

    public function login(Request $request){
        $data = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('name', $data['name'])->first();
        if(!$user || !Hash::check($data['password'], $user->password)){
            return response()->json(['invalid'=> 'User is not found'], 401);
        }

        $user->api_token = Str::random(60);
        $user->save();
        return response()->json(['api_token'=> $user->api_token, 'user' => $user], 200);
    }
}
