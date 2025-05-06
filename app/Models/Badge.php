<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;


    protected $fillable = ['title', 'description', 'image_url'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function badgeAwards()
{
    return $this->hasMany(BadgeAward::class);
}
}
