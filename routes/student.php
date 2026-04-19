<?php

use App\Http\Controllers\Student\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/', fn () => redirect()->route('student.dashboard'));
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/exams', fn () => redirect()->route('student.dashboard'))->name('student.exams');
    Route::get('/exams/{id}', [StudentController::class, 'exam'])->name('student.exam');

    Route::post('/submission/exam/{id}', [StudentController::class, 'submission'])->name('exam.submission');
    Route::delete('/submission/exam/{id}', [StudentController::class, 'removeSubmission'])->name('exam.submission.delete');

    Route::get('/profile', [StudentController::class, 'profile'])->name('student.profile');
});
