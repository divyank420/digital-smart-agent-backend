<?php

namespace App\Http\Controllers\api\Dop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DopAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DopAccountSyncController extends Controller
{
    /**
     * Optimized Bulk Sync Engine for India Post (DoP) Accounts
     * Processes datasets in RAM using O(1) lookups and single-hit Database Upserts
     */
    public function syncRecords(Request $request)
    {

        Log::info('=== [PRODUCTION OPTIMIZED BULK SYNC RUNNING] ===', $request->all());

        // 1. Extract and validate payload wrapper arrays
        $incomingDataChunks = $request->input('data', []);
        if (empty($incomingDataChunks)) {
            return response()->json(['status' => 'error', 'message' => 'Empty deployment package payload.'], 400);
        }

        $companyId = $request->input('company_id', 1);
        $timestamp = now()->toDateTimeString();

        // 2. Ultra-Fast Memory Mapping (Prevents N+1 SELECT loops inside the foreach block)
        // Keying the collection by account_no creates an O(1) hash map lookup
        $existingAccounts = DopAccount::where('company_id', $companyId)
            ->select('account_no', 'sort_code')
            ->get()
            ->keyBy('account_no')
            ->toArray();

        // 3. Isolated Company Sequence Engine
        // Pulls the highest numeric sort_code currently assigned to this company (Defaults to 0)
        $maxSortCode = (int) DopAccount::where('company_id', $companyId)
            ->whereRaw('sort_code REGEXP "^[0-9]+$"')
            ->max(DB::raw('CAST(sort_code AS UNSIGNED)'));

        $bulkInsertPayload = [];

        // 4. Data Extraction and Transformation Loop (Executed entirely in RAM)
        foreach ($incomingDataChunks as $item) {
            $fields = $item['dataFields'] ?? [];

            // Skip structural noise lines, empty arrays, or table header titles
            if (count($fields) < 5 || str_contains($fields[1], 'Account No')) {
                continue;
            }

            $accountNumber = trim($fields[1] ?? '');
            if (empty($accountNumber)) {
                continue;
            }

            // Clean currency configurations and extract plain values
            $monthlyAmount = $this->parseCleanNumeric($fields[3] ?? 0);
            $paidCount     = intval($fields[4] ?? 0);
            $nextDueDate   = trim($fields[5] ?? null);

            // Calculate calendar tracking benchmarks dynamically using reverse math
            $openingDate   = $this->calculateOpeningDate($nextDueDate, $paidCount);
            $lastDeposit   = $this->calculateLastDepositDate($nextDueDate);
            $maturityDate  = $this->calculateMaturityDate($openingDate);

            // Manage continuous Sort Code sequence constraints
            if (isset($existingAccounts[$accountNumber])) {
                // Keep the original sort_code if the account is already registered
                $assignedSortCode = $existingAccounts[$accountNumber]['sort_code'];
            } else {
                // Increment sequentially for new arrivals
                $maxSortCode++;
                $assignedSortCode = (string) $maxSortCode;
            }

            $bulkInsertPayload[] = [
                'company_id'             => $companyId,
                'account_no'             => $accountNumber,
                'account_name'           => trim($fields[2] ?? 'Unknown Name'),
                'sort_code'              => $assignedSortCode,
                'monthly_amount'         => $monthlyAmount,
                'account_opening_date'   => $openingDate,
                'total_paid_installment' => $paidCount,
                'last_deposit_date'      => $lastDeposit,
                'maturity_date'          => $maturityDate,
                'maturity_status'        => 'Active',
                'created_at'             => $timestamp,
                'updated_at'             => $timestamp,
            ];
        }

        if (empty($bulkInsertPayload)) {
            return response()->json(['status' => 'success', 'message' => 'Zero operational records parsed.'], 200);
        }

        // 5. Database Commit Execution (Single transactional query chunk block)
        try {
            DB::transaction(function () use ($bulkInsertPayload) {
                // Chunks at 250 records to stay safely below maximum SQL parameter limit constraints
                foreach (array_chunk($bulkInsertPayload, 250) as $chunk) {
                    DopAccount::upsert(
                        $chunk,
                        ['account_no'], // Unique column index matching target keys
                        [
                            'account_name',
                            'sort_code',
                            'monthly_amount',
                            'account_opening_date',
                            'total_paid_installment',
                            'last_deposit_date',
                            'maturity_date',
                            'updated_at'
                        ] // Shifting metric updates applied when matching duplicates
                    );
                }
            });

            Log::info('🎉 [SYNC SUCCESS] Processed database tracking operations count: ' . count($bulkInsertPayload));

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully processed and bulk upserted ' . count($bulkInsertPayload) . ' records.'
            ], 200);
        } catch (\Exception $ex) {
            Log::error('Fatal Database Transaction Failure: ' . $ex->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Backend database commit layer failure.'], 500);
        }
    }

    /**
     * Helper: Safely converts formatted banking strings (e.g., "12,000.00 Cr.") to true float decimals.
     */
    private function parseCleanNumeric($value)
    {
        if ($value === null || trim($value) === '' || trim($value) === '-') {
            return 0.00;
        }

        try {
            // Remove commas first
            $cleanString = str_replace(',', '', trim($value));
            // Remove all letters and special symbols except digits, dot, and minus
            $cleanString = preg_replace('/[^0-9.\-]/', '', $cleanString);
            // Remove trailing dots (e.g. "6000.00.")
            $cleanString = rtrim($cleanString, '.');

            Log::info('=== [Pricing SYNC RUNNING] ===', [
                'original' => $value,
                'cleaned'  => $cleanString,
                'numeric'  => is_numeric($cleanString),
            ]);

            return is_numeric($cleanString)
                ? round((float) $cleanString, 2)
                : 0.00;
        } catch (\Exception $e) {
            Log::error('Fatal price Failure: ' . $e->getMessage());

            return 0.00;
        }
    }

    /**
     * Helper: Computes original Opening Date based on payment status fields.
     * Formula: Next Due Date - 1 Month - Total Paid Installments Months
     */
    private function calculateOpeningDate($nextDueDateString, $monthsPaid)
    {
        if (!$nextDueDateString || trim($nextDueDateString) == "" || trim($nextDueDateString) == "-") {
            return null;
        }
        try {
            $nextDue = Carbon::parse(trim($nextDueDateString));
            return $nextDue->subMonth()->subMonths($monthsPaid)->format('Y-m-d');
        } catch (\Exception $e) {
            Log::error('Date Calculation Processing Exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Helper: Calculates approximation for the Last Deposit Date.
     */
    private function calculateLastDepositDate($nextDueDateString)
    {
        if (!$nextDueDateString || trim($nextDueDateString) == "" || trim($nextDueDateString) == "-") {
            return null;
        }
        try {
            return Carbon::parse(trim($nextDueDateString))->subMonth()->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Helper: Extrapolates standard India Post 5-Year (60 Months) RD Maturity Targets.
     */
    private function calculateMaturityDate($openingDateString)
    {
        if (!$openingDateString) {
            return null;
        }
        try {
            return Carbon::parse($openingDateString)->addYears(5)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
