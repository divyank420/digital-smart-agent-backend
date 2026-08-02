<?php

namespace App\Http\Controllers\api;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\CompanyAccount;
use App\Models\DopAgent;
use App\Models\SavingDenomination;
use App\Models\SavingCompany;
use App\Models\SavingCustomer;
use App\Models\SavingExpenses;
use App\Models\SavingFamilyMember;
use App\Models\SavingRm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiController extends Controller
{
    public function register(Request $request)
    {
        $requestData = $request->all();
        try {
            $validator = Validator::make($request->all(), [
                'agent_name' => 'required',
                'name' => 'required',
                'email' => 'required',
                'mobile' => 'required',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                $error = Helper::ValidationSet($validator->errors());
            }
            $requestData['status'] = 1;
            $requestData['role'] = 'Owner';
            $requestData['password'] = Hash::make(str_replace(' ', '', $requestData['password']));
            $requestData['username'] = explode(' ', $requestData['name'])[0];
            $company = SavingCompany::create($requestData);
            $requestData['company_id'] = $company->id;
            $user = User::Create($requestData);
            return sendResponse('Registration Complated.', 200);
        } catch (Exception $e) {
            sendResponse($e->getMessage());
        }
    }

    public function login(Request $request)
    {
        try {
            $guard = 'web';
            $guard = 'users';
            $token = Auth::guard('users')->attempt(['mobile' => $request->mobile, 'password' => $request->password]);
            if (!$token) {
                $guard = 'customer';
                $token = Auth::guard('customer')->attempt(['mobile' => $request->mobile, 'password' => $request->password]);
            }
            try {
                if (! $token) {
                    return sendResponse('Login credentials are invalid.', 400);
                }
            } catch (JWTException $e) {
                return sendResponse($e->getMessage(), 500);
            }

            $user = Auth::guard($guard)->user();
            if ($guard != 'customer') {
                $agent_data = User::where('company_id', $user->company_id)
                    ->whereNotIn('id', [1])
                    ->select('name as label', 'id as value')
                    ->get();

                $agent_lists = $agent_data->prepend([
                    'label' => 'All Agents',
                    'value' => ''
                ])->toArray();

                $dop_agents = DopAgent::select('agent_name as label', 'id as value')
                    ->where('company_id', $user->company_id)
                    ->get();

                if ($dop_agents->count() > 1) {
                    $dop_agents->prepend([
                        'label' => 'All Dop Agents',
                        'value' => ''
                    ]);
                }

                $dop_agents = $dop_agents->toArray();
                $accounts = CompanyAccount::where('company_id', $user->company_id)->where('is_active', true)->get();
                $user->agent_list = $agent_lists;
                $user->accounts = $accounts;
                $user->dop_agents = $dop_agents;
            }
            if ($guard == 'customer') {

                $user->rm_list = SavingRm::select('id', 'name', 'account_type', 'rm_code', 'monthly_amount', 'installment_amount', 'opening_balance')->where('customer_id', $user->id)->get();
                $user->agent_list = Helper::getCustomerAgentsList($user->id);
            }

            //$user = Auth::user();

            return sendResponse('Login Successful.', 200, ['token' => $token, 'userData' => $user]);
        } catch (\Throwable $th) {
            sendResponse($th->getMessage());
        }
    }

    public function getConfigSettings(Request $request)
    {
        $user = Auth::user();
        $settings = [
            'current_version' => '2.0.3',
        ];
        return sendResponse('Login Successful.', 200, $settings);
    }

    public function createCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            //'email' => 'required',
            'mobile' => 'required',
        ]);

        if ($validator->fails()) {
            return Helper::sendResponse(Helper::ValidationSet($validator->errors()), 422);
        }

        $customer = SavingCustomer::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make('User123'),
        ]);

        $customerData = [
            'id' => $customer->id,
            'name' => $customer->name,
            'email' => $customer->email,
            'mobile' => $customer->mobile,
        ];
        Helper::sendResponse('Customer Created', 1, $customerData);
    }

    public function customerDetail(Request $request)
    {
        $query = SavingCustomer::query()->select('name', 'id', 'email', 'mobile', 'status', 'is_password_updated');

        if ($request->filled('mobile')) {
            $query->where('mobile', $request->mobile);
        }

        if ($request->filled('email')) {
            $query->where('email', $request->email);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $customerDetail = $query->first();
        if ($customerDetail) {
            return Helper::sendResponse('Customer Detail', 1, $customerDetail);
        } else {
            return Helper::sendResponse('Customer Not Found', 0, null);
        }
    }

    public function uploadDenomination(Request $request)
    {
        $requestData = $request->all();
        try {
            $user = Auth::user();
            $requestData['company_id'] =  $user->company_id;
            $requestData['denomination_date'] = date('Y-m-d', strtotime($requestData['denomination_date'])) ?? date('Y-m-d');
            $checkAlreadyAddedDenomination = SavingDenomination::where(['company_id' => $requestData['company_id']]);
            if ($requestData['user_id'] != '1') {
                $checkAlreadyAddedDenomination = $checkAlreadyAddedDenomination->where('user_id', $requestData['user_id']);
            }

            if (isset($requestData['id']) && !empty($requestData['id'])) {
                $checkAlreadyAddedDenomination = $checkAlreadyAddedDenomination->where('id', $requestData['id']);
                unset($requestData['user_id']);
            } else {
                $checkAlreadyAddedDenomination = $checkAlreadyAddedDenomination->whereDate('denomination_date', $requestData['denomination_date']);
            }
            $checkAlreadyAddedDenomination = $checkAlreadyAddedDenomination->first();
            if (!empty($checkAlreadyAddedDenomination)) {
                if ($checkAlreadyAddedDenomination->user_id == $user->id) {
                    if ($checkAlreadyAddedDenomination->upload_type == 'edit') {
                        $checkAlreadyAddedDenomination->fill($requestData);
                    } else {
                        $checkAlreadyAddedDenomination->n_2000 += $requestData['n_2000'];
                        $checkAlreadyAddedDenomination->n_500 += $requestData['n_500'];
                        $checkAlreadyAddedDenomination->n_200 += $requestData['n_200'];
                        $checkAlreadyAddedDenomination->n_100 += $requestData['n_100'];
                        $checkAlreadyAddedDenomination->n_50 += $requestData['n_50'];
                        $checkAlreadyAddedDenomination->n_20 += $requestData['n_20'];
                        $checkAlreadyAddedDenomination->n_10 += $requestData['n_10'];
                        $checkAlreadyAddedDenomination->online += $requestData['online'];
                    }
                    $checkAlreadyAddedDenomination->save();
                } else {
                    sendResponse("You cannot update this denomination", 0);
                }
            } else {
                SavingDenomination::create($requestData);
            }

            sendResponse("Denomination Successfully Added", 1);
        } catch (\Throwable $th) {
            sendResponse($th->getMessage());
        }
    }
    public function updateDenomination(Request $request)
    {
        try {
            $requestData = $request->all();
            $user = Auth::user();
            $requestData['company_id'] =  $user->company_id;
            if (isset($requestData['denomination_date']) && !empty($requestData['denomination_date'])) {
                $requestData['denomination_date'] = date('Y-m-d', strtotime($requestData['denomination_date'])) ?? date('Y-m-d');
            }
            $denominationData = SavingDenomination::where(['company_id' => $requestData['company_id']])
                ->where('id', $request->id)
                ->when($user->role != 'Developer', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->first();

            if (!empty($denominationData)) {
                $denominationData->fill($requestData);
                $denominationData->save();
                sendResponse('Denomination Updated Successful', 1);
            } else {
                sendResponse('Something went wrong');
            }
        } catch (Exception $e) {
            sendResponse('Something went wrong');
        }
    }
    public function deleteDenomination(Request $request)
    {
        $user = Auth::user();
        $denomination = SavingDenomination::where('id', $request->denomination_id)->first();
        if (!$denomination) {
            return Helper::sendResponse('Denomination not found', 0);
        }
        $denomination->delete();
        return Helper::sendResponse('Denomination Successfully Deleted', 1);
    }

    public function denominationList(Request $request)
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        $denominationList = SavingDenomination::where('company_id', $companyId)
            ->whereMonth('denomination_date', $month)
            ->whereYear('denomination_date', $year)
            ->when($user->role != 'Developer', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderBy('denomination_date', 'DESC')
            ->get();
        $dates = $denominationList->pluck('denomination_date')->unique();
        $userIds = $denominationList->pluck('user_id')->unique();

        $expenseTotals = SavingExpenses::where('company_id', $companyId)
            ->whereIn('expenses_date', $dates)
            ->whereIn('user_id', $userIds)
            ->where('expenses_type', 'Others')
            ->select('expenses_date', 'user_id', DB::raw('SUM(amount) as total_expense'))
            ->groupBy('expenses_date', 'user_id')
            ->get();
        $expenseTotalsMap = $expenseTotals->mapWithKeys(function ($item) {
            return ["{$item->expenses_date}_{$item->user_id}" => (float)$item->total_expense];
        });

        $formattedDenominationList = $denominationList->map(function ($item) use ($expenseTotalsMap) {
            $breakdown = [];
            $notes = [2000, 500, 200, 100, 50, 20, 10];

            foreach ($notes as $note) {
                $column = "n_{$note}";
                if (!is_null($item->$column)) {
                    $breakdown[$note] = (int)$item->$column;
                }
            }

            $expenseKey = "{$item->denomination_date}_{$item->user_id}";

            return [
                'id' => $item->id,
                'company_id' => $item->company_id,
                'user_id' => $item->user_id,
                'online' => $item->online,
                'type' => $item->type,
                'total' => $item->total,
                'denomination_date' => $item->denomination_date,
                'breakdown' => $breakdown,
                'expense_total' => $expenseTotalsMap->get($expenseKey, 0.0), // Specific to date and user_id
            ];
        });
        Helper::sendResponse('Denomination List', 1, $formattedDenominationList);
    }

    public function getDenominationDetail(Request $request)
    {
        $user = Auth::user();
        $data = SavingDenomination::where('company_id', $user->company_id)->where('id', $request->id)->first();
        sendResponse('Denomination Detai;', 1, $data);
    }

    public function denominationDetail(Request $request)
    {

        $selectedDate = date('Y-m-d');
        $user = Auth::user();
        if (isset($request->selected_date) && !empty($request->selected_date)) {
            $selectedDate = date('Y-m-d', strtotime($request->selected_date));
        }
        //dd($request->all());
        $request->fetch_type = isset($request->fetch_type) ? $request->fetch_type : 'daily';
        $data = SavingDenomination::select([
            'id',
            'user_id',
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
            ->where('company_id', $user->company_id)
            ->whereDate('denomination_date', date('Y-m-d', strtotime($selectedDate)));

        $expenses = SavingExpenses::where(['company_id' => $user->company_id, 'expenses_type' => 'Others'])->whereDate('created_at', date('Y-m-d', strtotime($selectedDate)));


        if ($request->fetch_type == 'edit' || $user->role != 'Developer' && (isset($request->fetch_type) && $request->fetch_type != 'report')) {
            $data = $data->where('user_id', $request->user_id);
            $expenses = $expenses->where('user_id', $request->user_id);
        }


        $totalExpenses = $expenses->sum('amount');
        $data = $data->first();
        if (
            ($data->online == null || $data->online == 0) &&
            ($data->n_2000 == null || $data->n_2000 == 0) &&
            ($data->n_500 == null || $data->n_500 == 0) &&
            ($data->n_200 == null || $data->n_200 == 0) &&
            ($data->n_100 == null || $data->n_100 == 0) &&
            ($data->n_50 == null || $data->n_50 == 0) &&
            ($data->n_20 == null || $data->n_20 == 0) &&
            ($data->n_10 == null || $data->n_10 == 0)
        ) {
            sendResponse('Denomination not found', 0);
        } else {
            sendResponse('Denomination Detail', 1, $data, ['total_expenses' => $totalExpenses]);
        }
    }
    public function rmEntryDetails(Request $request)
    {
        $requestData = $request->all();
        try {
            $rmEntryList = SavingRm::find($requestData['rm_id']);
            sendResponse("Denomination Successfully Added", 1);
        } catch (\Throwable $th) {
            sendResponse($th->getMessage());
        }
    }
    public function RmScanCode(Request $request)
    {
        try {
            $user = Auth::user();
            $code = $request->scan_code;
            $codeArray = explode('@:@', $code);
            $id = explode('.', end($codeArray))[0];
            if (!empty($id)) {
                $RmData = SavingRm::where(['company_id' => $user->company_id, 'customer_id' => $id])->get()->map->formatData();
                if (!empty($RmData)) {
                    sendResponse("RM Detail", 1, $RmData);
                } else {
                    sendResponse('Wrong Qr Code');
                }
            } else {
                sendResponse();
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function addExpences(Request $request)
    {
        $requestData = $request->all();
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'amount' => 'required',
                'amount_type' => 'required',
                'expenses_type' => 'required',
                'reason' => 'required',
                'expenses_date' => 'required',
            ]);
            if ($validator->fails()) {
                $error = Helper::ValidationSet($validator->errors(), 422);
            }
            $requestData['company_id'] = Auth::user()->company_id;
            $requestData['expenses_date'] = date('Y-m-d', strtotime($request->expenses_date));
            $expenses = SavingExpenses::create($requestData);
            sendResponse("Expences Successfully Added", 1);
        } catch (\Throwable $th) {
            sendResponse($th->getMessage(), 500);
        }
    }
    public function updateExpences(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:saving_expenses,id',
                'user_id' => 'required',
                'amount' => 'required|numeric',
                'amount_type' => 'required',
                'expenses_type' => 'required',
                'reason' => 'required',
                'expenses_date' => 'required',
            ]);
            if ($validator->fails()) {
                $error = Helper::ValidationSet($validator->errors(), 422);
            }
            $requestData = $request->all();
            $requestData['company_id'] = Auth::user()->company_id;
            $requestData['expenses_date'] = date('Y-m-d', strtotime($request->expenses_date));
            $expense = SavingExpenses::findOrFail($request->id);
            unset($requestData['user_id']);
            $expense->fill($requestData);
            $expense->save();
            return sendResponse("Expenses Successfully Updated", 1);
        } catch (\Throwable $th) {
            sendResponse($th->getMessage(), 500);
        }
    }

    public function deleteExpences(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:saving_expenses,id',
            ]);

            if ($validator->fails()) {
                return Helper::ValidationSet($validator->errors(), 422);
            }
            $expense = SavingExpenses::where('id', $request->id)
                ->where('company_id', Auth::user()->company_id)
                ->first();

            if (!$expense) {
                return sendResponse("Record not found or unauthorized", 0);
            }
            $expense->delete();

            return sendResponse("Expense Successfully Deleted", 1);
        } catch (\Throwable $th) {
            return sendResponse($th->getMessage(), 500);
        }
    }

    public function expencesList(Request $request)
    {
        $requestData = $request->all();
        try {

            $user = Auth::user();
            $expenses = SavingExpenses::where('company_id', $user->company_id)
                ->whereMonth('expenses_date', $request->month)
                ->whereYear('expenses_date', $request->year);
            if ($request->amount_type != '') {
                $expenses = $expenses->where('amount_type', $request->amount_type);
            }
            if ($request->expenses_type != '') {
                $expenses = $expenses->where('expenses_type', $request->expenses_type);
            }

            $expenses = $expenses->orderBy('expenses_date', $request->sort ?? 'desc');
            $expenses = $expenses->orderBy('id', $request->sort ?? 'desc');
            $expenses = $expenses->get()->map->formatData();
            if (!empty($expenses)) {
                sendResponse("Expences List", 1, $expenses);
            } else {
                sendResponse("Expences List", 1, $expenses);
            }
        } catch (\Throwable $th) {
            sendResponse($th->getMessage());
        }
    }
}
