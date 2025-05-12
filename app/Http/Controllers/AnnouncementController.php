<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    // Display the form and all announcements
    public function index()
    {
        $announcements = Announcement::with('users')->get();  // Retrieve all announcements with their assigned users
        $students = User::where('role', 'student')->get();    // Get all students to assign

        return view('admin.announcement', compact('announcements', 'students'));
    }

    // Create a new announcement (handle in the same page)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'user_ids' => 'array|exists:users,id',
        ]);

        $announcement = Announcement::create($request->only('title', 'body'));
        $announcement->users()->sync($request->user_ids);

        return redirect()->route('announcements.index')->with('success', 'Announcement created.');
    }

    // Update an announcement
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'user_ids' => 'array|exists:users,id',
        ]);

        $announcement->update($request->only('title', 'body'));
        $announcement->users()->sync($request->user_ids);

        return back()->with('success', 'Announcement updated.');
    }

    // Delete an announcement
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return back()->with('success', 'Announcement deleted.');
    }
}
