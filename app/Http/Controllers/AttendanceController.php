<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        $date = today();

        $attendances = Attendance::whereDate('date', $date)->get()->keyBy('user_id');

        return view('tables.attendance.attendance', compact('users', 'attendances', 'date'));
    }

    public function store(Request $request)
    {
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
            $attendance->save();
        }

        return redirect()->back()->with('success', 'Attendance saved!');
    }

    public function lockToday()
    {
        Attendance::whereDate('date', today())->update(['locked' => true]);

        return redirect()->back()->with('success', 'Today\'s attendance locked!');
    }
    public function unlockToday()
    {
        Attendance::whereDate('date', today())->update(['locked' => false]);

        return redirect()->back()->with('success', 'Today\'s attendance has been unlocked.');
    }
    public function showHistory($userId, Request $request)
    {
        $user = User::findOrFail($userId);

        $query = $user->attendances();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('from_date') && $request->from_date) {
            $query->where('date', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date) {
            $query->where('date', '<=', $request->to_date);
        }

        $attendanceHistory = $query->orderBy('date', 'desc')->get();

        return view('tables.attendance.attendancehistory', compact('user', 'attendanceHistory'));
    }
}
