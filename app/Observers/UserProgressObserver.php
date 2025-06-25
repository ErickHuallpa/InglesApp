<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserProgress;

class UserProgressObserver
{
    public function created(UserProgress $userProgress)
    {
        $this->checkUserLevel($userProgress->user);
    }

    public function updated(UserProgress $userProgress)
    {
        $this->checkUserLevel($userProgress->user);
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