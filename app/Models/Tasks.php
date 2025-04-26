<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tasks extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'name',
        'pdf_path',
        'assigned_to',
        'submitted_by',
        'description',
        'due_date',
    ];

    use SoftDeletes; 



    public function students()
    {
        return $this->belongsToMany(User::class, 'task_student', 'task_id', 'user_id');
    }
    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }
}
