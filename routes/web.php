<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SalariesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', [JobController::class, 'index'])->name('index');

Route::prefix('/salaries')->name('salaries.')->group(function () {
    Route::get('/', [SalariesController::class, 'index'])->name('index');
});

Route::prefix('/jobs')->name('jobs.')->group(function () {
    Route::get('/', [JobController::class, 'index'])->name('index');
    Route::get('/me', [JobController::class, 'view'])->name('me');
    Route::get('/create', [JobController::class, 'create'])->name('create');
    Route::post('', [JobController::class, 'store'])->name('store');
    Route::get('/{job}/edit', [JobController::class, 'edit'])->name('edit');
    Route::patch('/{job}/update', [JobController::class, 'update'])->name('update');
    Route::delete('/{job}', [JobController::class, 'destroy'])->name('destroy');
});

Route::get('/search', SearchController::class);
Route::get('/tags/{tag:name}', TagController::class);

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [SessionController::class, 'create']);
    Route::post('/login', [SessionController::class, 'store']);
});

Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');
