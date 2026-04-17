<?php

Route::middleware('auth')->group(function () {
    Route::get('/', fn() => 'Bienvenue sur l’espace prof')
        ->middleware('role:prof')
        ->name('prof.dashboard');
});