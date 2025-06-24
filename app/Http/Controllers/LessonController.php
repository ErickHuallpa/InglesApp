<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index()
    {
        $levels = ['basic', 'intermediate', 'advanced'];
        $groupedLessons = [];

        foreach ($levels as $level) {
            $groupedLessons[$level] = Lesson::where('level', $level)
                ->orderBy('order')
                ->get();
        }

        $completedLessonIds = \App\Models\UserProgress::where('user_id', auth()->id())
            ->pluck('lesson_id')
            ->toArray();

        return view('lessons.index', compact('groupedLessons', 'completedLessonIds'));
    }



    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'required|string',
            'content' => 'nullable|array',
            'order' => 'nullable|integer',
        ]);
        if (isset($data['content'])) {
            $data['content'] = json_encode($data['content']);
        }
        Lesson::updateOrCreate(
            ['id' => $request->id],
            $data
        );

        return redirect()->route('lessons.index')->with('success', 'Lesson guardada correctamente.');
    }

    public function exercises(Lesson $lesson)
    {
        $exercises = $lesson->exercises()->select('id', 'question', 'type')->get();

        return view('lessons.exercises', compact('lesson', 'exercises'));
    }
    public function solve(Lesson $lesson)
    {
        $exercises = $lesson->exercises()->get();

        return view('lessons.solve', compact('lesson', 'exercises'));
    }

    public function submit(Request $request, Lesson $lesson)
    {
        $exercises = $lesson->exercises()->get();

        $score = 0;
        $total = $exercises->count();
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'nullable|string',
        ]);

        $answers = $validated['answers'];

        foreach ($exercises as $exercise) {
            $correctAnswers = json_decode($exercise->correct_answer, true);

            $userAnswer = $answers[$exercise->id] ?? null;
            if ($exercise->type === 'multiple_choice') {
                $userAnswersArr = is_string($userAnswer) ? explode(',', $userAnswer) : [];
                $userAnswersArr = array_map('trim', $userAnswersArr);
                sort($userAnswersArr);
                sort($correctAnswers);

                if ($userAnswersArr === $correctAnswers) {
                    $score++;
                }
            }
            elseif ($exercise->type === 'short_answer') {
                if ($userAnswer) {
                    foreach ($correctAnswers as $correct) {
                        if (strcasecmp(trim($userAnswer), trim($correct)) === 0) {
                            $score++;
                            break;
                        }
                    }
                }
            }
        }
        \App\Models\UserProgress::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'lesson_id' => $lesson->id,
            ],
            [
                'completed_at' => now(),
            ]
        );
        return redirect()->route('lessons.index')
            ->with('success', "Lección completada con puntuación: $score / $total");
    }


}
