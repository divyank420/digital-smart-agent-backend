<?php
// Customer App Apis

use App\Http\Controllers\api\Customer\CustomerApiController;
use App\Http\Controllers\api\Customer\CustomerAuthController;
use App\Http\Controllers\api\Customer\CustomersController;
use Illuminate\Support\Facades\Route;

Route::prefix('customer')->group(function () {
    Route::post('login', [CustomerAuthController::class, 'login']);
    Route::post('yearly-report-summary', [CustomersController::class, 'yearlyReportSummary']);

    Route::middleware('jwt.verify')->group(function () {
        Route::post('update-password', [CustomerApiController::class, 'updatePassword']);
        Route::post('update-profile', [CustomerApiController::class, 'updateProfile']);
        // Route::controller(CustomersController::class)->group(function () {
        //     Route::get('dashboard', 'dashboard');
        //     Route::get('rm-accounts', 'getRmAccounts');
        // });
    });
    Route::controller(CustomersController::class)->group(function () {
        Route::get('dashboard', 'dashboard');
        Route::get('rm-accounts', 'getRmAccounts');
    });
});
