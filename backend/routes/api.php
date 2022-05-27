<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AgentGroupController;
use App\Http\Controllers\EventController;
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
        /**
         * -------------------------------------
         *	Agent Groups
         * -------------------------------------
         */
        Route::middleware('role:manager')->prefix('groups')->group(function () {
            Route::get('', [AgentGroupController::class, 'list']);
            Route::post('', [AgentGroupController::class, 'create']);
            Route::patch('{id}', [AgentGroupController::class, 'update']);
            Route::delete('{id}', [AgentGroupController::class, 'remove']);
            Route::post('{id}/add-agent', [AgentGroupController::class, 'addAgent']);
            Route::post('{id}/remove-agent', [AgentGroupController::class, 'removeAgent']);
        });

        Route::get('', [AgentController::class, 'list']);
        Route::post('', [AgentController::class, 'create']);
        Route::get('assignments', [AgentController::class, 'assignments']);
        Route::get('whoami', [AgentController::class, 'whoami']);
        Route::get('search', [AgentController::class, 'search']);
        Route::get('{id}', [AgentController::class, 'find']);
        Route::delete('{id}', [AgentController::class, 'remove']);
        Route::patch('{id}', [AgentController::class, 'update']);
    });

    /**
     * -----------------------------------------
     *	Assignments
     * -----------------------------------------
     */
    Route::prefix('assignments')->group(function () {
        Route::get('', [AssignmentController::class, 'list']);
        Route::post('', [AssignmentController::class, 'create']);
        Route::post('search', [AssignmentController::class, 'filter']);
        Route::patch('checkpoints/{id}', [AssignmentController::class, 'updateCheckpoint']);
        Route::delete('checkpoints/{id}', [AssignmentController::class, 'removeCheckpoint']);
        Route::get('{id}', [AssignmentController::class, 'find']);
        Route::delete('{id}', [AssignmentController::class, 'remove']);
        Route::patch('{id}', [AssignmentController::class, 'update']);
        Route::post('{id}/assign-checkpoint', [AssignmentController::class, 'assignCheckpoint']);
    });

    /**
     * -----------------------------------------
     *	Events
     * -----------------------------------------
     */

    Route::prefix('events')->group(function () {
        Route::post('', [EventController::class, 'create']);
        Route::get('mine', [EventController::class, 'mine']);

        Route::middleware('role:manager')->group(function () {
            Route::get('', [EventController::class, 'list']);
            Route::post('search', [EventController::class, 'search']);
            Route::get('{id}', [EventController::class, 'find']);
            Route::delete('{id}', [EventController::class, 'remove']);
            Route::patch('{id}', [EventController::class, 'update']);
        });
    });
});
