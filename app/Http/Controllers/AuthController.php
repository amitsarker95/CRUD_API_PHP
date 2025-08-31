<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|max:6',
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
}
