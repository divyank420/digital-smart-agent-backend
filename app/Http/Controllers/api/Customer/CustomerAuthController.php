<?php

namespace App\Http\Controllers\api\Customer;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\SavingCustomer;
use App\Models\SavingRm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $customer = SavingCustomer::where('mobile','9782443300')->first();
            $token = Auth::guard('customer')->attempt(['mobile' => $request->mobile, 'password' => $request->password]);
            if (! $token) {
                return sendResponse('Login credentials are invalid.', 400);
            }
            $user = Auth::guard('customer')->user();
            $user->rm_list = SavingRm::select('id', 'name', 'account_type', 'rm_code', 'monthly_amount', 'installment_amount', 'opening_balance')->where('customer_id', $user->id)->get();
            $user->agent_list = Helper::getCustomerAgentsList($user->id);
            return sendResponse('Login Successful.', 200, ['token' => $token, 'userData' => $user]);
            
        } catch (\Throwable $th) {
            sendResponse($th->getMessage());
        }
    }
}
