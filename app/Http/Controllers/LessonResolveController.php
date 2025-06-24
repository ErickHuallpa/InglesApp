<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonResolveController extends Controller
{
    public function showForm(Lesson $lesson)
    {
        $exercises = $lesson->exercises;

        return view('lessons.resolve', compact('lesson', 'exercises'));
    }

    public function submit(Request $request, Lesson $lesson)
    {
        $exercises = $lesson->exercises;
        $score = 0;

        foreach ($exercises as $exercise) {
            $userAnswer = $request->input("exercise_{$exercise->id}");
            $correctAnswers = $exercise->correct_answer;

            if ($exercise->type === 'multiple_choice') {
                $correct = $correctAnswers;
                $userAns = $userAnswer ?? [];

                sort($correct);
                sort($userAns);

                if ($correct === $userAns) {
                    $score++;
                }
            } else {
                if (in_array(trim($userAnswer), $correctAnswers)) {
                    $score++;
                }
            }
        }

        $user = Auth::user();
        $total = $exercises->count();
        $message = "Puntuación: $score / $total.";


        if ($score === $total) {
            UserProgress::updateOrCreate(
                ['user_id' => $user->id, 'lesson_id' => $lesson->id],
                ['completed_at' => now()]
            );
            foreach ($lesson->badges as $badge) {
                $alreadyHas = $user->badges()->where('badge_id', $badge->id)->exists();
                if (! $alreadyHas) {
                    $user->badges()->attach($badge->id, ['achieved_at' => now()]);
                }
            }

            $message = "¡Lección completada! Obtuviste todos los puntos ($score / $total).";
            return redirect()->route('lessons.index')->with([
                'success' => $message,
                'success_type' => 'full'
            ]);
        }
        return redirect()->route('lessons.index')->with([
            'success' => "Puntuación obtenida: $score / $total. Debes responder todo correctamente.",
            'success_type' => 'partial'
        ]);

    }



}
