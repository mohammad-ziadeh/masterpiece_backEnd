<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Models\Tasks;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'deleted_at',
        'gender',
        'phone',
        'city'
    ];

    use SoftDeletes;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tasks()
    {
        return $this->belongsToMany(Tasks::class, 'task_student', 'user_id', 'task_id');
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class)->withTimestamps();
    }

    public function badgeAwards()
    {
        return $this->hasMany(BadgeAward::class);
    }

public function announcements()
{
    return $this->belongsToMany(Announcement::class);
}


    public function hasRole(string $role)
    {
        return strtolower($this->role) === strtolower($role);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isTrainer()
    {
        return $this->role === 'trainer';
    }


    public function isTrainerOrAdmin()
    {
        return $this->isTrainer() || $this->isAdmin();
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // public function submissions()
    // {
    //     return $this->hasMany(Submission::class);
    // }
}
