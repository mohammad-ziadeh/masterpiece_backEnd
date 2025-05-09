<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tasks;
use App\Models\Attendance;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentStatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Attendance::where('user_id', auth()->id());

        // ------ {{ Attendance }} ----- //
        $userAbsent = (clone $user)->where('status', 'absent')->count();
        $userJustifyAbsent = (clone $user)->where('status', 'excused')->count();
        $userLate = (clone $user)->where('status', 'late')->count();
        // ------ {{ End Attendance }} ----- //




        return view('home.studentDashboard', compact('userAbsent', 'userLate', 'userJustifyAbsent'));
    }

}
