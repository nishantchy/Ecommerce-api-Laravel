<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\ProductConttroller;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/register', [UserController::class, 'index']);
Route::post('/register', [UserController::class, 'store']);
Route::get('/login', [UserController::class, 'index']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/product', [ProductConttroller::class, 'index']);
Route::post('/product', [ProductConttroller::class, 'store']);