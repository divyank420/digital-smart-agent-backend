<?php

namespace App\Http\Controllers\api;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\RmMonthlyAmountHistory;
use App\Models\SavingExpenses;
use App\Models\SavingRm;
use App\Models\SavingCustomer;
use App\Models\SavingRmEntries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class RmController extends Controller
{
    public function newRm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'               => 'required',
            'mobile'             => 'required|digits:10',
            'account_type'       => 'required',
            'monthly_amount'     => 'required|integer',
            'installment_amount' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return Helper::sendResponse(Helper::ValidationSet($validator->errors()), 422);
        }

        DB::beginTransaction();

        try {
            $customer = SavingCustomer::firstOrCreate(
                ['mobile' => $request->mobile],
                [
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'password' => Hash::make('user@123'),
                ]
            );

            if ($customer->wasRecentlyCreated) {
                $customer->rm_code = 'RM' . str_pad($customer->id, 6, "0", STR_PAD_LEFT);
                $customer->save();
            }

            $user = Auth::user();

            $rmData = SavingRm::create([
                'name'               => ucwords($request->name),
                'company_id'         => $user->company_id,
                'agent_id'           => $user->id,
                'customer_id'        => $request->customer_id,
                'account_type'       => $request->account_type,
                'monthly_amount'     => $request->monthly_amount,
                'installment_amount' => $request->installment_amount,
                'opening_month'      => $request->opening_month ?? date('m'),
                'opening_year'       => $request->opening_year ?? date('Y'),
                'opening_balance'    => $request->opening_balance ?? 0,
            ]);

            $rmData->rm_code = 'RM' . str_pad($rmData->id, 6, "0", STR_PAD_LEFT);
            $rmData->save();

            DB::commit();

            return Helper::sendResponse("RM Successfully Added", 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return Helper::sendResponse($th->getMessage(), 500);
        }
    }

    public function rmDetail(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $validator = Validator::make($request->all(), [
            'rm_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            $error = Helper::ValidationSet($validator->errors());
        }
        $rmData = SavingRm::with('customer')->where(['id' => $request->rm_id, 'company_id' => $company_id])->first();
        if (!empty($rmData)) {
            Helper::sendResponse("Rm Detail", 1, $rmData);
        }
    }

    public function editRm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rm_id' => 'required|integer',
            'name' => 'required',
            'mobile' => 'required',
            'account_type' => 'required',
            'opening_balance' => 'required|integer',
        ]);
        if ($validator->fails()) {
            $error = Helper::ValidationSet($validator->errors());
        }

        /* Customer Detail Save */

        $rmData = SavingRm::find($request->rm_id);

        $customer = SavingCustomer::where('mobile', $request->mobile)->first();
        if (!empty($customer)) {
            $rmData->customer_id = $customer->id;
        } else {
            $customer = SavingCustomer::find($request->customer_id);
            if ($customer->mobile != '') {
                $customer->mobile = $request->mobile;
            }
            if ($customer->email != '') {
                $customer->email = $request->email;
            }
            $customer->save();
        }

        $rmData->name = $request->name;
        $rmData->account_type = $request->account_type;
        $rmData->opening_balance = $request->opening_balance;
        $rmData->opening_month = $request->opening_month;
        $rmData->opening_year = $request->opening_year;


        if ($rmData->save()) {
            Helper::sendResponse("Update rm detail Successfully", 1);
        }
    }
    public function deleteRm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            $error = Helper::ValidationSet($validator->errors());
        }
        $rmData = SavingRm::find($request->id);
        if (!empty($rmData)) {
            if (File::exists(public_path('rm/qrcodes/' . $rmData->qr_code))) {
                File::delete(public_path('rm/qrcodes/' . $rmData->qr_code));
            }
            //$rmData->forceDelete();
            $rmData->delete();
        }
        Helper::sendResponse("Rm Successfully Deleted", 1);
    }
    public function getRmList(Request $request)
    {

        try {
            $type = $request->type ?? 'daily';
            $user = Auth::user();
            $rmList = SavingRm::with('customer')->orderBy('name', 'ASC');
            if (!empty($request->type)) {
                $rmList = $rmList->where(['account_type' => $type]);
            }
            if (isset($request->search)) {
                $rmList = $rmList->whereHas('customer', function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->search . '%');
                });
            }
            $rmList = $rmList->where('company_id', $user->company_id);
            $totalPage = 0;
            if (isset($request->fetch_from) && !empty($request->fetch_from)) {
                if (isset($request->page) && !empty($request->page)) {
                }
                $rmList = $rmList->paginate('15');
                $totalPage = $rmList->lastPage();
                $rmList = $rmList->map(function ($rmList) {
                    return $rmList->formatData();
                });
            } else {
                $rmList = $rmList->get();
                $rmList = $rmList->map->formatData();
            }
            Helper::sendResponse("Rm List", 1, $rmList, ['totalPage' => $totalPage]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            Helper::sendResponse($th->getMessage());
        }
    }
    public function getEntriesList(Request $request)
    {
        $requestData = $request->all();
        try {
            $user = Auth::user();
            $currentDate = date('Y-m-d');
            $entry_date = $currentDate;
            if (isset($requestData['entry_date']) && !empty($requestData['entry_date'])) {
                $entry_date = date('Y-m-d', strtotime($requestData['entry_date']));
            }
            $entriesQuery = SavingRmEntries::with(['RmDetail', 'Agent'])->whereDate('entry_date', $entry_date)->where('company_id', $user->company_id);
            $expences = SavingExpenses::with('Agent')->whereDate('created_at', $entry_date)->where('expenses_type', 'Others');
            $denominationStatus = 1;

            $user = Auth::user();

            if ($entry_date == $currentDate && isset($request->user_id)) {
                $role = Helper::getUserRole($request->user_id);
                if (!in_array($role, ['Developer'])) {
                    /*$count = Helper::CheckDenominationAddedOrNot($request->user_id);
                    if($count == 0){
                        $entriesList = $entriesList->where('user_id','!=',$request->user_id);
                        $denominationStatus = 0;
                    }*/
                }
            }
            // always include soft-deleted entries
            $entriesQuery = $entriesQuery->withTrashed();

            if (isset($request->agent_id) && $request->agent_id != 0) {
                $entriesQuery = $entriesQuery->where(['user_id' => $request->agent_id]);
                $expences = $expences->where('user_id', $request->agent_id);
            } else if ($user->role != 'Developer') {
                $entriesQuery = $entriesQuery->where(['user_id' => $request->user_id]);
                $expences = $expences->where('user_id', $request->user_id);
            }
            $entriesList = $entriesQuery->orderBy('created_at', 'DESC')->get()->map->formatData()->toArray();
            $expences = $expences->get()->map->formatData()->toArray();
            if (!empty($entriesList) || !empty($expences)) {
                Helper::sendResponse('Entry List', 1, ['entry_list' => $entriesList, 'expences' => $expences], ['denominationStatus' => $denominationStatus]);
            } else {
                Helper::sendResponse('No Record Found', 0, [], ['denominationStatus' => $denominationStatus]);
            }
        } catch (\Throwable $th) {
            Helper::sendResponse('line:' . $th->getLine() . ', error:' . $th->getMessage());
        }
    }
    public function getEntriesReportList(Request $request)
    {
        try {
            $entry_date = $request->entry_date ? date('Y-m-d', strtotime($request->entry_date)) : date('Y-m-d');
            $user = Auth::user();
            $user_id = $request->user_id ?? $user->user_id;

            $entriesList = SavingRmEntries::with(['RmDetail', 'Agent'])->whereDate('entry_date', $entry_date)->where('company_id', $user->company_id);

            // always include soft-deleted records
            $entriesList = $entriesList->withTrashed();

            if ($request->user_id != '' && $user->role != 'Developer') {
                $entriesList = $entriesList->where('user_id', $user_id);
            }
            if (!empty($request->entry_type)) {
                $entriesList = $entriesList->where('entry_type', $request->entry_type);
            }
            $totalPenalty = 0;
            if (!empty($request->amount_type)) {
                $entriesList = $entriesList->where('amount_type', $request->amount_type);
            } else {
                //$totalPenalty = $entriesList->where('entry_type','penalty')->sum('amount');
            }

            $totalAmount = $entriesList->clone()->sum('amount');
            $totalTrashedAmount = $entriesList->clone()->whereNotNull('deleted_at')->sum('amount');

            $entriesList = $entriesList->orderBy('created_at', $request->sort ?? 'desc');
            $entriesList = $entriesList->get()->map->formatData()->toArray();
            if (!empty($entriesList)) {
                Helper::sendResponse('Entry List', 1, ['entry_list' => $entriesList, 'total_amount' => $totalAmount, 'total_trashed_amount' => $totalTrashedAmount, 'default' => $totalPenalty]);
            } else {
                Helper::sendResponse('No Record Found', 0);
            }
        } catch (\Throwable $th) {
            Helper::sendResponse($th->getMessage());
        }
    }
    public function getRmEntries(Request $request)
    {
        try {
            $month = $request->month ?? date('m');
            $year = $request->year ?? date('Y');
            $rmEntries = SavingRmEntries::with(['RmDetail', 'Agent'])->where(['rm_id' => $request->rm_id]);
            $rmEntries = $rmEntries->where(['payment_month' => intval($month), 'payment_year' => intval($year)]);
            $totalAmount = $rmEntries->sum('amount');
            $rmEntries = $rmEntries->orderBy('entry_date', 'DESC')->get()->map->formatData()->toArray();
            if (!empty($rmEntries)) {
                Helper::sendResponse('Entry List', 1, $rmEntries, ['total_amount' => $totalAmount]);
            } else {
                Helper::sendResponse('No Record Found', 1, [], ['total_amount' => $totalAmount]);
            }
        } catch (\Throwable $th) {
            Helper::sendResponse($th->getMessage());
        }
    }
    public function getLastEntry(Request $request, $rmId = null)
    {
        if (empty($rmId)) {
            $rmId = $request->rm_id;
        }
        try {
            $entrySetup = Helper::getLastEntry($rmId);
            if (!empty($entrySetup)) {
                Helper::sendResponse('Last Entry Data', 1, $entrySetup);
            } else {
                Helper::sendResponse('No Record Found');
            }
        } catch (\Throwable $th) {
            //throw $th;
            echo $th->getMessage();
        }
    }
    public function getNewRmCode()
    {
        try {
            $lastId = SavingCustomer::latest()->first();
            $rmId = 'RM000001';
            if (!empty($lastId)) {
                $rmId = 'RM' . str_pad($lastId->id + 1, 6, "0", STR_PAD_LEFT);
            }
            Helper::sendResponse('Last Entry Data', 200, ['rm_code' => $rmId]);
        } catch (\Throwable $th) {
            //throw $th;
            echo $th->getMessage();
        }
    }
    public function getPendingAccountsList(Request $request)
    {
        $limit = 15;
        $skip = 0;
        $search = '';
        if (isset($request->page) && !empty($request->page)) {
            $skip = $limit * ($request->page - 1);
        }
        if (isset($request->search) && !empty($request->search)) {
            $search = $request->search;
        }
        $entry = SavingRm::leftJoin('saving_rm_entries', function ($join) {
            $join->on('saving_rm_entries.rm_id', '=', 'saving_rms.id')
                ->where('saving_rm_entries.payment_month', '=', date('m'))
                ->where('saving_rm_entries.payment_year', '=', date('Y'));
        })
            ->select('saving_rm_entries.rm_id', 'saving_rms.name', 'saving_rm_entries.amount', 'monthly_amount', 'rm_code', DB::raw('CAST(COALESCE(SUM(saving_rm_entries.amount), 0) AS INT) as total_amount'))
            ->where('saving_rms.monthly_amount', '>', 0);
        if (!empty($search)) {
            $entry = $entry->where('saving_rms.name', 'LIKE', '%' . $search . '%');
        }
        $entry = $entry->groupBy('saving_rms.id')
            ->havingRaw('COALESCE(SUM(saving_rm_entries.amount), 0) < saving_rms.monthly_amount')
            ->orderBy('saving_rms.name', 'asc');

        $totalRecord = $entry->sum('total_amount');
        $totalPage = $totalRecord / $limit;
        $totalPage = ($totalPage) > 0 ? $totalPage : 1;
        $entry = $entry->take($limit)->skip($skip)->get();
        if ($entry->count() > 0) {
            sendResponse('Pending Records', 1, $entry, ['total_record' => $totalRecord, 'total_page' => $totalPage]);
            //sendResponse('Pending Records',1, $entry,['total_record'=>$totalRecord,'total_page'=>5]);
        }
        sendResponse('No Data Found');
    }

    public function rmYearlySummary(Request $request)
    {
        $year = $request->year ?? date('Y');
        $rmId = $request->rm_id;

        // deposits grouped by month
        $entries = SavingRmEntries::select(
            'payment_month',
            DB::raw("SUM(amount) as amount")
        )
            ->where('rm_id', $rmId)
            ->where('payment_year', $year)
            ->groupBy('payment_month')
            ->pluck('amount', 'payment_month');

        // RM
        $rm = SavingRm::find($rmId);

        // history
        $history = $rm->monthlyAmountHistory;

        $result = [];

        for ($month = 1; $month <= 12; $month++) {

            $expectedAmount = Helper::resolveMonthlyAmount(
                $history,
                $rm->getRawOriginal('monthly_amount'),
                $month,
                $year
            );

            $deposit = $entries[$month] ?? 0;

            $result[] = [
                'payment_month' => $month,
                'monthly_amount' => $expectedAmount,
                'amount' => (int)$deposit,
                'remaining' => $expectedAmount - $deposit
            ];
        }

        return Helper::sendResponse("Yearly Report", 1, $result);
    }

    public function saveRmMonthlyAmountHistory(Request $request)
    {

        if (isset($request->id) && !empty($request->id)) {
            $record = RmMonthlyAmountHistory::find($request->id);
            if ($record) {
                $record->update([
                    'rm_id' => $request->rm_id,
                    'effective_month' => $request->effective_month,
                    'effective_year' => $request->effective_year,
                    'monthly_amount' => $request->monthly_amount,
                    'installment_amount' => $request->installment_amount,
                    'status' => $request->status,
                ]);
            }
        } else {
            $record = RmMonthlyAmountHistory::create([
                'rm_id' => $request->rm_id,
                'effective_month' => $request->effective_month,
                'effective_year' => $request->effective_year,
                'monthly_amount' => $request->monthly_amount,
                'installment_amount' => $request->installment_amount
            ]);
        }
        return Helper::sendResponse('Monthly Amount successfully save', 1, $record);
    }


    public function fetchRmMonthlyAmountHistory(Request $request)
    {
        $history = Helper::getEffectiveMonthlyAmount($request->rm_id, null, null, 'all', false);
        return Helper::sendResponse('Rm Monthly History', 1, $history);
    }
}
