<?php

namespace App\Http\Controllers\api;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\CompanyAccount;
use App\Models\SavingRm;
use App\Models\SavingRmEntries;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InstallmentController extends Controller
{
    public function installmentDetail(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'required',
        ], ['id.required' => 'Something went wrong']);

        $entry = SavingRmEntries::with('transaction.account')->where('id', $request->id)->first()->formatData();
        if (!empty($entry)) {
            sendResponse('Entry Detail', 1, $entry);
        } else {
            sendResponse();
        }
    }

    public function rmInstallmentEntry(Request $request)
    {
        $requestData = $request->all();
        try {
            //return DB::transaction(function () use ($request, $requestData) {

            $rmDetail = SavingRm::with('customer')
                ->where('id', $request->rm_id)
                ->first();

            if (empty($rmDetail)) {
                return Helper::sendResponse("Customer Not found", 0);
            }
            $user = Auth::user();
            /* ---------------- BASIC DATA ---------------- */
            $requestData['company_id'] = $user->company_id;

            $requestData['entry_date'] = $request->entry_date
                ? date('Y-m-d', strtotime($request->entry_date))
                : date('Y-m-d');

            $requestData['payment_month'] = $request->payment_month;

            if ($request->amount_type === 'online' && $request->account) {
                CompanyAccount::where('id', $request->account)
                    ->where('company_id', $user->company_id)
                    ->firstOrFail();

                $requestData['account_id'] = (int)$request->account;
            }

            /* ---------------- BEFORE SUMMARY ---------------- */
            $before = (object) Helper::getRmPaymentSummary($request->rm_id);

            /* ---------------- SAVE ENTRY ---------------- */
            DB::transaction(function () use ($request, $requestData, $rmDetail) {

                $entry = SavingRmEntries::create($requestData);

                app(NotificationService::class)->send(
                    $rmDetail->customer,
                    'RD Installment Received',
                    'Your RD installment of ₹' . $request->amount . ' has been successfully deposited.',
                    'rm_installment_entry',
                    [
                        'rm_id' => $request->rm_id,
                        'amount' => $request->amount
                    ]
                );
            });

            if (isset($request->is_whatsapp_message)) {
                
                $sentWhatsappMessage = filter_var($request->is_whatsapp_message, FILTER_VALIDATE_BOOLEAN);
                if (!$sentWhatsappMessage) {
                    return Helper::sendResponse("Entry recorded. WhatsApp message skipped.", 1);
                }
                
            }

            /* ---------------- AFTER SUMMARY ---------------- */
            $after = (object) Helper::getRmPaymentSummary($request->rm_id);

            /* ---------------- ✅ FIXED COMPLETION LOGIC ---------------- */
            $isReportEnable = false;

            if ($before->month != $after->month || $before->year != $after->year) {
                $isReportEnable = true;
                $reportMonth = $before->month;
                $reportYear  = $before->year;
                $reportTitle = date('F Y', strtotime("$reportYear-$reportMonth-01"));
            } elseif ($before->remaining_amount > 0 && $after->remaining_amount == 0) {
                $isReportEnable = true;
                $reportMonth = $after->month;
                $reportYear  = $after->year;
                $reportTitle = date('F Y', strtotime("$reportYear-$reportMonth-01"));
            }
            //dd($isReportEnable, $before, $after);
            /* ---------------- CURRENT STATE ---------------- */

            $remainingAmount = $after->remaining_amount ?? 0;
            $monthlyAmount   = $after->monthly_amount ?? 0;
            $trackingMonth   = $after->tracking_month ?? 'current';
            $month           = $after->month;
            $year            = $after->year;

            /* ---------------- MESSAGE ---------------- */

            $message = "Your *RD* amount has been successfully deposited at Khatod Saving House.\n";
            $message .= "*===============================* \n";
            $message .= "*Transaction* \n";
            $message .= "*Date*: " . date('d l, Y', strtotime($requestData['entry_date'])) . " 📅\n";
            $message .= "*Amount*: " . amountFormat($request->amount) . " 💰\n";
            $message .= "*===============================* \n";
            $monthTitle = date('F Y', strtotime("$year-$month-01"));

            if ($trackingMonth === 'previous') {

                // $message .= "*Running Month*: " . $monthTitle . "\n";
                // $message .= "*Remaining Balance*: " . amountFormat($remainingAmount) . " 💰\n";
                // $message .= "*" . $monthTitle . " Status*: Pending ❌";
            } elseif ($trackingMonth === 'current') {
                if ($remainingAmount > 0) {
                    $message .= "*Running Month*: " . $monthTitle . "\n";
                    $message .= "*Remaining Balance*: " . amountFormat($remainingAmount) . " 💰";
                } else {
                    $message .= "*" . $monthTitle . " Status*: Completed ✅";
                }
            } else {
                $message .= "*Advance Payment For*: " . $monthTitle . "\n";
                $message .= "*Next Installment*: " . amountFormat($monthlyAmount) . " 💰";
            }
            /* ---------------- ✅ REPORT LINK (FIXED) ---------------- */

            if ($isReportEnable) {
                $reportUrl = url('api/rm-current-month-deposit-report') . '?' . http_build_query([
                    'key' => $request->rm_id,
                    'year'  => $reportYear,
                    'month' => $reportMonth
                ]);

                $shortUrl = Helper::generateShortUrl($reportUrl);

                $message .= "\n\n🎉 *" . $reportTitle . " Completed!*\n";
                $message .= "📄 *Deposit History*: " . $shortUrl . " 🔗 \n\n";
                $message .= "⬆️ Click the link above to view your complete *" . $reportTitle . "* deposit history.";
            }

            /* ---------------- FINAL MESSAGE ---------------- */

            $message = Helper::transactionWithPromotionalMessage($rmDetail->name, $message);

            /* ---------------- WHATSAPP ---------------- */

            $encodedMessage = urlencode($message);

            $mobileNo = $rmDetail->customer->mobile;
            $mobileNo = $user->role == 'Developer' ? '7665629201' : $mobileNo;

            $redirect_url = $mobileNo
                ? "https://wa.me/91{$mobileNo}?text=" . $encodedMessage
                : "https://wa.me/?text=" . $encodedMessage;

            return Helper::sendResponse("Entry Successfully entered", 1, [
                'redirect_url' => $redirect_url
            ]);
            //});
        } catch (\Throwable $th) {
            return Helper::sendResponse($th->getMessage(), 0);
        }
    }

    public function editInstallmentEnter(Request $request)
    {
        $requestData = $request->all();
        try {
            $entry = SavingRmEntries::find($request->id);
            $company_id = Auth::user()->company_id;
            $requestData['company_id'] = $company_id;
            if (isset($requestData['entry_date'])) {
                $requestData['entry_date'] = date('Y-m-d', strtotime($requestData['entry_date']));
            }
            if (isset($requestData['payment_month'])) {
                $requestData['payment_month'] = $request->payment_month;
            }
            $entry->fill($requestData);
            $entry->save();
            Helper::sendResponse("Entry Successfully updated", 1);
        } catch (\Throwable $th) {
            Helper::sendResponse($th->getMessage());
        }
    }
    public function deleteInstallment(Request $request)
    {
        try {
            $entry = SavingRmEntries::withTrashed()->where('id', $request->id)->first();
            if (!empty($entry)) {
                if ($entry->trashed() && $request->boolean('is_force_delete')) {
                    $entry = $entry->forceDelete();
                } else {
                    $entry = $entry->delete();
                }
            }
            sendResponse("Entry Successfully deleted", 1, $entry);
        } catch (\Throwable $th) {
            sendResponse($th->getMessage());
        }
    }
    public function restoreInstallment(Request $request)
    {
        try {
            $entry = SavingRmEntries::withTrashed()->find($request->id);
            if (!$entry) {
                return Helper::sendResponse('Entry not found', 0);
            }

            if (!$entry->trashed()) {
                return Helper::sendResponse('Entry is not deleted', 0, $entry);
            }
            $entry->restore();
            $entry = SavingRmEntries::find($request->id);

            return Helper::sendResponse('Entry successfully restored', 1, $entry);
        } catch (\Throwable $th) {
            return Helper::sendResponse($th->getMessage(), 0);
        }
    }
}
