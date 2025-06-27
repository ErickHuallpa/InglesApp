<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\User;
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
                if (in_array(trim(strtolower($userAnswer)), array_map('strtolower', $correctAnswers))) {
                    $score++;
                }
            }
        }

        $user = Auth::user();
        $total = $exercises->count();

        $message = "Respondiste $score de $total correctamente.";
        $earnedBadge = false;

        if ($score === $total) {
            UserProgress::updateOrCreate(
                ['user_id' => $user->id, 'lesson_id' => $lesson->id],
                ['completed_at' => now()]
            );

            $this->checkUserLevel($user);

            foreach ($lesson->badges as $badge) {
                $alreadyHas = $user->badges()->where('badge_id', $badge->id)->exists();
                if (!$alreadyHas) {
                    $user->badges()->attach($badge->id, ['achieved_at' => now()]);
                    $earnedBadge = true;
                }
            }

            $message = "🎉 ¡Lección completada! Obtuviste la insignia. Puntaje: $score / $total";
        } else {
            $message = "🔔 Resolviste $score/$total correctas. No alcanzaste para obtener la insignia.";
        }

        return response()->json([
            'score' => $score,
            'total' => $total,
            'badge' => $earnedBadge,
            'message' => $message,
        ]);
    }

    
    protected function checkUserLevel(User $user)
    {
        $basicCount = $user->lessonsCompleted()
            ->where('level', 'basic')
            ->count();

        $intermediateCount = $user->lessonsCompleted()
            ->where('level', 'intermediate')
            ->count();

        $newLevel = $user->level;

        if ($basicCount >= 5 && $user->level !== 'intermediate') {
            $newLevel = 'intermediate';
        } elseif ($intermediateCount >= 5 && $user->level !== 'advanced') {
            $newLevel = 'advanced';
        }

        if ($newLevel !== $user->level) {
            $user->update(['level' => $newLevel]);
        }
    }
}
