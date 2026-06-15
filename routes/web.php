<?php

use App\Http\Controllers\UsersController;
use App\Http\Controllers\Agent\AuthController;
use App\Http\Controllers\Agent\AgentDashboardController;
use App\Http\Controllers\Agent\EntriesController;
use App\Http\Controllers\Agent\DenominationController;
use App\Http\Controllers\api\PdfReportController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

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
    return view('welcome');
    return view('SEO.index');
});
Route::get('/dop-login', function () {
    return view('dopLogin');
});
Route::get('/rms-code', function () {
    return view('RmCode');
});

Route::get('/send-mail', function () {
    $data = array('name' => "Virat Gandhi");
    Mail::send([], [], function ($message) {
        $message->to('khatod.anilji@gmail.com', 'Khatod RD Collection')
            ->subject('Daily Collection Record');
        //$message->to('divyank.kabra@bacancy.com', 'Khatod RD Collection')
        $message->from('support@digitalsmartagent.com', 'DSA Support Team');
    });
    echo "Basic Email Sent. Check your inbox.";
});

Route::get('generate-pdf', [UsersController::class, 'index']);
Route::get('rm-deposit-generate-pdf', [UsersController::class, 'index']);
Route::get('entries-excel', [UsersController::class, 'getEntriesExcel']);
Route::get('/clear', function () {
    Artisan::call('optimize:clear');
    echo "Cache Cleared";
});

Route::get('rm-current-month-deposit-report', [PdfReportController::class, 'rmCurrentMonthDepositReport'])->name('rm.complete_month_report');

Route::prefix('agent')->group(function () {
    Route::get('/',  [AuthController::class, 'login']);
    Route::get('/login',  [AuthController::class, 'login']);
    Route::get('/dashboard',  [AgentDashboardController::class, 'index']);
    Route::get('/today-entries',  [EntriesController::class, 'index'])->name('entries');
    Route::middleware(['auth'])->group(function () {});
    Route::get('/denomination',  [DenominationController::class, 'index'])->name('denominationList');
});


// Route::get('/test-fcm', function () {

//     $deviceToken = "c2BvY7lXQ2ST_LS_spovTY:APA91bGuRyeo2f5iDwcc7C-OXx9gdrIalUJEAY3NwVOD34RUXU6ee0bRBzAcJZH9Ljp08SBZqBUAp1UqzPmBb32o7JNaBDfvy-f1UIBMIViurJiKWLLhvAE";

//     $credentials = json_decode(
//         file_get_contents(storage_path('app/firebase/firebase.json')),
//         true
//     );

//     $client = new \Google\Auth\Credentials\ServiceAccountCredentials(
//         "https://www.googleapis.com/auth/firebase.messaging",
//         $credentials
//     );

//     $token = $client->fetchAuthToken();
//     $accessToken = $token['access_token'];

//     $projectId = $credentials['project_id'];

//     $response = Http::withToken($accessToken)
//         ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
//             "message" => [
//                 "token" => $deviceToken,
//                 "notification" => [
//                     "title" => "Laravel Test 🚀",
//                     "body" => "Notification is working!",
//                     "android_channel_id" => "default_channel_id",
//                 ],
//                 "android" => [
//                     "notification" => [
//                         "sound" => "default",
//                         "default_sound" => true
//                     ]
//                 ]
//             ]
//         ]);

//     return $response->json();
// });
