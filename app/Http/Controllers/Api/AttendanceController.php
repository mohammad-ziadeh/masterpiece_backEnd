<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AttendanceController extends Controller
{
    /**
     * Fetch attendance data for the API.
     */
    public function index(Request $request): JsonResponse
    {
        $users = User::where('role', 'student')->get();

        $date = today();
        $pastDate = today()->subDay();

        $todayQuery = Attendance::whereDate('date', $date);
        $yesterdayQuery = Attendance::whereDate('date', $pastDate);

        $attendances = $todayQuery->get()->keyBy('user_id')->map(fn($a) => $a->only(['status', 'description', 'tardiness_minutes']));
        $yesterdayAttendances = $yesterdayQuery->get()->keyBy('user_id')->map(fn($a) => $a->only(['status', 'description', 'tardiness_minutes']));

        $totalAbsent = $todayQuery->where('status', 'absent')->count();
        $totalLate = $todayQuery->where('status', 'late')->count();

        return response()->json([
            'users' => $users,
            'date' => $date->toDateString(),
            'past_date' => $pastDate->toDateString(),
            'attendances' => $attendances,
            'yesterday_attendances' => $yesterdayAttendances,
            'total_absent' => $totalAbsent,
            'total_late' => $totalLate,
        ]);
    }

    /**
     * Store attendance data via API without validation.
     */
    public function store(Request $request): JsonResponse
    {
        $attendanceData = $request->input('attendances', []);
        $descriptions = $request->input('description', []);
        $tardiness = $request->input('tardiness', []);

        foreach ($attendanceData as $userId => $status) {
            $attendance = Attendance::firstOrNew([
                'user_id' => $userId,
                'date' => today(),
            ]);

            $attendance->status = $status;
            $attendance->submitted_by = auth()->id();
            $attendance->submitted_at = now();

            // if ($status === 'late') {
            //     $attendance->tardiness_minutes = $tardiness[$userId] ?? null;
            // } else {
            //     $attendance->tardiness_minutes = null;
            // }

            // $user = User::find($userId);

            // if ($status === 'absent' && $user) {
            //     $exists = Attendance::where('user_id', $userId)
            //         ->whereDate('date', today())
            //         ->where('status', 'absent')
            //         ->exists();

            //     if (!$exists) {
            //         $user->weekly_points = max(0, $user->weekly_points - 100);
            //         $user->save();
            //     }
            // } elseif ($status === 'present' && $user) {
            //     $exists = Attendance::where('user_id', $userId)
            //         ->whereDate('date', today())
            //         ->where('status', 'present')
            //         ->exists();

            //     if (!$exists) {
            //         $user->weekly_points += 100;
            //         $user->save();
            //     }
            // } elseif ($status === 'late' && $user) {
            //     $tardinessMinutes = $attendance->tardiness_minutes ?? 0;
            //     $pointsDeduction = $tardinessMinutes * 5;
            //     if ($pointsDeduction > 0) {
            //         $user->weekly_points = max(0, $user->weekly_points - $pointsDeduction);
            //         $user->save();
            //     }
            // }

            // if (!empty($descriptions[$userId])) {
            //     $attendance->description = $descriptions[$userId];
            // }

            

            $attendance->save();
        }

        return response()->json(['message' => 'Attendance saved successfully']);
    }
}
