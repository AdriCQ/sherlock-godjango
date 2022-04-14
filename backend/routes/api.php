<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Login
Route::post('users/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    /**
     * -----------------------------------------
     *	User Routes
     * -----------------------------------------
     */
    Route::prefix('users')->group(function () {
        Route::post('', [UserController::class, 'create']);
        Route::get('', [UserController::class, 'current']);
        Route::patch('{id}', [UserController::class, 'updatePassword']);
        Route::delete('{id}', [UserController::class, 'remove']);
    });


    /**
     * -----------------------------------------
     *	Categories
     * -----------------------------------------
     */
    Route::prefix('categories')->group(function () {
        Route::get('', [CategoryController::class, 'list']);
        Route::post('', [CategoryController::class, 'create']);
        Route::patch('{id}', [CategoryController::class, 'update']);
        Route::delete('{id}', [CategoryController::class, 'remove']);
    });

    /**
     * -----------------------------------------
     *	Agents
     * -----------------------------------------
     */
    Route::prefix('agents')->group(function () {
        Route::post('', [AgentController::class, 'create']);
        Route::get('{id}', [AgentController::class, 'find']);
    });
});
