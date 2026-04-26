<?php

use App\Http\Controllers\Plagiarism\PlagiarismController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:prof'])->group(function () {
    Route::post('/compare', [PlagiarismController::class, 'checkPlagiarism'])->name('plagiarism.compare');
    Route::get('/plagiarism/{pr}', [PlagiarismController::class, 'compare'])->name('plagiarism.view');

    Route::delete('/plagiarism/{plagiarism}', [PlagiarismController::class, 'delete'])->name('plagiarism.delete');
});
