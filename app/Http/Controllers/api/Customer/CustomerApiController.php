<?php

namespace App\Http\Controllers\api\Customer;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\SavingCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CustomerApiController extends Controller
{
    public function getCustomerSetting()
    {

        $settings = [
            'app_version' => '1.0.1',
            'force_update' => true
        ];
        Helper::sendResponse('Customer Config Settings', 1, $settings);
    }

    public function updatePassword(Request $request)
    {

        $customer = SavingCustomer::findOrFail(auth()->guard('customer')->id());
        $rules = [
            'new_password' => ['required', 'string', 'min:6'],
        ];
        if ($customer->is_password_updated == 1) {
            $rules['current_password'] = ['required'];
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Helper::ValidationSet($validator->errors());
        }
        if ($customer->is_password_updated == 1 && !Hash::check($request->current_password, $customer->password)) {
            return Helper::ValidationSet([
                'current_password' => ['Current password is incorrect.'],
            ]);
        }
        $customer->update([
            'password' => Hash::make($request->update_password),
            'is_password_updated' => 1,
        ]);

        return Helper::sendResponse('Password updated successfully.', 1);
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        if ($validator->fails()) {
            $error = Helper::ValidationSet($validator->errors());
        }
        $customer = auth()->guard('customer');
        dd($customer);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(
                public_path('uploads/profile'),
                $fileName
            );
            $data['profile_image'] = 'uploads/profile/' . $fileName;
        }

        $customer->update($data);
    }
}
