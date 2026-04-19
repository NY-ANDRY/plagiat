<?php

use App\Http\Controllers\Prof\ProfController;

Route::middleware(['auth', 'role:prof'])->group(function () {
    Route::get('/', fn () => redirect()->route('prof.dashboard'));
    Route::get('/dashboard', [ProfController::class, 'dashboard'])->name('prof.dashboard');
    Route::get('/exams', [ProfController::class, 'exams'])->name('prof.exams');
    Route::get('/exams/{id}', [ProfController::class, 'exam'])->name('prof.exam');
    Route::get('/students', [ProfController::class, 'student'])->name('prof.student');
});
