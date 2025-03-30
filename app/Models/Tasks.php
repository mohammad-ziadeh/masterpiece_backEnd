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
        'image_path',
        'link',
        'description',
        'due_date',
    ];

    use SoftDeletes; 
}
