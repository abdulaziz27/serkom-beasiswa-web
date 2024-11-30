<?php

use App\Http\Controllers\ScholarshipController;
use Illuminate\Support\Facades\Route;
/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', [ScholarshipController::class, 'index'])->name('scholarship.index');
Route::get('/daftar', [ScholarshipController::class, 'create'])->name('scholarship.create');
Route::post('/daftar', [ScholarshipController::class, 'store'])->name('scholarship.store');
Route::get('/hasil', [ScholarshipController::class, 'results'])->name('scholarship.results');
