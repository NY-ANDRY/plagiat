<?php

use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/plagiarism/{pr}', [SubmissionController::class, 'compare'])->name('submission.plagiarism');
    Route::get('/read/{submission}', [SubmissionController::class, 'read'])->name('submission.read');
    Route::get('/download/{submission}', [SubmissionController::class, 'download'])->name('submission.download');
});
