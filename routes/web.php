<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin', fn () => 'Bienvenue sur l’espace admin')
        ->middleware('role:admin')
        ->name('admin.dashboard');

    Route::get('/submissions/{submission}/read', [SubmissionController::class, 'read'])->name('submission.read');
    Route::get('/submissions/{submission}/download', [SubmissionController::class, 'download'])->name('submission.download');
});

Route::prefix('auth')->group(function () {
    require __DIR__.'/auth.php';
});

Route::prefix('prof')->group(function () {
    require __DIR__.'/prof.php';
});

Route::prefix('student')->group(function () {
    require __DIR__.'/student.php';
});

// /// test

use App\Http\Controllers\ZipController;

Route::get('/zip/tree/{zip}', [ZipController::class, 'tree'])->where('zip', '.+');
Route::get('/zip/file/{zip}', [ZipController::class, 'file'])->where('zip', '.+');
Route::get('/zip/view', [ZipController::class, 'view']);
