<?php

use App\Http\Controllers\Prof\ProfController;

Route::middleware(['auth', 'role:prof'])->group(function () {
    Route::get('/', fn() => redirect()->route('prof.dashboard'));
    Route::get('/dashboard', [ProfController::class, 'dashboard'])->name('prof.dashboard');

    Route::get('/exams', [ProfController::class, 'exams'])->name('prof.exams.list');
    Route::post('/exams', [ProfController::class, 'storeExam'])->name('prof.exams.store');

    Route::get('/exams/{id}', [ProfController::class, 'exam'])->name('prof.exams.show');
    Route::get('/exams/{id}/compare', [ProfController::class, 'checkPlagiarism'])->name('prof.exams.compare');

    Route::get('/students', [ProfController::class, 'student'])->name('prof.student');
});
