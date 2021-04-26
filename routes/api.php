<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DessertController;
use App\Http\Controllers\DessertPictureController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\DishPictureController;
use App\Http\Controllers\DrinkController;
use App\Http\Controllers\DrinkPictureController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SectionPictureController;
use App\Http\Controllers\ShowMenuController;
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

Route::group(['middleware' => ['cors']], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('register', [AuthController::class, 'signUp'])->name('register');
        Route::post('login', [AuthController::class, 'login'])->name('login');
    });

    Route::group(['middleware' => 'auth:api'], function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::get('logout', [AuthController::class, 'logout'])->name('logout');
//        Route::post('register', [AuthController::class, 'signUp']);
        });

        Route::group(['prefix' => 'me'], function () {
            Route::get('/', [MeController::class, 'show'])->name('me');
            Route::put('/', [MeController::class, 'edit'])->name('me.edit');
            Route::put('/security', [MeController::class, 'editSecurity'])->name('me.editsecurity');
        });

        Route::group(['prefix' => 'section'], function () {
            Route::get('/', [SectionController::class, 'index'])->name('section');
            Route::post('/', [SectionController::class, 'store'])->name('section.store');
            Route::get('/{id}', [SectionController::class, 'show'])->name('section.show');
            Route::put('/{id}', [SectionController::class, 'update'])->name('section.update');
            Route::delete('/{id}', [SectionController::class, 'delete'])->name('section.delete');

            Route::group(['prefix' => '{parent_id}/section-picture'], function () {
                Route::post('/', [SectionPictureController::class, 'store'])->name('section-picture.store');
                Route::delete('/{id}', [SectionPictureController::class, 'delete'])->name('section-picture.delete');
            });

            Route::group(['prefix' => '{parent_id}/dishes'], function () {
                Route::get('/', [DishController::class, 'index'])->name('dishes');
                Route::post('/', [DishController::class, 'store'])->name('dishes.store');
                Route::get('/{id}', [DishController::class, 'show'])->name('dishes.show');
                Route::put('/{id}', [DishController::class, 'update'])->name('dishes.update');
                Route::delete('/{id}', [DishController::class, 'delete'])->name('dishes.delete');

                Route::group(['prefix' => '{dish_id}/dish-picture'], function () {
                    Route::post('/', [DishPictureController::class, 'store'])->name('dish-picture.store');
                    Route::delete('/{id}', [DishPictureController::class, 'delete'])->name('dish-picture.delete');
                });
            });

            Route::group(['prefix' => '{parent_id}/desserts'], function () {
                Route::get('/', [DessertController::class, 'index'])->name('desserts');
                Route::post('/', [DessertController::class, 'store'])->name('desserts.store');
                Route::get('/{id}', [DessertController::class, 'show'])->name('desserts.show');
                Route::put('/{id}', [DessertController::class, 'update'])->name('desserts.update');
                Route::delete('/{id}', [DessertController::class, 'delete'])->name('desserts.delete');

                Route::group(['prefix' => '{dessert_id}/dessert-picture'], function () {
                    Route::post('/', [DessertPictureController::class, 'store'])->name('desserts-picture.store');
                    Route::delete('/{id}', [DessertPictureController::class, 'delete'])->name('desserts-picture.delete');
                });
            });

            Route::group(['prefix' => '{parent_id}/drinks'], function () {
                Route::get('/', [DrinkController::class, 'index'])->name('drinks');
                Route::post('/', [DrinkController::class, 'store'])->name('drinks.store');
                Route::get('/{id}', [DrinkController::class, 'show'])->name('drinks.show');
                Route::put('/{id}', [DrinkController::class, 'update'])->name('drinks.update');
                Route::delete('/{id}', [DrinkController::class, 'delete'])->name('drinks.delete');

                Route::group(['prefix' => '{drink_id}/drink-picture'], function () {
                    Route::post('/', [DrinkPictureController::class, 'store'])->name('drink-picture.store');
                    Route::delete('/{id}', [DrinkPictureController::class, 'delete'])->name('drink-picture.delete');
                });
            });
        });

        Route::group(['prefix' => '/contact'], function () {
//            Route::get('/', [ContactController::class, 'index'])->name('contact');
            Route::post('/', [ContactController::class, 'store'])->name('contact.store');
            Route::get('/{id}', [ContactController::class, 'show'])->name('contact.show');
            Route::put('/{id}', [ContactController::class, 'update'])->name('contact.update');
            Route::delete('/{id}', [ContactController::class, 'delete'])->name('contact.delete');
        });
    });

    // API ENDPOINT PUBLIC
    Route::group(['prefix' => 'menu'], function () {
        Route::get('/', [ShowMenuController::class, 'listSections'])->name('menu');
    });

    Route::group(['prefix' => '/contact'], function () {
        Route::get('/', [ContactController::class, 'index'])->name('contact');
    });
});
