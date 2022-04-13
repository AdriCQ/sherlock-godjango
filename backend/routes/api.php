<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/**
 * -----------------------------------------
 *	User Routes
 * -----------------------------------------
 */

Route::prefix('users')->group(function () {
    Route::post('', [UserController::class, 'create']);
    /**
     *
     */
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('', [UserController::class, 'current']);
        Route::post('login', [UserController::class, 'login']);
        Route::patch('{id}', [UserController::class, 'updatePassword']);
        Route::delete('{id}', [UserController::class, 'remove']);
    });
});


Route::middleware('auth:sanctum', function () {
    /**
     * -----------------------------------------
     *	Categories
     * -----------------------------------------
     */
    Route::prefix('categories', function () {
        Route::get('', [CategoryController::class, 'list']);
        Route::post('', [CategoryController::class, 'create']);
        Route::patch('{id}', [CategoryController::class, 'update']);
        Route::delete('{id}', [CategoryController::class, 'remove']);
    });
});
