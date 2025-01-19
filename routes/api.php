<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PetController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Support\Facades\Route;

Route::get('pet/findByStatus', [PetController::class, 'findByStatus']);
Route::apiResource('pet', PetController::class);

Route::apiResource('category', CategoryController::class);
Route::apiResource('tag', TagController::class);
