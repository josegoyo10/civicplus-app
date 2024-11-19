<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function() {
    return view('dashboard');
});
Route::middleware(['bearer.token'])->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('event.index'); 
    Route::get('/event/create', [EventController::class, 'create'])->name('event.create'); 
    Route::post('/event/store', [EventController::class, 'store'])->name('event.store'); 
    Route::get('/event/{id}', [EventController::class, 'show'])->name('event.show'); 
});