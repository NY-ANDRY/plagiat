<?php

use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/{submission}/read', [SubmissionController::class, 'read'])->name('submission.read');
    Route::get('/{submission}/download', [SubmissionController::class, 'download'])->name('submission.download');
});
