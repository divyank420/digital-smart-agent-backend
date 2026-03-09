<?php

namespace App\Http\Controllers\api;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\CompanyAccount;
use App\Models\SavingRm;
use App\Models\SavingRmEntries;
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

        $entry = SavingRmEntries::where('id', $request->id)->first();
        if (!empty($entry)) {
            sendResponse('Entry Detail', 1, $entry);
        } else {
            sendResponse();
        }
    }
    public function rmInstallmentEntry(Request $request){
        $requestData = $request->all();
        try {
            $rmDetail = SavingRm::with('customer')
                ->where('id', $request->rm_id)
                ->first();
            if (!empty($rmDetail)) {
                $user = Auth::user();
                $company_id = $user->company_id;
                $requestData['company_id'] = $company_id;
                $requestData['entry_date'] = $request->entry_date
                    ? date('Y-m-d', strtotime($request->entry_date))
                    : date('Y-m-d');
                $requestData['payment_month'] = $request->payment_month;
                if ($request->amount_type === 'online' && $request->account) {
                    $account = CompanyAccount::where('id', $request->account)
                        ->where('company_id', $user->company_id)
                        ->firstOrFail();
                    $requestData['account_id'] = (int)$request->account ?? null;
                }
                /* ---------------- MONTH CALCULATIONS ---------------- */

                $deposits = (object)Helper::getRmPaymentSummary($request->rm_id);

                $lastMonthDeposit = $deposits->last_month_deposit ?? 0;
                $currentMonthDeposit = $deposits->current_month_deposit ?? 0;

                $monthlyAmount = $rmDetail->monthly_amount;
                /* ---------------- STATUS ---------------- */
                $isLastMonthDepositStatus = $lastMonthDeposit >= $monthlyAmount?true:false;
                $lastMonthStatus = $isLastMonthDepositStatus? "Completed ✅": "Pending ❌";
                
                $currentRemaining = $monthlyAmount - $currentMonthDeposit;
                $currentRemaining = $currentRemaining < 0 ? 0 : $currentRemaining;
                /* ---------------- MESSAGE ---------------- */
                $message = "Your *RD* amount has been successfully deposited at Khatod Saving House.\n\n";

                $message .= "*Date*: " . date('d l, Y', strtotime($requestData['entry_date'])) . " 📅\n";
                $message .= "*Amount*: " . amountFormat($request->amount) . " 💰\n\n";
                if(!$isLastMonthDepositStatus){
                    $message .= "*Last Month Status*: {$lastMonthStatus}\n\n";
                    $message .= "*Note:* If you have already deposited the full amount for last month, please contact your agent for confirmation.\n";
                }else{
                    $message .= "*Current Month Remaining Balance*: " . amountFormat($currentRemaining) . " 💰";
                }
                $message = Helper::transactionWithPromotionalMessage($rmDetail->name, $message);

                /* ---------------- WHATSAPP URL ---------------- */
                $encodedMessage = urlencode($message);
                $mobileNo = $rmDetail->customer->mobile;
                $mobileNo = $user->role == 'Developer' ? '7665629201' : $mobileNo;
                $redirect_url = "https://wa.me/91{$mobileNo}/?text=" . $encodedMessage;
                $data = ['redirect_url' => $redirect_url];
                /* ---------------- SAVE ENTRY ---------------- */
                SavingRmEntries::create($requestData);
                Helper::sendResponse("Entry Successfully entered", 1, $data);
            } else {
                Helper::sendResponse("Customer Not found", 0);
            }
        } catch (\Throwable $th) {
            Helper::sendResponse($th->getMessage());
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
                if ($entry->trashed() && !$request->boolean('is_force_delete')) {
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
