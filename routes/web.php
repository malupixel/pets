<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::any('/edit/{id}', [HomeController::class, 'edit'])->name('edit');
Route::get('/remove/{id}', [HomeController::class, 'remove'])->name('remove');
Route::any('/add', [HomeController::class, 'add'])->name('add');
//Route::post('/add', [HomeController::class, 'add'])->name('addSave');

