<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::whereHas('users', function ($query) {
            $query->where('user_id', Auth::id());
        })->with('users')->orderByDesc('id')->get();
        
        $students = User::where('role', 'student')->get();

        return view('home.studentAnnouncements', compact('announcements', 'students'));
    }
}
