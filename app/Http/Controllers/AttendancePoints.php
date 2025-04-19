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
        // Find the user by their ID
        $user = User::find($userId);
    
        if (!$user) {
            // If user doesn't exist, return a 404 or appropriate message
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
    
        // Pass the user points to the view
        return view('tables.points', ['user' => $user]);
    }
}
