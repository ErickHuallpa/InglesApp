<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'level',
        'content',
        'order',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }

    public function usersCompleted()
    {
        return $this->belongsToMany(User::class, 'user_progress')
                    ->withPivot('completed_at')
                    ->withTimestamps();
    }
    public function badges()
    {
        return $this->hasMany(Badge::class);
    }

}
