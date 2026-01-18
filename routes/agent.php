<?php

use App\Http\Controllers\Agent\AccountsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Agent\AuthController;
use App\Http\Controllers\Agent\AgentDashboardController;
use App\Http\Controllers\Agent\EntriesController;
use App\Http\Controllers\Agent\DenominationController;
use App\Http\Controllers\Agent\CustomerController;
use App\Http\Controllers\Agent\PromotionalMessageController;
use App\Http\Controllers\Agent\ReportsController;



Route::prefix('/agent')->name('agent.')->group(function () {

    Route::get('/',  [AuthController::class, 'login']);
    Route::any('/login',  [AuthController::class, 'login'])->name('login');

    Route::middleware('auth')->group(function () {
        Route::get('agent-logout', function () {
            session()->flush();
            auth()->logout();
            return redirect()->route('agent.login');
        })->name('logout');
        Route::get('/dashboard',  [AgentDashboardController::class, 'index'])->name('dashboard');
        /* Customer Routes */
        Route::prefix('customer')->group(function () {
            Route::get('', [CustomerController::class, 'index'])->name('customers');
            Route::get('/get-customers', [CustomerController::class, 'getCustomersData'])->name('getCustomersData');
        });

        /* Denomination Routes */
        Route::prefix('denomination')->group(function () {

            Route::get('/denomination-list',  [DenominationController::class, 'index'])->name('denomination');
            Route::match(['get', 'post'], '/edit_denomination/{id}',  [DenominationController::class, 'editDenomination'])->name('edit_denomination');
            Route::match(['get', 'post'], '/new_denomination',  [DenominationController::class, 'newDenomination'])->name('new_denomination');
        });
        Route::prefix('entries')->group(function () {
            Route::get('',  [EntriesController::class, 'index'])->name('entries');
        });

        Route::prefix('reports')->group(function () {
            Route::get('monthly-report',  [ReportsController::class, 'MonthlyReport'])->name('monthly_report');
            Route::get('collection-report',  [ReportsController::class, 'CollectionReport'])->name('collection_report');
        });

        Route::name('promotions.')->group(function () {
            Route::get('promotions', [PromotionalMessageController::class, 'index'])->name('index');
            Route::post('promotions', [PromotionalMessageController::class, 'store'])->name('store');
            Route::put('promotions/{id}', [PromotionalMessageController::class, 'update'])->name('update');
            Route::delete('promotions/{id}', [PromotionalMessageController::class, 'destroy'])->name('destroy');
        });

        Route::name('accounts.')->group(function () {
            Route::get('accounts', [AccountsController::class, 'index'])->name('index');
            Route::post('accounts', [AccountsController::class, 'store'])->name('store');
            Route::put('accounts/{id}', [AccountsController::class, 'update'])->name('update');
            Route::delete('accounts/{id}', [AccountsController::class, 'destroy'])->name('destroy');
        });

        //Route::get('/today-entries',  [EntriesController::class, 'index'])->name('entries');
        Route::get('/denomination',  [DenominationController::class, 'index'])->name('denominationList');
    });
});
