<?php

use App\Http\Controllers\api\ApiController;
use App\Http\Controllers\api\DashboardController;
//use App\Http\Controllers\api\admin\AdminDashboardController;
use App\Http\Controllers\Agent\DenominationController;
use App\Http\Controllers\api\InstallmentController;
use App\Http\Controllers\api\RmController;
use App\Http\Controllers\api\CustomersController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('check', function(){
    return json_encode(['hello'=>'adsfdf']);
});
Route::any('get-pending-account-lists', [RmController::class, 'getPendingAccountsList']);
Route::group(['middleware'=>'cors'], function () {
    Route::post('login', [ApiController::class, 'login']);
    Route::post('register', [ApiController::class, 'register']);
    Route::middleware('jwt.verify')->group(function() {
        Route::any('dashboard', [DashboardController::class, 'dashboard']);
        Route::post('dashboard-summary', [DashboardController::class, 'getDashboardSummary']);

        /* Rm */
        
        Route::get('get-rm-list', [RmController::class, 'getRmList']);
        Route::post('add-new-rm', [RmController::class, 'newRm']);
        Route::any('rm-detail', [RmController::class, 'rmDetail']);
        Route::post('edit-rm', [RmController::class, 'editRm']);
        Route::post('delete-rm', [RmController::class, 'deleteRm']);
        Route::get('get-new-rm-code', [RmController::class, 'getNewRmCode']);
        
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
        Route::any('denomination-list', [ApiController::class, 'denominationList']);
        
        Route::Post('expences', [ApiController::class, 'expences']);
        Route::Post('expenses-list', [ApiController::class, 'expencesList']);
        
        Route::any('rm-scan-code', [ApiController::class, 'RmScanCode']);
        
        /* Reports */
        Route::any('get-overall-report', [ReportsController::class, 'getOverAllReport']);
        Route::any('yearly-report', [ReportsController::class, 'yearlyReport']);
        Route::any('monthly-report', [ReportsController::class, 'monthlyReport']);
        Route::any('days-collection-list', [ReportsController::class, 'daysCollectionList']);
        Route::post('get-entries-report-lists', [RmController::class, 'getEntriesReportList']);

        //Route::post('customer-dashboard', [CustomersController::class, 'dashboard']);
        Route::controller(CustomersController::class)->group(function(){
            Route::get('customer-dashboard', 'dashboard')->name('customerDashbaord');
            Route::get('customer-portfolio', 'portfolio')->name('customerPortfolio');
        });

    });

    Route::get('generate-pdf-report', [ReportsController::class, 'generatePdfReport'])->name('api.collection_pdf_report');
    Route::get('monthly-posting-report', [PdfReportController::class, 'monthlyPostingReport']);
    Route::get('customer-installment-report', [PdfReportController::class, 'getCustomerInstallmentReport']);

    Route::prefix('agent')->group(function () {
        //Route::any('dashboard', [AdminDashboardController::class, 'dashboard']);
        Route::get('/get-denomination',  [DenominationController::class, 'getDenominationList'])->name('getDenominationList');
    });
});
