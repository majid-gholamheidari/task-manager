<?php

use App\Http\Controllers\Api\V1\AuthenticationController;
use App\Http\Controllers\Api\V1\BoardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['prefix' => 'v1'], function () {

    // Authentication routes
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthenticationController::class, 'login']);
        Route::post('register', [AuthenticationController::class, 'register']);
        Route::post('logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');
    });


    // Board routes
    Route::group(['prefix' => 'board', 'middleware' => 'auth:sanctum'], function () {
        Route::post('/index', [BoardController::class, 'index']);
        Route::post('/store', [BoardController::class, 'store']);
        Route::post('/update/{board_code}', [BoardController::class, 'update']);
    });
});
