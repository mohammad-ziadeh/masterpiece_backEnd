<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceHistoryController extends Controller
{
    public function index(Request $request)
    {

        $viewType = $request->query('view');
        $query = User::query();

        if ($request->has('name') && !empty($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('role') && $request->role != 'all') {
            $query->where('role', $request->role);
        }


        if ( $viewType === 'all') {
            $users = $query->get();
        } else {
            $users = $query->paginate(10);
        }



      //  $date = today();
        $pastDate = today()->subDay();

      //  $todayQuery = Attendance::whereDate('date', $date);
        $yesterdayQuery = Attendance::whereDate('date', $pastDate);

       // $attendances = $todayQuery->get()->keyBy('user_id');
        $yesterdayAttendances = $yesterdayQuery->get()->keyBy('user_id');




        // ########## {{ filters }} ########## //

      //  $totalAbsent = (clone $todayQuery)->where('status', 'absent')->count();
      //  $totalLate = (clone $todayQuery)->where('status', 'late')->count();



        return view('tables.attendance.allAtendanceHistroy', compact('users',   'yesterdayAttendances', 'pastDate'));
    }

    public function store(Request $request)
    {


        $request->validate([
            'description.*' => 'nullable|string|max:255',
        ]);


        foreach ($request->yesterdayAttendances as $userId => $status) {
            $attendance = Attendance::firstOrNew([
                'user_id' => $userId,
                'date' => today()->subDay(),
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
}
