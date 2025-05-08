<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tasks;
use App\Models\Attendance;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {}

    public function taskProgress()
    {
        $date = today();
        $todayQuery = Attendance::whereDate('date', $date);
        // {{{ Statistics }}} //
        $students = User::where('role', 'student')->count();
        $admins = User::where('role', 'admin')->count();
        $trainers = User::where('role', 'trainer')->count();
        $totalAbsent = (clone $todayQuery)->where('status', 'absent')->count();
        $totalLate = (clone $todayQuery)->where('status', 'late')->count();
        // {{{ End Statistics }}} //


        $tasks = Tasks::withCount(['students'])
            ->orderBy('id', 'desc')
            ->paginate(10);
        $submissionCounts = Submission::select('task_id')
            ->selectRaw('COUNT(DISTINCT submitted_by) as completed_count')
            ->groupBy('task_id')
            ->get()
            ->keyBy('task_id');

        foreach ($tasks as $task) {
            $task->completed_by_students = $submissionCounts[$task->id]->completed_count ?? 0;
        }

        return view('dashboard', compact('tasks', 'students', 'trainers', 'admins', 'totalAbsent', 'totalLate', 'date'));
    }
}
