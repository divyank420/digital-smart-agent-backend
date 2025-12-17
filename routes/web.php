<?php

use App\Http\Controllers\UsersController;
use App\Http\Controllers\Agent\AuthController;
use App\Http\Controllers\Agent\AgentDashboardController;
use App\Http\Controllers\Agent\EntriesController;
use App\Http\Controllers\Agent\DenominationController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('SEO.index');
    return view('website.index');
});
Route::get('/rms-code', function () {
    return view('RmCode');
});

Route::get('/send-mail', function () {
    $data = array('name'=>"Virat Gandhi");
      Mail::send([], [], function($message) {
         $message->to('khatod.anilji@gmail.com', 'Khatod RD Collection')
         ->subject('Daily Collection Record');
         //$message->to('divyank.kabra@bacancy.com', 'Khatod RD Collection')
         $message->from('support@digitalsmartagent.com','DSA Support Team');
      });
      echo "Basic Email Sent. Check your inbox.";
});

Route::get('generate-pdf', [UsersController::class, 'index']);
Route::get('entries-excel', [UsersController::class, 'getEntriesExcel']);
Route::get('/clear', function () {
    Artisan::call('optimize:clear');
    echo "Cache Cleared";
});

Route::prefix('agent')->group(function () {
    Route::get('/',  [AuthController::class, 'login']);
    Route::get('/login',  [AuthController::class, 'login']);
    Route::get('/dashboard',  [AgentDashboardController::class, 'index']);
    Route::get('/today-entries',  [EntriesController::class, 'index'])->name('entries');
    Route::middleware(['auth'])->group(function () {
    });
    Route::get('/denomination',  [DenominationController::class, 'index'])->name('denominationList');
});
