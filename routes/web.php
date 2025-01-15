<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchedulerController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('event.home');
});

Route::middleware('web')->group(function() {
    Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('event')->group(function() {
        Route::get('/', [SchedulerController::class, 'home'])->name('event.home');
        Route::middleware('auth')->group(function() {
            Route::post('/submit', [SchedulerController::class, 'submit'])->name('event.submit');
            Route::post('/get-selected', [SchedulerController::class, 'getSelectedData'])->name('event.getSelected');
            Route::post('/update', [SchedulerController::class, 'update'])->name('event.update');
            Route::post('/delete', [SchedulerController::class, 'delete'])->name('event.delete');
        });
        Route::get('/get-json', [SchedulerController::class, 'getJson'])->name('event.get-json');
    });
});