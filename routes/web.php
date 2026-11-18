<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/students');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::resource('students', StudentController::class);

Route::middleware('auth')->group(function () {
    Route::post('/students/{student}/results', [ResultController::class, 'store'])->name('results.store');
    Route::delete('/results/{result}', [ResultController::class, 'destroy'])->name('results.destroy');
});
