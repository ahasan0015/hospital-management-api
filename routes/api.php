<?php

use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::apiResource('users',UserController::class);


Route::get('/users', [UserController::class, 'index']);  //List users
Route::delete('/users/{id}', [UserController::class, 'destroy']); // Delete user
Route::get('/users/{id}', [UserController::class, 'show']); // details