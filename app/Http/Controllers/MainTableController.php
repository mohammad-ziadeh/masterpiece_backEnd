<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tasks;
use App\Models\Attendance;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date = today();
        $todayQuery = Attendance::whereDate('date', $date);
        // {{{ Statistics }}} //
        $students = User::where('role', 'student')->count();
        $admins = User::where('role', 'admin')->count();
        $topUsers = User::orderBy('weekly_points', 'desc')->where('role', 'student')->take(1)->first(['name']);
        $finishedTasks = Tasks::whereDate('due_date', '<=', now())->count();
        $trainers = User::where('role', 'trainer')->count();
        $totalAbsent = (clone $todayQuery)->where('status', 'absent')->count();
        $totalLate = (clone $todayQuery)->where('status', 'late')->count();
        // {{{ End Statistics }}} //




        $task = Tasks::withCount(['students'])
            ->orderBy('id', 'desc')
            ->take(1)
            ->first();

        $submissionCounts = Submission::select('task_id')
            ->selectRaw('COUNT(DISTINCT submitted_by) as completed_count')
            ->groupBy('task_id')
            ->get()
            ->keyBy('task_id');

        if ($task) {
            $task->completed_by_students = $submissionCounts[$task->id]->completed_count ?? 0;

            $completedCount = $task->completed_by_students;
            $totalStudents = $task->students_count;

            if ($totalStudents > 0) {
                $task->completion_percentage = ($completedCount / $totalStudents) * 100;
            } else {
                $task->completion_percentage = 0;
            }
        } else {
            $task = null;
        }

        return view('admin.tables.main', compact('task', 'students', 'trainers', 'admins', 'totalAbsent', 'totalLate', 'date', 'finishedTasks', "topUsers"));
    }
}
