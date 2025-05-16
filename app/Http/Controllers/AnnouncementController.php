<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AnnouncementPublished;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('users')->orderByDesc('id')->get();
        $students = User::where('role', 'student')->get();

        return view('admin.announcement', compact('announcements', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string|max:15000',
            'user_ids' => 'array|exists:users,id',
        ]);

        $announcement = Announcement::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'created_by' => Auth::id(),
        ]);
        $announcement->users()->sync($request->user_ids);

        if (!empty($request->user_ids)) {
            $students = User::whereIn('id', $request->user_ids)->get();

            foreach ($students as $student) {
                $student->notify(new AnnouncementPublished($announcement));
            }
        }

        return redirect()->route('announcements.index')->with('success', 'Announcement created and the emails has been sent.');
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string|max:15000',
            'user_ids' => 'array|exists:users,id',
        ]);

        $announcement->update($request->only('title', 'body'));
        $announcement->users()->sync($request->user_ids);

        return back()->with('success', 'Announcement updated.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return back()->with('success', 'Announcement deleted.');
    }
}
