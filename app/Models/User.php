<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'level',
        'role_id',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function lessonsCompleted()
    {
        return $this->belongsToMany(Lesson::class, 'user_progress')
                    ->withPivot('completed_at')
                    ->withTimestamps();
    }
    public function results()
    {
        return $this->hasMany(UserResult::class);
    }
    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
                    ->withPivot('achieved_at')
                    ->withTimestamps();
    }
}
