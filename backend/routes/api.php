<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PersonalGroupController;
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
        Route::post('', [UserController::class, 'create'])->middleware('role:manager');
        Route::get('', [UserController::class, 'current']);
        Route::get('list', [UserController::class, 'list'])->middleware('role:manager');
        Route::get('roles', [UserController::class, 'listRoles'])->middleware('role:manager');
        Route::patch('{id}', [UserController::class, 'update']);
        Route::delete('{id}', [UserController::class, 'remove'])->middleware('role:manager');
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
        Route::get('', [AgentController::class, 'list']);
        Route::post('', [AgentController::class, 'create']);
        Route::get('{id}', [AgentController::class, 'find']);
        Route::delete('{id}', [AgentController::class, 'remove']);
        Route::patch('{id}', [AgentController::class, 'update']);
    });

    /**
     * -----------------------------------------
     *	Personal
     * -----------------------------------------
     */
    Route::prefix('personal')->group(function () {
        /**
         * -------------------------------------
         *	Groups
         * -------------------------------------
         */
        Route::middleware('role:manager')->prefix('groups')->group(function () {
            Route::get('', [PersonalGroupController::class, 'list']);
            Route::post('', [PersonalGroupController::class, 'create']);
            Route::patch('{id}', [PersonalGroupController::class, 'update']);
            Route::delete('{id}', [PersonalGroupController::class, 'remove']);
            Route::post('{id}/add-user', [PersonalGroupController::class, 'addUser']);
            Route::post('{id}/remove-user', [PersonalGroupController::class, 'removeUser']);
        });
    });

    /**
     * -----------------------------------------
     *	Assignments
     * -----------------------------------------
     */
    Route::prefix('assignments')->group(function () {
        Route::get('', [AssignmentController::class, 'list']);
        Route::post('', [AssignmentController::class, 'create']);
        Route::get('{id}', [AssignmentController::class, 'find']);
        Route::delete('{id}', [AssignmentController::class, 'remove']);
        Route::patch('{id}', [AssignmentController::class, 'update']);
    });
});
