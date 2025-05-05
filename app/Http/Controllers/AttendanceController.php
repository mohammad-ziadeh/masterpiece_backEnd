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



        $query = User::query();

        if ($request->has('name') && !empty($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('role') && $request->role != 'all') {
            $query->where('role', $request->role);
        }
        $time = now();

        $startTime = $time->copy()->setTime(0, 05);
        $endTime = $time->copy()->setTime(0, 30);


        if ($time->between($startTime, $endTime)) {
            $users = $query->get();
        } else {
            $users = $query->whereIn('role', ['student', 'trainer'])
                ->orderBy('role')
                ->paginate(10);
            $students = User::where('role', 'student')->paginate(10);
        }

        $saveStartTime = $time->copy()->setTime(0, 10);

        if ($time->between($saveStartTime, $endTime)) {
            $this->autoSaveAttendance();
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



        return view('admin.tables.attendance.attendance', compact('users', 'attendances', 'date', 'totalAbsent', 'totalLate', 'yesterdayAttendances', 'pastDate', 'students'));
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



            $attendance->status = $status;
            $attendance->submitted_by = auth()->id();
            $attendance->submitted_at = now();

            if ($status === 'late') {
                $attendance->tardiness_minutes = $request->tardiness[$userId] ?? 0;
            } else {
                $attendance->tardiness_minutes = null;
            }

            $user = User::find($userId);

            // ############# {{ Points Depending on attendance status }} ############# //

            if ($status === 'absent' && $user) {
                $existingAttendance = Attendance::where('user_id', $userId)
                    ->whereDate('date', today())
                    ->where('status', 'absent')
                    ->first();

                if (!$existingAttendance) {
                    $user->decrement('weekly_points', 100);
                    $user->save();
                }
            } elseif ($status === 'present' && $user) {
                $existingAttendance = Attendance::where('user_id', $userId)
                    ->whereDate('date', today())
                    ->where('status', 'present')
                    ->first();

                if (!$existingAttendance) {
                    $user->increment('weekly_points', 100);
                    $user->save();
                }
            } elseif ($status === 'late' && $user) {
                $tardiness = $attendance->tardiness_minutes;
                $thePoints = $tardiness * 5;

                if ($thePoints > 0) {
                    $user->weekly_points -= $thePoints;
                    $user->weekly_points = max(0, $user->weekly_points);
                    $user->save();
                }
            }





            // ############# {{ End Points Depending on attendance status }} ############# //


            if (isset($request->description[$userId])) {
                $attendance->description = $request->description[$userId];
            }

            $attendance->save();
        }

        return redirect()->back()->with('success', 'Attendance saved!');
    }







    // ###### {{locking the ability to change the status of attendance}} ###### //
    // public function lockToday()
    // {
    //     Attendance::whereDate('date', today())->update(['locked' => true]);

    //     return redirect()->back()->with('success', 'Today\'s attendance locked!');
    // }
    // ###### {{ end locking the ability to change the status of attendance}} ###### //







    // ###### {{unlocking the ability to change the status of attendance}} ###### //
    // public function unlockToday()
    // {
    //     Attendance::whereDate('date', today())->update(['locked' => false]);

    //     return redirect()->back()->with('success', 'Today\'s attendance has been unlocked.');
    // }
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

        return view('admin.tables.attendance.attendancehistory', compact('user', 'attendanceHistory'));
    }
    // ###### {{ end showing the attendance history of a user}} ###### //


    public function autoSaveAttendance()
    {
        $users = User::all();

        foreach ($users as $user) {
            $attendance = Attendance::where('user_id', $user->id)
                ->whereDate('date', today())
                ->first();

            if ($attendance && $attendance->submitted_at) {
                continue;
            }

            $attendance = Attendance::firstOrNew([
                'user_id' => $user->id,
                'date' => today(),
            ]);



            $attendance->status = 'present';
            $attendance->submitted_by = auth()->id();
            $attendance->submitted_at = now();
            $attendance->description = null;



            $attendance->save();
        }

        return redirect()->back()->with('success', 'Attendance has been auto-saved at 12:05 AM.');
    }
}
