<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all()->where('role', 'student'));
    }

    public function store(Request $request)
    {
        $user = User::create($request->only('name', 'role'));
        return response()->json($user, 201);
    }
}
