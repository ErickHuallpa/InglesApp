<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\LessonResolveController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\VocabularyController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\CheckRole;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home.index');
    } else {
        return redirect()->route('login');
    }
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('lessons', LessonController::class)->only(['index', 'store']);
    Route::get('badges', [BadgeController::class, 'index'])->name('badges.index');
    Route::get('lessons/{lesson}/exercises', [LessonController::class, 'exercises'])->name('lessons.exercises');
    Route::get('/lessons/{lesson}/resolve', [LessonResolveController::class, 'showForm'])->name('lessons.resolve');
    Route::post('/lessons/{lesson}/resolve', [LessonResolveController::class, 'submit'])->name('lessons.resolve.submit');
    Route::get('/vocabulary', [VocabularyController::class, 'index'])->name('vocabulary.index');
    Route::get('/vocabulary', [VocabularyController::class, 'index'])->name('vocabulary.index');
    Route::post('/vocabulary', [VocabularyController::class, 'store'])->name('vocabulary.store');
    Route::get('/home/index', [HomeController::class, 'index'])->middleware('auth')->name('home.index');

    Route::middleware([CheckRole::class])->group(function () {
        Route::post('badges', [BadgeController::class, 'store'])->name('badges.store');
        Route::put('badges/{badge}', [BadgeController::class, 'update'])->name('badges.update');
        Route::delete('badges/{badge}', [BadgeController::class, 'destroy'])->name('badges.destroy');
        Route::get('lessons/create', [LessonController::class, 'create'])->name('lessons.create');
        Route::get('lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
        Route::delete('lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');
    });
});
