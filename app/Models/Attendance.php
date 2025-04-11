<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
