<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Badge;
use App\Models\BadgeAward;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BadgeController extends Controller
{
    /**
     * Show form to assign badge to student.
     */
    public function assignForm()
    {
        $students = User::where('role', 'student')->orderByDesc('weekly_points')->get();
        $badges = Badge::all();
        return view('admin.tables.badges.assign', compact('students', 'badges'));
    }

    /**
     * Handle assigning badge to student.
     */
    public function assign(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'badge_id' => 'required|exists:badges,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $badge = Badge::findOrFail($request->badge_id);

        if ($user->role === 'student') {
            BadgeAward::create([
                'user_id' => $user->id,
                'badge_id' => $badge->id,
            ]);

            return back()->with('success', 'Badge assigned successfully.');
        }

        return back()->with('error', 'Only students can be assigned badges.');
    }

    /**
     * Show form to create a new badge.
     */
    public function create()
    {
        $badges = Badge::all();
        return view('admin.tables.badges.createBadge', compact('badges'));
    }

    /**
     * Store a newly created badge in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', 
        ]);

        $path = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('badges', 'public');
        }

        Badge::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_url' => $path,
        ]);

        return redirect()->route('badges.create')->with('success', 'Badge created successfully.');
    }

    public function destroy(Badge $badge)
    {
        if ($badge->image) {
            Storage::disk('public')->delete($badge->image);
        }

        $badge->delete();

        return back()->with('success', 'Badge deleted successfully.');
    }

    public function viewUserBadges(User $user)
    {
        $awards = $user->badgeAwards()->with('badge')->latest()->get();

        return view('admin.tables.badges.userBadges', compact('user', 'awards'));
    }
}
