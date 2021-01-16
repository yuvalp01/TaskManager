<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Task;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SharedTaskController;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Open routes:
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

//The following routes will be access only with auth token
Route::group(['middleware' => ['auth:api']], function () {

    Route::get('logout', [UserController::class, 'logout']);

    //Tasks CRUD
    Route::get('tasks/{user_id}', [TaskController::class, 'showUserTasks']);
    Route::post('tasks', [TaskController::class, 'add']);
    Route::put('tasks/{id}', [TaskController::class, 'update']);
    Route::delete('tasks/{id}', [TaskController::class, 'delete']);
    Route::put('restore', [TaskController::class, 'restoreAll']);
    Route::delete('hardDelete', [TaskController::class, 'hardDelete']);

    //Shared tasks - share/unshare
    Route::post('sharedTasks', [SharedTaskController::class, 'share']);
    Route::delete('sharedTasks', [SharedTaskController::class, 'unshare']);

    //Users
    Route::get('users', [UserController::class, 'getAllUsers']);

    //for testing purposes
    Route::get('tasks', [TaskController::class, 'index']);
    Route::get('sharedTasks', [SharedTaskController::class, 'index']);
});
