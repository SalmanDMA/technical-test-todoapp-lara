<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TaskController;
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

Route::get('not-auth', [AuthController::class, 'notAuthorized'])->name('not-authorized');

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
    });

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::group(['prefix' => 'tasks', 'as' => 'api.tasks.'], function () {
            Route::get('/', [TaskController::class, 'index'])->name('index');
            Route::get('/{id}', [TaskController::class, 'show'])->name('show');
            Route::post('/', [TaskController::class, 'store'])->name('store');
            Route::put('/{id}', [TaskController::class, 'update'])->name('update');
            Route::delete('/{id}', [TaskController::class, 'destroy'])->name('destroy');
            Route::put('/{id}/complete', [TaskController::class, 'update_status_complete'])->name('update_status_complete');
            Route::put('/{id}/uncomplete', [TaskController::class, 'update_status_uncomplete'])->name('update_status_uncomplete');
        });
    });
});
