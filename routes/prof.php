<?php

use App\Http\Controllers\Prof\ProfController;

Route::middleware(['auth', 'role:prof'])->group(function () {
    Route::get('/', fn () => redirect()->route('prof.dashboard'));
    Route::get('/dashboard', [ProfController::class, 'dashboard'])->name('prof.dashboard');
    Route::get('/exam', [ProfController::class, 'exam'])->name('prof.exam');
});
