<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendancePoints extends Controller
{
    public function showUserPoints($userId)
    {
        $user = User::find($userId);
    
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
    
        return view('admin.tables.points', ['user' => $user]);
    }
}
