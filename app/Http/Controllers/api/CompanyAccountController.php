<?php

namespace App\Http\Controllers\api;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\CompanyAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyAccountController extends Controller
{
    /**
     * ACCOUNTS_LISTING
     */
    public function index(Request $request)
    {
        $accounts = CompanyAccount::query()
            ->where('company_id', $request->company_id)
            ->get();
        Helper::sendResponse('Accounts fetched successfully', 1, $accounts);
    }

    /**
     * ADD_BANK_ACCOUNT
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|integer',
            'account_holder_name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'account_type' => 'required|string|max:100',
            'opening_balance' => 'required|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        DB::beginTransaction();

        try {

            $account = CompanyAccount::create([
                'company_id' => $request->company_id,
                'account_holder_name' => $request->account_holder_name,
                'bank_name' => $request->bank_name,
                'account_type' => $request->account_type,
                'opening_balance' => $request->opening_balance,
                'current_balance' => $request->opening_balance,
                'is_active' => $request->is_active ?? true,
            ]);

            DB::commit();

            return Helper::sendResponse('Bank account created successfully', 1);
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return Helper::sendResponse($e->getMessage(),500);
            
        }
    }

    /**
     * UPDATE_BANK_ACCOUNT
     */
    public function update(Request $request, $id)
    {
        $account = CompanyAccount::findOrFail($id);

        $request->validate([
            'account_holder_name' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'account_type' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        $account->update($request->only([
            'account_holder_name',
            'bank_name',
            'account_type',
            'is_active'
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Bank account updated successfully',
            'data' => $account
        ]);
    }

    /**
     * BANK_ACCOUNT_DETAIL
     */
    public function show($id)
    {
        $account = CompanyAccount::with([
            'transactions'
        ])->findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Account detail fetched successfully',
            'data' => $account
        ]);
    }

    /**
     * BANK_ACCOUNT_TRANSACTIONS
     */
    public function transactions(Request $request, $id)
    {
        $account = CompanyAccount::findOrFail($id);

        $transactions = $account->transactions()
            ->latest('id')
            ->paginate(20);

        return response()->json([
            'status' => true,
            'message' => 'Transactions fetched successfully',
            'data' => $transactions
        ]);
    }
}
