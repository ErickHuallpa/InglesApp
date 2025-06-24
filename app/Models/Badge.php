<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'icon_url',
        'criteria_json',
        'level',
        'lesson_id',
    ];

    protected $casts = [
        'criteria_json' => 'array',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_badges')
                    ->withPivot('achieved_at')
                    ->withTimestamps();
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
