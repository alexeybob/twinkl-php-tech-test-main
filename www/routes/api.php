<?php

use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest', 'ip']], function () {
    Route::get('/users', [UsersController::class, 'index']);
    Route::post('/user/store', [UsersController::class, 'store']);
});
