<?php

use App\Http\Controllers\PlagiarismController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:prof'])->group(function () {
    Route::post('/compare', [PlagiarismController::class, 'checkPlagiarism'])->name('plagiarism.compare');
});
