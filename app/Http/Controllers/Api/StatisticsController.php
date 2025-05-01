<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatisticsController extends Controller
{
    public function statistic(Request $request)
    {
        

      //  $query = User::query();
        $date = today();
        $todayQuery = Attendance::whereDate('date', $date);


        $totalAbsent = (clone $todayQuery)->where('status', 'absent')->count();
        $totalLate = (clone $todayQuery)->where('status', 'late')->count();


        return response()->json([
            'totalAbsent' => $totalAbsent,
            'totalLate' => $totalLate,
        ]);

    }
}
