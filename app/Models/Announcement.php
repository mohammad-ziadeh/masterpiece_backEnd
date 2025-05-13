<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'created_by', 'body'];


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
