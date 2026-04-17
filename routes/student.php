<?php

Route::middleware('auth')->group(function () {
    Route::get('dashboard', fn() => 'Bienvenue sur l’espace student')
        ->middleware('role:student')
        ->name('student.dashboard');
});