<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\SectionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'signUp']);
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });

    Route::group(['prefix' => 'me'], function () {
        Route::get('/', [MeController::class, 'show']);
        Route::put('/', [MeController::class, 'edit']);
        Route::put('/security', [MeController::class, 'editSecurity']);
    });

    Route::group(['prefix' => 'section'], function () {
        Route::get('/', [SectionController::class, 'index']);
        Route::post('/', [SectionController::class, 'store']);
        Route::get('/{id}', [SectionController::class, 'show']);
        Route::put('/{id}', [SectionController::class, 'update']);
        Route::delete('/{id}', [SectionController::class, 'delete']);
    });

    Route::group(['prefix' => 'dishes'], function () {
        Route::get('/', [DishController::class, 'index']);
        Route::post('/', [DishController::class, 'store']);
        Route::get('/{id}', [DishController::class, 'show']);
        Route::put('/{id}', [DishController::class, 'update']);
        Route::delete('/{id}', [DishController::class, 'delete']);
    });
});
