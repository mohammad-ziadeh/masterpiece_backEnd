<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Tasks;
use App\Models\Attendance;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentStatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $time = now()->format('H:i:s');
        $user = Attendance::where('user_id', auth()->id());

        // ------ {{ Attendance }} ----- //
        $userAbsent = (clone $user)->where('status', 'absent')->count();
        $userJustifyAbsent = (clone $user)->where('status', 'excused')->count();
        $userLate = (clone $user)->where('status', 'late')->count();
        // ------ {{ End Attendance }} ----- //


 $now = Carbon::now();

        //-- Undone tasks --//
        $userId = Auth::id();

        $submittedTaskIds = Submission::where('submitted_by', $userId)->pluck('task_id');

        $undoneTasks = Tasks::whereHas('students', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->whereNotIn('id', $submittedTaskIds)
            ->latest()
            ->take(7)
            ->get();


        return view('home.studentDashboard', compact('userAbsent', 'userLate', 'userJustifyAbsent', 'time',  'undoneTasks', 'now'));
    }
}
