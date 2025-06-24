<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserResult extends Model
{
    use HasFactory;

    protected $table = 'user_results';

    protected $fillable = [
        'user_id',
        'exercise_id',
        'user_answer',
        'is_correct',
        'score',
        'answered_at',
    ];

    protected $casts = [
        'user_answer' => 'array',
        'is_correct' => 'boolean',
        'answered_at' => 'datetime',
        'score' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
