<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        $now = Carbon::now();
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
            ->paginate(5);
        $submissionCounts = Submission::select('task_id')
            ->selectRaw('COUNT(DISTINCT submitted_by) as completed_count')
            ->groupBy('task_id')
            ->get()
            ->keyBy('task_id');

        foreach ($tasks as $task) {
            $task->completed_by_students = $submissionCounts[$task->id]->completed_count ?? 0;
        }


        // {{{ Start Attendance Statistics }}} //
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $rawData = Attendance::whereBetween('date', [$startOfWeek, $endOfWeek])
            ->selectRaw('DATE(date) as date, 
                    SUM(status = "attended") as attended,
                    SUM(status = "late") as late,
                    SUM(status = "absent") as absent')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    \Carbon\Carbon::parse($item->date)->format('D') => [
                        'attended' => (int) $item->attended,
                        'late' => (int) $item->late,
                        'absent' => (int) $item->absent,
                    ]
                ];
            });

        $weekDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat','Sun'];
        $attendanceData = collect($weekDays)->mapWithKeys(function ($day) use ($rawData, $students) {
            $data = $rawData[$day] ?? ['attended' => 0, 'late' => 0, 'absent' => 0];
            $presentSum = $data['attended'] + $data['late'] + $data['absent'];
            $remaining = max($students - $presentSum, 0);

            $data['attended'] += $remaining;

            return [
                $day => $data
            ];
        });
        // {{{ End Attendance Statistics }}} //



        return view('dashboard', compact('tasks', 'students', 'trainers', 'admins', 'totalAbsent', 'totalLate', 'date', 'attendanceData', 'now'));
    }
}
