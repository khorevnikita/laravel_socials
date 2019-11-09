<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        $api_token = Str::random(80);
        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->api_token = $api_token;
        $user->save();

        return response()->json([
            'api_token' => $api_token
        ], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = User::where("email",$request->email)->first();
            $api_token = Str::random(80);
            $user->api_token = $api_token;
            $user->save();
            return response()->json([
                'api_token' => $api_token
            ], 200);
        }
        return response()->json([
            'error' => "Credentials doesnt match"
        ], 403);
    }
}
