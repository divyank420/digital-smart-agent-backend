<?php



namespace App\Helper;

use App\Models\CompanyAccount;
use App\Models\PromotionalMessage;
use App\Models\RmMonthlyAmountHistory;
use Illuminate\Support\Facades\DB;
use Image;
use App\Models\SavingDenomination;
use App\Models\SavingRm;
use App\Models\SavingRmEntries;
use App\Models\SavingExpenses;
use App\Models\SavingCompany;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

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

        $summary = self::getRmPaymentSummary($rmId, true);

        if (!empty($entryData)) {
            $lastEntryData = ['entry_date' => date('d-M-Y', strtotime($entryData->created_at)), 'amount' => $entryData->amount];
        }
        $entrySetup = [
            'last_entry_data' => $lastEntryData ?? []
        ];
        return array_merge($entrySetup, $summary);
    }
    public static function getRmPaymentSummary($rmId, $isLastEntry = false)
    {
        $now = now();
        $currentMonth = (int)$now->month;
        $currentYear = (int)$now->year;
        $lastMonth = (int)$now->copy()->subMonth()->month;
        $lastYear = (int)$now->copy()->subMonth()->year;
        $nextMonth = (int)$now->copy()->addMonth()->month;
        $nextYear = (int)$now->copy()->addMonth()->year;

        $rowData = SavingRmEntries::leftJoin('saving_rms', 'rm_id', '=', 'saving_rms.id')
            ->where('rm_id', $rmId)
            ->select(
                'rm_id',
                DB::raw('SUM(amount) as total_deposit'),

                DB::raw("
                SUM(CASE 
                    WHEN payment_month = $lastMonth 
                    AND payment_year = $lastYear 
                    THEN amount ELSE 0 
                END) as last_deposit
            "),

                DB::raw("
                SUM(CASE 
                    WHEN payment_month = $currentMonth 
                    AND payment_year = $currentYear 
                    THEN amount ELSE 0 
                END) as current_deposit
            "),

                DB::raw("
                SUM(CASE 
                    WHEN payment_month = $nextMonth 
                    AND payment_year = $nextYear 
                    THEN amount ELSE 0 
                END) as next_month_deposit
            ")
            )
            ->first();
        // deposit values
        $lastDepositAmount = (int)($rowData->last_deposit ?? 0);
        $currentDepositAmount = (int)($rowData->current_deposit ?? 0);
        $nextDepositAmount = (int)($rowData->next_month_deposit ?? 0);

        // load monthly amount history once
        $history = Helper::getEffectiveMonthlyAmount($rmId, null, null, 'all');

        $rm = SavingRm::find($rmId);
        $openMonth = (int)$rm->open_month;
        $openYear = (int)$rm->open_year;

        // resolve monthly amounts
        $previousMonthlyAmount = Helper::resolveMonthlyAmount($history, $rm->monthly_amount, $lastMonth, $lastYear);
        $currentMonthlyAmount = Helper::resolveMonthlyAmount($history, $rm->monthly_amount, $currentMonth, $currentYear);
        $nextMonthlyAmount = Helper::resolveMonthlyAmount($history, $rm->monthly_amount, $nextMonth, $nextYear);

        $trackingMonth = 'current';

        $lastMonthValid = !($lastYear < $openYear || ($lastYear == $openYear && $lastMonth < $openMonth));

        if ($lastMonthValid && ($lastDepositAmount < $previousMonthlyAmount)) {

            $month = $lastMonth;
            $year = $lastYear;
            $remainingAmount = $previousMonthlyAmount - $lastDepositAmount;
            $deposit = $lastDepositAmount;
            $trackingMonth = 'previous';
        } elseif ($currentDepositAmount < $currentMonthlyAmount) {
            $month = $currentMonth;
            $year = $currentYear;
            $remainingAmount = $currentMonthlyAmount - $currentDepositAmount;
            $deposit = $currentDepositAmount;
        } else {
            $month = $nextMonth;
            $year = $nextYear;
            $remainingAmount = $nextMonthlyAmount;
            $deposit = $nextDepositAmount;
            $trackingMonth = 'advance';
        }

        return [
            'month' => $month,
            'year' => $year,
            'last_month' => $lastMonth,
            'last_year' => $lastYear,
            'current_month' => $currentMonth,
            'current_year' => $currentYear,
            'last_month_deposit' => $lastDepositAmount,
            'current_month_deposit' => $currentDepositAmount,
            'deposit_amount' => $deposit,
            'remaining_amount' => $remainingAmount,
            'monthly_amount' => $currentMonthlyAmount,
            'tracking_month' => $trackingMonth
        ];
    }
    public static function getRmPaymentSummary_old($rmId)
    {
        $currentMonth = (int)date('m');
        $currentYear = (int)date('Y');
        $lastMonth = (int)date('m', strtotime(date('Y-m-d') . '-1 month'));
        $lastYear = (int)date('Y', strtotime(date('Y-m-d') . '-1 month'));
        $nextMonth = (int)date('m', strtotime(date('Y-m-d') . '+1 month'));
        $nextYear = (int)date('Y', strtotime(date('Y-m-d') . '+1 month'));

        $rowData = SavingRmEntries::leftJoin('saving_rms', 'rm_id', '=', 'saving_rms.id')
            ->select(
                DB::raw('CAST(sum(amount) as INT) as total_deposit'),
                'monthly_amount',
                DB::raw('SUM(CASE WHEN payment_month = "' . $lastMonth . '" and payment_year = "' . $lastYear . '" THEN amount else 0 END) AS last_deposit'),
                DB::raw('SUM(CASE WHEN payment_month = "' . $currentMonth . '" and payment_year = "' . $currentYear . '" THEN amount else 0 END) AS current_deposit'),
                DB::raw('SUM(CASE WHEN payment_month = "' . $nextMonth . '" and payment_year = "' . $nextYear . '" THEN amount else 0 END) AS next_month_deposit'),
            )->where('rm_id', $rmId)
            ->first();
        $month = (int)date('m');
        $year = (int)date('Y');

        $monthlyAmountHistory = Helper::getEffectiveMonthlyAmount($rowData->rm_id, null, null, 'all');

        $previous_monthly_amount = Helper::resolveMonthlyAmount($monthlyAmountHistory, 0, $lastMonth, $lastYear);
        $monthly_amount = Helper::resolveMonthlyAmount($monthlyAmountHistory, 0, $currentMonth, $currentYear);
        $lastDepositAmount = (int)$rowData->last_deposit;
        $currentDepositAmount = (int)$rowData->current_deposit;
        $nextDepositAmount = (int)$rowData->next_month_deposit;
        $trackingMonth = 'current';
        if ($lastDepositAmount < $previous_monthly_amount) {
            $month = $lastMonth;
            $year = $lastYear;
            $remainingAmount = $previous_monthly_amount - $lastDepositAmount;
            $trackingMonth = 'previous';
            $deposit = $lastDepositAmount;
        } else if ($currentDepositAmount <= $monthly_amount) {
            $month = $currentMonth;
            $year = $currentYear;
            $remainingAmount = $monthly_amount - $currentDepositAmount;
            $deposit = $currentDepositAmount;
        } else {
            $month = $nextMonth;
            $year = $nextYear;
            $remainingAmount = $monthly_amount;
            $trackingMonth = 'advance';
            $deposit = $nextDepositAmount;
        }
        $entrySetup = [
            'last_month' => $lastMonth,
            'last_year' => $lastYear,
            'current_month' => $currentMonth,
            'current_year' => $currentYear,
            'month' => $month,
            'year' => $year,
            'last_month_deposit' => $lastDepositAmount,
            'current_month_deposit' => $currentDepositAmount,
            'deposit_amount' => $deposit,
            'remaining_amount' => $remainingAmount,
            'monthly_amount' => $monthly_amount,
            'tracking_month' => $trackingMonth
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
        $thankYou = "🙏 *Thank you for being with us!* 🙏";
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
    public static function getAccountDetail($accountId, $company_id)
    {
        $account = CompanyAccount::where('id', $accountId)
            ->where('company_id', $company_id)
            ->firstOrFail();
        return $account;
    }

    public static function updateAccountDetail(
        CompanyAccount $account,
        float $amount,
        string $type = 'credit' // credit | debit
    ): void {
        DB::transaction(function () use ($account, $amount, $type) {
            $account->refresh();

            if ($type === 'credit') {
                $account->current_balance += $amount;
            } else {
                $account->current_balance -= $amount;
            }

            $account->save();
        });
    }

    public static function getEffectiveMonthlyAmount($rmId, $month = null, $year = null, $mode = 'single', $active = true)
    {
        // Return all history records
        if ($mode === 'all') {
            $history = RmMonthlyAmountHistory::where('rm_id', $rmId)
                ->orderBy('effective_year')
                ->orderBy('effective_month');
            if ($active) {

                $history = $history->where('status', 1);
            }
            $history = $history->get();
            return $history;
        }

        // Default to current month/year if not provided
        $month = $month ?? date('m');
        $year  = $year ?? date('Y');

        $query = RmMonthlyAmountHistory::where('rm_id', $rmId)
            ->where(function ($q) use ($month, $year) {
                $q->where('effective_year', '<', $year)
                    ->orWhere(function ($q2) use ($month, $year) {
                        $q2->where('effective_year', $year)
                            ->where('effective_month', '<=', $month);
                    });
            })
            ->where('status', 1)
            ->orderByDesc('effective_year')
            ->orderByDesc('effective_month');

        if ($active) {
            $history = $query->where('status', 1);
        }

        // If caller wants query builder
        if ($mode === 'query') {
            return $query;
        }

        // Default: single record
        $change = $query->first();
        if ($change) {
            return $change->monthly_amount;
        }

        return SavingRm::where('id', $rmId)->value('monthly_amount');
    }

    public static function resolveMonthlyAmount($history, $defaultAmount, $month, $year)
    {
        $amount = $defaultAmount;
        foreach ($history as $row) {
            if (
                $row->effective_year < $year ||
                ($row->effective_year == $year && $row->effective_month <= $month)
            ) {
                $amount = $row->monthly_amount;
            }
        }

        return $amount;
    }

    public static function getRmMonthlyAmountHistory($rmId)
    {
        return RmMonthlyAmountHistory::where('rm_id', $rmId)
            ->orderBy('effective_year')
            ->orderBy('effective_month')
            ->get();
    }
    public static function generateShortUrl($url)
    {
        try {
            $response = Http::get("https://tinyurl.com/api-create.php", [
                'url' => $url
            ]);

            return $response->body();
        } catch (\Exception $e) {
            return $url; // fallback
        }
    }

    public static function getCustomerAgentsList($customerId, $type = 'list')
    {
        $companies =  SavingRm::where('customer_id', $customerId)->groupBy('company_id')->pluck('company_id')->toArray();
        $agents = SavingCompany::whereIn('id',$companies)->get();
        return $agents;
    }
}
