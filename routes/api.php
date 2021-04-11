<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\DishPictureController;
use App\Http\Controllers\DrinkController;
use App\Http\Controllers\DrinkPictureController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SectionPictureController;
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
    Route::post('register', [AuthController::class, 'signUp']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::get('logout', [AuthController::class, 'logout']);
//        Route::post('register', [AuthController::class, 'signUp']);
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

        Route::group(['prefix' => '{parent_id}/section-picture'], function () {
           Route::post('/store', [SectionPictureController::class, 'store']);
           Route::delete('/{id}', [SectionPictureController::class, 'delete']);
        });

        Route::group(['prefix' => '{parent_id}/dishes'], function () {
            Route::get('/', [DishController::class, 'index']);
            Route::post('/', [DishController::class, 'store']);
            Route::get('/{id}', [DishController::class, 'show']);
            Route::put('/{id}', [DishController::class, 'update']);
            Route::delete('/{id}', [DishController::class, 'delete']);

            Route::group(['prefix' => '{dish_id}/dish-picture'], function () {
                Route::post('/store', [DishPictureController::class, 'store']);
                Route::delete('/{id}', [DishPictureController::class, 'delete']);
            });
        });

        Route::group(['prefix' => '{parent_id}/drinks'], function () {
            Route::get('/', [DrinkController::class, 'index']);
            Route::post('/', [DrinkController::class, 'store']);
            Route::get('/{id}', [DrinkController::class, 'show']);
            Route::put('/{id}', [DrinkController::class, 'update']);
            Route::delete('/{id}', [DrinkController::class, 'delete']);

            Route::group(['prefix' => '{drink_id}/drink-picture'], function () {
                Route::post('/store', [DrinkPictureController::class, 'store']);
                Route::delete('/{id}', [DrinkPictureController::class, 'delete']);
            });
        });
    });

    Route::group(['prefix' => '/contact'], function () {
        Route::get('/', [ContactController::class, 'index']);
        Route::post('/', [ContactController::class, 'store']);
        Route::get('/{id}', [ContactController::class, 'show']);
        Route::put('/{id}', [ContactController::class, 'update']);
        Route::delete('/{id}', [ContactController::class, 'delete']);
    });
});

/*Route::group([
    'middleware' => ['api', 'cors'],
    ], function () {
    Route::get('/', [SectionController::class, 'index']);
});*/

