<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'date', 'status', 'submitted_at', 'submitted_by', 'locked'];
    protected $casts = [
        'submitted_at' => 'datetime', // Ensure that Laravel casts this to Carbon
    ];
    protected $dates = ['date', 'submitted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }


    // ########## {{Auto save every day}} ########## //
    // public static function autoSaveForAllUsers()
    // {
    //     $users = User::all();

    //     foreach ($users as $user) {
    //         $attendance = self::firstOrNew([
    //             'user_id' => $user->id,
    //             'date' => today(),
    //         ]);

    //         $attendance->status = 'present';
    //         $attendance->submitted_by = null;
    //         $attendance->submitted_at = now();
    //         $attendance->tardiness_minutes = null;
    //         $attendance->description = null;
    //         $attendance->save();

    //     }
    // }
}
