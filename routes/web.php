<?php

use App\Http\Controllers\BalanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Logincontroller;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['cors']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('/');
    Route::prefix('api/v1/auth')->group(function () {
        Route::post('login', [Logincontroller::class, 'authenticate'])->name('login');
        Route::post('register', [Logincontroller::class, 'register'])->name('register');
    });
});

Route::group(['middleware' => ['jwt.verify', 'cors']], function () {
    Route::prefix('api/v1')->group(function () {
        Route::post('transaction', [TransactionController::class, 'processTransaction'])->name('transaction');
        Route::prefix('transaction')->group(function () {
            Route::post('get', [TransactionController::class, 'getTransactions'])->name('transaction');
        });
        Route::post('qoute', [BalanceController::class, 'jokesRandom'])->name('qoute');

    });

});
