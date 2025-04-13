<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $time = now();

        $startTime = now()->setTime(23, 55);
        $endTime = now()->addDay()->setTime(0, 15);


        if ($time->between($startTime, $endTime)) {
            $users = User::all();
        } else {
            $users = User::paginate(10);
        }

        $date = today();
        $pastDate = today()->subDay();

        $todayQuery = Attendance::whereDate('date', $date);
        $yesterdayQuery = Attendance::whereDate('date', $pastDate);

        $attendances = $todayQuery->get()->keyBy('user_id');
        $yesterdayAttendances = $yesterdayQuery->get()->keyBy('user_id');




        // ########## {{ filters }} ########## //

        $totalAbsent = (clone $todayQuery)->where('status', 'absent')->count();
        $totalLate = (clone $todayQuery)->where('status', 'late')->count();



        return view('tables.attendance.attendance', compact('users', 'attendances', 'date', 'totalAbsent', 'totalLate', 'yesterdayAttendances', 'pastDate'));
    }

    public function store(Request $request)
    {


        $request->validate([
            'description.*' => 'nullable|string|max:255',
        ]);


        foreach ($request->attendances as $userId => $status) {
            $attendance = Attendance::firstOrNew([
                'user_id' => $userId,
                'date' => today(),
            ]);

            if ($attendance->locked) {
                continue;
            }

            $attendance->status = $status;
            $attendance->submitted_by = auth()->id();
            $attendance->submitted_at = now();

            if ($status === 'late') {
                $attendance->tardiness_minutes = $request->tardiness[$userId] ?? 0;
            } else {
                $attendance->tardiness_minutes = null;
            }

            if (isset($request->description[$userId])) {
                $attendance->description = $request->description[$userId];
            }

            $attendance->save();
        }

        return redirect()->back()->with('success', 'Attendance saved!');
    }

    // ###### {{locking the ability to change the status of attendance}} ###### //
    public function lockToday()
    {
        Attendance::whereDate('date', today())->update(['locked' => true]);

        return redirect()->back()->with('success', 'Today\'s attendance locked!');
    }
    // ###### {{ end locking the ability to change the status of attendance}} ###### //


    // ###### {{unlocking the ability to change the status of attendance}} ###### //
    public function unlockToday()
    {
        Attendance::whereDate('date', today())->update(['locked' => false]);

        return redirect()->back()->with('success', 'Today\'s attendance has been unlocked.');
    }
    // ###### {{ end unlocking the ability to change the status of attendance}} ###### //


    // ###### {{showing the attendance history of a user}} ###### //
    public function showHistory($userId, Request $request)
    {
        $user = User::findOrFail($userId);

        $query = $user->attendances();

        // ########## {{ filters }} ########## //
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('from_date') && $request->from_date) {
            $query->where('date', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date) {
            $query->where('date', '<=', $request->to_date);
        }

        $attendanceHistory = $query->orderBy('date', 'desc')->paginate(10);;
        // ########## {{ end filters }} ########## //

        return view('tables.attendance.attendancehistory', compact('user', 'attendanceHistory'));
    }
    // ###### {{ end showing the attendance history of a user}} ###### //
}
