<?php



namespace App\Helper;

use App\Models\PromotionalMessage;
use Illuminate\Support\Facades\DB;
use Image;
use App\Models\SavingDenomination;
use App\Models\SavingRm;
use App\Models\SavingRmEntries;
use App\Models\SavingExpenses;
use App\Models\SavingCompany;
use App\Models\User;
use Carbon\Carbon;

class Helper
{
    public static function pr($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
    public static function pushNotification($tokens, $notificationData)
    {
        if (!empty($tokens)) {
            if (gettype($tokens) != 'array') {
                $tokens = [$tokens];
            }
        } else {
            $tokens = [''];
        }

        $data = $notificationData;
        $fcmNotification = [
            'registration_ids' => $tokens,
            //'notification' => $notificationData['data'],
            'notification' => $notificationData,
            //'data' => ['data'=> $notificationData]
        ];
        $headers = [
            'Authorization: key=' . env('FCM_API_KEY'),
            'Content-Type: application/json'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        //pr($result);die;
        curl_close($ch);
        return $result;
    }

    public static function getAllRmCode()
    {
        return SavingRm::all();
    }
    public static function getUserRole($id)
    {
        return User::where('id', $id)->pluck('role')->first();
    }

    public static function getTeamMember($company_id = null)
    {
        if (empty($company_id)) {
            $company_id = auth()->user()->company_id;
        }
        $members = User::where('company_id', $company_id)->pluck('name', 'id');
        return $members;
    }
    public static function CheckDenominationAddedOrNot($id)
    {
        return SavingDenomination::where('user_id', $id)->whereDate('created_at', date('Y-m-d'))->count();
    }

    public static function ValidationSet($data)
    {
        $errors = array_column(json_decode(json_encode($data), true), 0)[0];
        self::sendResponse($errors, 422);
    }
    public static function WebValidationSet($data)
    {
        $errors = array_column(json_decode(json_encode($data), true), 0)[0];
        return $errors;
    }

    public static function getLastEntry($rmId)
    {
        /* Last Entry Data */
        $entryData = SavingRmEntries::where(['rm_id' => $rmId])->orderBy('id', 'DESC')->first();

        /* Last Month , Current Month total deposit amount */

        $currentMonth = (int)date('m');
        $currentYear = (int)date('Y');
        $lastMonth = (int)date('m', strtotime(date('Y-m-d') . '-1 month'));
        $lastYear = (int)date('Y', strtotime(date('Y-m-d') . '-1 month'));
        $nextMonth = (int)date('m', strtotime(date('Y-m-d') . '+1 month'));
        $nextYear = (int)date('Y', strtotime(date('Y-m-d') . '+1 month'));



        $rowData = SavingRmEntries::join('saving_rms', 'rm_id', '=', 'saving_rms.id')
            ->select(
                DB::raw('CAST(sum(amount) as INT) as total_deposit'),
                'monthly_amount',
                DB::raw('SUM(CASE WHEN payment_month = "' . $lastMonth . '" and payment_year = "' . $lastYear . '" THEN amount else 0 END) AS last_deposit'),
                DB::raw('SUM(CASE WHEN payment_month = "' . $currentMonth . '" and payment_year = "' . $currentYear . '" THEN amount else 0 END) AS current_deposit'),
                DB::raw('SUM(CASE WHEN payment_month = "' . $nextMonth . '" and payment_year = "' . $nextYear . '" THEN amount else 0 END) AS next_month_deposit'),
            )->where('rm_id', $rmId)
            ->first();
        //->first();
        $monthly_amount = (int)$rowData->monthly_amount;
        $month = (int)date('m');
        $year = (int)date('Y');
        $lastDepositAmount = (int)$rowData->last_deposit;
        $currentDepositAmount = (int)$rowData->current_deposit;

        if ($lastDepositAmount < $monthly_amount) {
            $month = $lastMonth;
            $year = $lastYear;
            $remainingAmount = $monthly_amount - $lastDepositAmount;
        } else if ($currentDepositAmount <= $monthly_amount) {
            $month = $currentMonth;
            $year = $currentYear;
            $remainingAmount = $monthly_amount - $currentDepositAmount;
        } else {
            $month = $nextMonth;
            $year = $nextYear;
            $remainingAmount = $monthly_amount;
        }

        /* if ($currentDepositAmount >= $monthly_amount) {
            $month = $month == 12 ? 0 : $month;
            $year = $month == 12 ? $year + 1 : $year;
            $remainingAmount = '+' . ($currentDepositAmount - $monthly_amount);
        } else {
            $year = $year;
            $month = $month - 1;
            $remainingAmount = '-' . ($monthly_amount - $currentDepositAmount);
        } */
        if (!empty($entryData)) {
            $lastEntryData = ['entry_date' => date('d-M-Y', strtotime($entryData->created_at)), 'amount' => $entryData->amount];
        }
        $entrySetup = [
            'last_entry_data' => $lastEntryData ?? [],
            'month' => $month,
            'year' => $year,
            'deposit_amount' => $currentDepositAmount,
            'remaining_amount' => $remainingAmount,
            'monthly_amount' => $monthly_amount,
        ];
        return $entrySetup;
    }
    public static function getLastEntry_old($rmId)
    {
        $monthly_amount = SavingRm::where(['id' => $rmId])->pluck('monthly_amount')->first();
        $entryData = SavingRmEntries::where(['rm_id' => $rmId])->orderBy('id', 'DESC')->first();
        $month = (int)date('m');
        $year = (int)date('Y');
        $totalDepositAmount = SavingRmEntries::where([
            'rm_id' => $rmId,
            'payment_month' => $month,
            'payment_year' => $year
        ])->sum('amount');

        if ($totalDepositAmount >= $monthly_amount) {
            $month = $month == 12 ? 0 : $month;
            $year = $month == 12 ? $year + 1 : $year;
            $remainingAmount = '+' . ($totalDepositAmount - $monthly_amount);
        } else {
            $year = $year;
            $month = $month - 1;
            $remainingAmount = '-' . ($monthly_amount - $totalDepositAmount);
        }
        if (!empty($entryData)) {
            $lastEntryData = ['entry_date' => date('d-M-Y', strtotime($entryData->created_at)), 'amount' => $entryData->amount];
        }
        $entrySetup = [
            'last_entry_data' => $lastEntryData ?? [],
            'month' => $month,
            'year' => $year,
            'deposit_amount' => $totalDepositAmount,
            'remaining_amount' => $remainingAmount,
        ];
        return $entrySetup;
    }
    public  static function sendResponse($message = 'Something went wrong', $status = 500, $data = null, $extra = null)
    {
        $response = ['status' => $status, 'message' => $message];
        if (!empty($extra)) {
            extract($extra);
            $response = array_merge($response, $extra);
        }
        if ($status != 0) {
            if (!empty($data)) {
                $response['data'] = $data;
            }
        }
        if (strlen($status) == 3) {
            unset($response['status']);
            http_response_code($status);
        }
        echo json_encode($response);
        die;
    }
    public static function getCompanyDetail($company_id)
    {
        return SavingCompany::find($company_id);
    }

    public static function getReportExpenses($company_id, $expencesDate)
    {
        return SavingExpenses::where('company_id', $company_id)
            ->whereDate('created_at', date('Y-m-d', strtotime($expencesDate)))
            ->whereIn('expenses_type', ['Others', 'Withdrawal'])
            ->get();
    }
    public static function getDenomination($company_id, $denominationDate = null)
    {
        $denominationDate = $denominationDate == null ? date('Y-m-d') : date('Y-m-d', strtotime($denominationDate));

        $denomination = SavingDenomination::select([
            'id',
            'denomination_date',
            DB::raw('SUM(CASE WHEN online > 0 THEN online ELSE 0 END) as online'),
            DB::raw('SUM(CASE WHEN n_2000 > 0 THEN n_2000 ELSE 0 END) as n_2000'),
            DB::raw('SUM(CASE WHEN n_2000 > 0 THEN n_2000*2000 ELSE 0 END) as n_2000_value'),
            DB::raw('SUM(CASE WHEN n_500 > 0 THEN n_500 ELSE 0 END) as n_500'),
            DB::raw('SUM(CASE WHEN n_500 > 0 THEN n_500*500 ELSE 0 END) as n_500_value'),
            DB::raw('SUM(CASE WHEN n_200 > 0 THEN n_200 ELSE 0 END) as n_200'),
            DB::raw('SUM(CASE WHEN n_200 > 0 THEN n_200*200 ELSE 0 END) as n_200_value'),
            DB::raw('SUM(CASE WHEN n_100 > 0 THEN n_100 ELSE 0 END) as n_100'),
            DB::raw('SUM(CASE WHEN n_100 > 0 THEN n_100*100 ELSE 0 END) as n_100_value'),
            DB::raw('SUM(CASE WHEN n_50 > 0 THEN n_50 ELSE 0 END) as n_50'),
            DB::raw('SUM(CASE WHEN n_50 > 0 THEN n_50*50 ELSE 0 END) as n_50_value'),
            DB::raw('SUM(CASE WHEN n_20 > 0 THEN n_20 ELSE 0 END) as n_20'),
            DB::raw('SUM(CASE WHEN n_20 > 0 THEN n_20*20 ELSE 0 END) as n_20_value'),
            DB::raw('SUM(CASE WHEN n_10 > 0 THEN n_10 ELSE 0 END) as n_10'),
            DB::raw('SUM(CASE WHEN n_10 > 0 THEN n_10*10 ELSE 0 END) as n_10_value'),
        ])
            ->where('company_id', $company_id)
            ->whereDate('denomination_date', $denominationDate)->first();
        return $denomination;
    }
    public static function getTotalEntries($type = 'today')
    {
        $entries = SavingRmEntries::query();
        if ($type == 'today') {
        } else {
        }
        return $entries = $entries->whereDate('entry_date', date('Y-m-d'))->sum('amount');
    }

    public static function getTotalExpences($type = 'today')
    {
        $expences = SavingExpenses::query();
        if ($type == 'today') {
        } else {
        }
        return $expences = $expences->whereDate('created_at', date('Y-m-d'))->sum('amount');
    }

    public static function transactionWithPromotionalMessage($customerName, $transactionMessage)
    {
        $greeting = "Dear *{$customerName}* 👋, \n\n";
        // Thank you note
        $thankYou = "\n\n🙏 *Thank you for being with us!* 🙏";
        $today = Carbon::today();
        $promos = PromotionalMessage::where('is_active', true)
            ->where(function ($q) use ($today) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', $today);
            })
            ->where(function ($q) use ($today) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', $today);
            })
            ->get();
        // $promoMessage = !empty($promo) ? $promo->message : '';
        // $position = $promo?->position ?? 'top';

        // switch ($position) {
        //     case 'top':
        //         $finalMessage = $promoMessage . "\n\n" . $transactionMessage;

        //     case 'middle':
        //         $finalMessage = $promoMessage . "\n\n" . $transactionMessage;

        //     case 'bottom':
        //         $finalMessage = $transactionMessage . "\n\n" . $promoMessage;

        //     default:
        //         $finalMessage = $transactionMessage;
        // }

        $positions = ['top', 'middle', 'bottom', 'end'];

        $finalMessage = '';

        foreach ($positions as $position) {
            $messages = $promos->where('position', $position)->pluck('message')->toArray();
            $messagesText = implode("\n\n", $messages);

            if ($position === 'top' && !empty($messagesText)) {
                $finalMessage .= $messagesText . "\n\n";
            }

            if ($position === 'middle') {
                $finalMessage .= $transactionMessage . "\n\n";
                if (!empty($messagesText)) {
                    $finalMessage .= $messagesText . "\n\n";
                }
            }

            if ($position === 'bottom' && !empty($messagesText)) {
                $finalMessage .= $messagesText . "\n\n";
            }

            if ($position === 'end' && !empty($messagesText)) {
                $finalMessage .= $messagesText . "\n\n";
            }
        }
        $finalMessage = $greeting . $finalMessage . $thankYou;
        return $finalMessage;
    }
    public static function generateActivity() {}
}
