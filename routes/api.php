<?php

use App\Http\Controllers\Api\V1\AuthenticationController;
use App\Http\Controllers\Api\V1\BoardController;
use App\Http\Controllers\Api\V1\MemberController;
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
        Route::post('/{board_code}/update', [BoardController::class, 'update']);

        // Members routes
        Route::group(['prefix' => 'member'], function () {
            Route::post('{board_code}/index', [MemberController::class, 'index']);
            Route::post('{board_code}/store', [MemberController::class, 'store']);
        });
    });
});

Route::middleware('auth:sanctum')->post('dd', function () {
    dd(\Illuminate\Support\Facades\Auth::user()->accessTo('VM'));
});
