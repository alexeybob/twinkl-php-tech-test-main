<?php

use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/users', [UsersController::class, 'index'])->middleware('guest');
Route::post('/user/store', [UsersController::class, 'store'])->middleware('guest');
