<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submission extends Model
{
    use HasFactory;



    protected $fillable = [
        'task_id',
        'submitted_by',
        'approved_by',
        'answer',
        'pdf_path',
        'grade',
        'feedback'
    ];




    public function task()
    {
        return $this->belongsTo(Tasks::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
