<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    use HasFactory;

    protected $table = 'vocabulary';

    protected $fillable = [
        'user_id',
        'word',
        'translate',
        'example',
        'pronunciation',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
