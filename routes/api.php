<?php

use App\Http\Controllers\api\ApiController;
use App\Http\Controllers\api\DashboardController;
//use App\Http\Controllers\api\admin\AdminDashboardController;
use App\Http\Controllers\Agent\DenominationController;
use App\Http\Controllers\api\CompanyAccountController;
use App\Http\Controllers\api\Customer\CustomerApiController;
use App\Http\Controllers\api\InstallmentController;
use App\Http\Controllers\api\RmController;
use App\Http\Controllers\api\CustomersController;
use App\Http\Controllers\api\DopController;
use App\Http\Controllers\api\ReportsController;
use App\Http\Controllers\api\PdfReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Apply CORS middleware to all API routes
Route::middleware('cors')->group(function () {
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('check', function () {
        return json_encode(['hello' => 'adsfdf']);
    });
    Route::any('get-pending-account-lists', [RmController::class, 'getPendingAccountsList']);

    Route::post('login', [ApiController::class, 'login']);
    Route::post('register', [ApiController::class, 'register']);
    Route::middleware('jwt.verify')->group(function () {
        Route::any('dashboard', [DashboardController::class, 'dashboard']);
        Route::post('dashboard-summary', [DashboardController::class, 'getDashboardSummary']);

        Route::get('get-config-settings', [ApiController::class, 'getConfigSettings']);
        Route::post('create-customer', [ApiController::class, 'createCustomer']);
        Route::get('customer-detail', [ApiController::class, 'customerDetail']);

        /* Rm */

        Route::get('get-rm-list', [RmController::class, 'getRmList']);
        Route::post('add-new-rm', [RmController::class, 'newRm']);
        Route::any('rm-detail', [RmController::class, 'rmDetail']);
        Route::post('edit-rm', [RmController::class, 'editRm']);
        Route::post('delete-rm', [RmController::class, 'deleteRm']);
        Route::get('get-new-rm-code', [RmController::class, 'getNewRmCode']);
        Route::post('rm-yearly-summary', [RmController::class, 'rmYearlySummary']);
        Route::get('fetch-rm-monthly-amount-history', [RmController::class, 'fetchRmMonthlyAmountHistory']);
        Route::post('save-rm-monthly-amount-history', [RmController::class, 'saveRmMonthlyAmountHistory']);

        Route::post('rm-entry-list', [RmController::class, 'getRmEntries']);
        Route::post('get-entries-lists', [RmController::class, 'getEntriesList']);
        Route::post('get-last-entry', [RmController::class, 'getLastEntry']);

        Route::Post('rm-entry', [InstallmentController::class, 'rmInstallmentEntry']);
        Route::Post('installment-detail', [InstallmentController::class, 'installmentDetail']);
        Route::Post('rm-edit-entry', [InstallmentController::class, 'editInstallmentEnter']);
        Route::Post('delete-rm-entry', [InstallmentController::class, 'deleteInstallment']);
        Route::Post('restore-rm-entry', [InstallmentController::class, 'restoreInstallment']);


        Route::Post('upload-denomination', [ApiController::class, 'uploadDenomination']);
        Route::Post('update-denomination', [ApiController::class, 'updateDenomination']);
        Route::any('denomination-detail', [ApiController::class, 'denominationDetail']);
        Route::any('get-denomination-detail', [ApiController::class, 'getDenominationDetail']);
        Route::any('denomination-list', [ApiController::class, 'denominationList']);
        Route::any('denominations', [ApiController::class, 'denominationList']);

        Route::Post('add-expences', [ApiController::class, 'addExpences']);
        Route::Post('expenses-list', [ApiController::class, 'expencesList']);
        Route::Post('update-expences', [ApiController::class, 'updateExpences']);
        Route::Post('delete-expences', [ApiController::class, 'deleteExpences']);

        Route::any('rm-scan-code', [ApiController::class, 'RmScanCode']);

        /* DOP Section API's */
        Route::prefix('dop')->controller(DopController::class)->group(function () {
            Route::post('dashboard',  'dopDashboard');
            Route::post('accounts',  'getDopAccounts');
            Route::post('lots',  'lots');
        });

        /* Bank Accounts */
        Route::prefix('bank-accounts')->group(function () {
            Route::get('accounts-listing', [CompanyAccountController::class, 'index']);
            Route::post('add-new-account', [CompanyAccountController::class, 'store']);
            Route::put('update-account/{id}', [CompanyAccountController::class, 'update']);
            Route::get('account-detail/{id}', [CompanyAccountController::class, 'show']);
            Route::get('account-transactions/{id}', [CompanyAccountController::class, 'transactions']);
        });

        /* Reports */
        Route::any('report-dashboard', [ReportsController::class, 'reportDashboard']);
        Route::any('get-overall-report', [ReportsController::class, 'getOverAllReport']);
        Route::any('yearly-report', [ReportsController::class, 'yearlyReport']);
        Route::any('monthly-report', [ReportsController::class, 'monthlyReport']);
        Route::any('days-collection-list', [ReportsController::class, 'daysCollectionList']);
        Route::post('get-entries-report-lists', [RmController::class, 'getEntriesReportList']);

        //Route::post('customer-dashboard', [CustomersController::class, 'dashboard']);
        Route::controller(CustomersController::class)->group(function () {
            Route::get('customer-dashboard', 'dashboard')->name('customerDashbaord');
            Route::get('customer-portfolio', 'portfolio')->name('customerPortfolio');
        });
    });

    Route::get('generate-pdf-report', [ReportsController::class, 'generatePdfReport'])->name('api.collection_pdf_report');
    Route::get('monthly-posting-report', [PdfReportController::class, 'monthlyPostingReport']);
    Route::get('customer-installment-report', [PdfReportController::class, 'getCustomerInstallmentReport']);
    Route::get('rm-months-deposits-report', [PdfReportController::class, 'rmMonthsDepositsReport']);
    Route::get('rm-current-month-deposit-report', function (Illuminate\Http\Request $request) {
        return redirect()->route('rm.complete_month_report', $request->all());
    });

    Route::prefix('agent')->group(function () {
        //Route::any('dashboard', [AdminDashboardController::class, 'dashboard']);
        Route::get('/get-denomination',  [DenominationController::class, 'getDenominationList'])->name('getDenominationList');
    });
});

// Customer App Apis
Route::prefix('customer')->group(function () {
    Route::post('login', [ApiController::class, 'login']);
    Route::post('yearly-report-summary', [CustomersController::class, 'yearlyReportSummary']);

    Route::middleware('jwt.verify')->group(function () {
        Route::post('update-password', [CustomerApiController::class, 'updatePassword']);
        Route::post('update-profile', [CustomerApiController::class, 'updateProfile']);

        Route::controller(CustomersController::class)->group(function () {
            Route::get('dashboard', 'dashboard');
        });
    });
});
