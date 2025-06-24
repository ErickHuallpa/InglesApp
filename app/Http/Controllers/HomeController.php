<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\UserProgress;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $lessons = Lesson::orderBy('level')->orderBy('order')->get();

        $lessonsByLevel = $lessons->groupBy(function ($lesson) {
            return ucfirst(strtolower($lesson->level));
        });

        $popularLessons = Lesson::select('lessons.*', DB::raw('COUNT(user_progress.lesson_id) as completions'))
            ->join('user_progress', 'lessons.id', '=', 'user_progress.lesson_id')
            ->groupBy('lessons.id')
            ->orderByDesc('completions')
            ->limit(5)
            ->get();

        return view('home.index', compact('lessonsByLevel', 'popularLessons'));
    }
}

