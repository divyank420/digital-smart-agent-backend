<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\CompanyAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        $accounts = CompanyAccount::where('company_id',$companyId)->latest()->get();
        return view('agents.account.index', compact('accounts'));
    }
}
