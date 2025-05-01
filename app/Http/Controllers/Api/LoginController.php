<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = User::where('email', $request->email)->first();

            if ($user->role === 'admin' || $user->role === 'trainer') {
                return response()->json([
                    'user' => $user,
                    'token' => $user->createToken('FlutterApp')->plainTextToken
                ]);
            } else {
                return response()->json(['message' => 'Admins only'], 403);
            }
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
