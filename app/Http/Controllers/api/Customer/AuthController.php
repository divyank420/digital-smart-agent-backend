<?php

namespace App\Http\Controllers\api\Customer;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\CompanyAccount;
use App\Models\SavingCustomer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {

            $guard = 'web';
            $guard = 'users';
            dd('dsfasd');
            $token = Auth::guard('customer')->attempt(['mobile' => $request->mobile, 'password' => $request->password]);
            if (!$token) {
                $guard = 'customer';
                $token = Auth::guard('customer')->attempt(['mobile' => $request->mobile, 'password' => $request->password]);
            }
            try {
                //if (! $token = JWTAuth::attempt($credentials)) {
                if (! $token) {
                    return sendResponse('Login credentials are invalid.', 400);
                }
            } catch (JWTException $e) {
                return sendResponse($e->getMessage(), 500);
            }

            $user = Auth::guard($guard)->user();
            $agent_lists = User::where('company_id', $user->company_id)->where('id', '!=', $user->id)->where('id', '!=', 1)->pluck('name', 'id')->toArray();
            $accounts = CompanyAccount::where('company_id', $user->company_id)->where('is_active', true)->get();
            $user->agent_list = $agent_lists;
            $user->accounts = $accounts;

            return sendResponse('Login Successful.', 200, ['token' => $token, 'userData' => $user]);
        } catch (\Throwable $th) {
            sendResponse($th->getMessage());
        }
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'     => 'required|string|max:255',
                'email'    => 'nullable|email|max:255|unique:customers,email',
                'mobile'   => 'required|digits:10|unique:customers,mobile',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return Helper::sendResponse($validator->errors());
            }

            DB::beginTransaction();
            $customer = SavingCustomer::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'mobile'   => $request->mobile,
                'password' => Hash::make($request->password),
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helper::sendResponse($th->getMessage(), 0);
        }
    }
}
