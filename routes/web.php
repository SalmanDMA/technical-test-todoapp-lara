<?php

use App\Http\Controllers\WEB\AuthController;
use App\Http\Controllers\WEB\MainController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(['prefix' => 'login'], function () {
    Route::get('/', [AuthController::class, 'v_login'])->name('v_login');
    Route::post('/', [AuthController::class, 'login'])->name('login');
});

Route::group(['prefix' => 'register'], function () {
    Route::get('/', [AuthController::class, 'v_register'])->name('v_register');
    Route::post('/', [AuthController::class, 'register'])->name('register');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [MainController::class, 'index'])->name('home');

Route::group(['prefix' => 'task', 'as' => 'task.'], function () {
    Route::post('/', [MainController::class, 'store'])->name('store');
    Route::delete('multiple-delete', [MainController::class, 'multiple_delete'])->name('multiple_delete');
    Route::put('multiple-complete', [MainController::class, 'multiple_complete'])->name('multiple_complete');
    Route::put('multiple-uncomplete', [MainController::class, 'multiple_uncomplete'])->name('multiple_uncomplete');
    Route::put('/{id}', [MainController::class, 'update'])->name('update');
    Route::delete('/{id}', [MainController::class, 'destroy'])->name('destroy');
});
