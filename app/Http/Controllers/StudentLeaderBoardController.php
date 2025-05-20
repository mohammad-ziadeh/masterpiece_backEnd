<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Badge;
use App\Models\LeaderBoard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentLeaderBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $query = User::query();

        $topUsers = $query->orderBy('weekly_points', 'desc')->where('role', 'student')->take(5)->get();


        $badges = Badge::all();
        return view('home.leaderboard.leaderBoard', compact('topUsers','badges'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function full()
{
    $users = User::orderBy('weekly_points', 'desc')->where('role', 'student')->get();

    return view('home.leaderboard.allUsersLead', compact('users'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function lastWeek()
    {
        $users = User::orderBy('last_week_points', 'desc')->where('role', 'student')->get();
    
        return view('home.leaderboard.lastWeekLead', compact('users'));
    }
    /**
     * Display the specified resource.
     */
    public function showBadges(User $user)
{  
    
    $badges = $user->badges;
    $awards = $user->badgeAwards()->with('badge')->latest()->get();

    return view('home.leaderboard.userBadges', compact('user', 'badges','awards'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaderBoard $leaderBoard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeaderBoard $leaderBoard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeaderBoard $leaderBoard)
    {
        //
    }
}
