<?php

namespace App\Http\Controllers\api\Customer;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\FcmToken;
use App\Models\RmUpiCollectionRequest;
use App\Models\SavingRm;
use App\Models\SavingRmEntries;
use App\Models\User;
use App\Services\FcmTokenService;
use App\Services\RmPaymentSummaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CustomersController extends Controller
{

    public $user;

    public function __construct()
    {
        $this->user = Auth::guard('customer')->user();
    }

    public function dashboard(Request $request)
    {
        $rms_accounts = SavingRm::where('customer_id', $this->user->id)->pluck('id');
        //Helper::pushNotification($this->user,'Hello',"tetse");
        $accounts_total = SavingRmEntries::with(['RmDetail:id,name,rm_code,monthly_amount,installment_amount,account_type,opening_balance,opening_month,opening_year,status'])->select([
            'rm_id',
            DB::raw('SUM(amount) as account_total'),
        ])->whereIn('rm_id', $rms_accounts)->groupBy('rm_id')->get();
        $recent_entries = SavingRmEntries::with('RmDetail:id,name')->whereIn('rm_id', $rms_accounts)->limit(5)->latest()->get();
        $data = [
            'accounts_total' => $accounts_total,
            'recent_entries' => $recent_entries,
        ];

        return Helper::sendResponse("Dashboard Data", 1, $data);
    }

    public function getRmAccounts(Request $request)
    {
        $rms = SavingRm::where('customer_id', $request->customer_key);
        if (isset($request->search) && !empty($request->search)) {
            $rms = $rms->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $rms = $rms->get();
        $summaries = app(RmPaymentSummaryService::class)
            ->getSummary($rms->pluck('id')->toArray(), true);
        $data = $rms->map(function ($rm) use ($summaries) {
            $arr = [
                'id' => $rm->id,
                'company_id' => $rm->company_id,
                'rm_code' => $rm->rm_code,
                'name' => $rm->name,
                'account_type' => $rm->account_type,
                'monthly_amount' => $rm->monthly_amount,
                'installment_amount' => $rm->monthly_amount,
                'opening_month' => $rm->opening_month,
                'opening_year' => $rm->opening_year,
                'opening_balance' => $rm->opening_balance,
                'status' => $rm->status,
            ];
            return array_merge($arr, $summaries[$rm->id] ?? []);
        });

        Helper::sendResponse('Rm Accounts', 1, $data);
    }

    public function getRmDetail(Request $request)
    {
        $request->validate(['rm_id' => 'required|integer']);
        $rm = SavingRm::with(['company'])->where('id', $request->rm_id)->first();
        $lastEntry = Helper::getLastEntry($rm->id);
        $data = ['rm_data' => $rm, 'payment_summary' => $lastEntry];
        Helper::sendResponse('Rm Detail', 1, $data);
    }

    public function createCollectionRequest(Request $request)
    {

        $validated = $request->validate([
            'customer_id' => ['required', 'integer'],
            'rm_id'       => ['required', 'integer', 'exists:saving_rms,id'],
            'upi_id'      => ['required', 'string', 'max:255'],
            'amount'      => ['required', 'numeric', 'min:0.01'],
            'screenshot'  => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $rm = SavingRm::findOrFail($validated['rm_id']);

        $screenshotPath = $request->hasFile('screenshot')
            ? $request->file('screenshot')->store('upi-collection-screenshots', 'public')
            : null;

        // 1. Create the record FIRST
        $collectionRequest = RmUpiCollectionRequest::create([
            'company_id'      => $rm->company_id,
            'customer_id'     => $rm->customer_id ?? $validated['customer_id'],
            'rm_id'           => $rm->id,
            'amount'          => $validated['amount'],
            'payee_upi_id'    => $validated['upi_id'],
            'screenshot_path' => $screenshotPath,
        ]);

        $userIds = User::where('company_id', $rm->company_id)->pluck('id');

        $tokens = FcmToken::where('tokenable_type', User::class)
            ->whereIn('tokenable_id', $userIds)
            ->pluck('token')
            ->toArray();

        // 3. Send notification safely with stringified data payload
        if (!empty($tokens)) {
            try {
                $formattedAmount = number_format((int) $validated['amount']);
                $title = 'New UPI Collection Request';
                $body = "{$rm->name} raised a new collection request of ₹{$formattedAmount}.";

                $notificationData = [
                    'type'                  => 'upi_collection_request',
                    'collection_request_id' => (string) $collectionRequest->id,
                    'rm_id'                 => (string) $rm->id,
                    'amount'                => (string) $validated['amount'],
                ];

                app(FcmTokenService::class)->sendToModel(
                    $tokens,
                    $title,
                    $body,
                    $notificationData
                );
            } catch (\Throwable $e) {
                Log::error('FCM send failed for collection request #' . $collectionRequest->id, [
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $data = $collectionRequest->load(['savingRm', 'savingCustomer', 'savingCompany']);

        return Helper::sendResponse('Collection request created successfully.', 1, $data);
    }

    public function getCustomerCollectionRequests(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => ['nullable', 'integer'],
            'status' => ['nullable', 'string', 'max:50'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $requests = RmUpiCollectionRequest::query()
            ->with(['savingRm', 'savingCustomer', 'savingCompany'])
            ->when(!empty($validated['company_id']), function ($query) use ($validated) {
                $query->where('company_id', $validated['company_id']);
            })
            ->when(!empty($validated['customer_id']), function ($query) use ($validated) {
                $query->where('customer_id', $validated['customer_id']);
            })
            ->when(!empty($validated['rm_id']), function ($query) use ($validated) {
                $query->where('rm_id', $validated['rm_id']);
            })
            ->when(!empty($validated['status']), function ($query) use ($validated) {
                $query->where('status', $validated['status']);
            })
            ->latest()
            ->paginate($validated['per_page'] ?? 15);

        // Attach full accessible URL for each screenshot
        $requests->getCollection()->transform(function ($item) {
            $item->screenshot_url = $item->screenshot_path
                ? Storage::disk('public')->url($item->screenshot_path)
                : null;

            return $item;
        });

        Helper::sendResponse('Collection requests fetched successfully.', 1, $requests);
    }
}
