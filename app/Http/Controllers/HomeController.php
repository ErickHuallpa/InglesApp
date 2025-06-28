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
        $user = auth()->user();
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
        $completedLessonIds = $user 
            ? UserProgress::where('user_id', $user->id)
                ->whereNotNull('completed_at')
                ->pluck('lesson_id')
                ->toArray()
            : [];
        return view('home.index', compact('lessonsByLevel', 'popularLessons', 'completedLessonIds'));
    }

}

