<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LeaderBoard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaderBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $query = User::query();

        $topUsers = $query->orderBy('weekly_points', 'desc')->take(5)->get();


        return view('tables.leaderBoard', compact('topUsers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LeaderBoard $leaderBoard)
    {
        //
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
