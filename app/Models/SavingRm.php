<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SavingCustomer;
use App\Models\SavingRmEntries;
use App\Models\RmMonthlyAmountHistory;
use App\Observers\SavingRmObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Support\Facades\Auth;

#[ObservedBy([SavingRmObserver::class])]
class SavingRm extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'company_id',
        'agent_id',
        'customer_id',
        'name',
        'monthly_amount',
        'installment_amount',
        'account_type',
        'opening_month',
        'opening_year',
        'opening_balance',
        'maturity_status',
    ];
    protected $casts = [
        'installment_amount' => 'integer',
        'monthly_amount' => 'integer'
    ];
    protected $appends = ['total_deposit_amount', 'current_month_deposit_amount'];
    protected $with = ['monthlyAmountHistory', 'installmentAmountHistory'];
    public function getTotalDepositAmount()
    {

        $totalAmount = SavingRmEntries::where('rm_id', $this->id)->sum('amount');
        return number_format($totalAmount);
    }
    public function getTotalDepositAmountAttribute()
    {
        $user = getUser();
        $totalAmount = 0;
        if (!empty($user)) {
            $totalAmount = SavingRmEntries::where('rm_id', $this->id)->where('company_id', $user->company_id)->sum('amount');
        }
        return number_format($totalAmount);
    }
    public function getCurrentMonthDepositAmountAttribute()
    {
        $user = getUser();
        $totalAmount = 0;
        if (!empty($user)) {
            $totalAmount = SavingRmEntries::where('rm_id', $this->id)->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))
                ->where('company_id', $user->company_id)->sum('amount');
        }
        return number_format($totalAmount);
    }

    public function customer()
    {
        return $this->belongsTo(SavingCustomer::class, 'customer_id', 'id');
    }
    public function entries()
    {
        return $this->hasMany(SavingRmEntries::class, 'rm_id', 'id');
    }


    public function formatData()
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'customer_id' => $this->customer_id,
            'mobile' => $this->customer->mobile ?? '',
            'email' => $this->customer->email ?? '',
            'rm_code' => $this->rm_code,
            'account_type' => $this->account_type,
            'monthly_amount' => $this->monthly_amount,
            'installment_amount' => $this->installment_amount,
            'opening_balance' => $this->opening_balance,
            'total_deposit' => $this->current_month_deposit_amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
        return $data;
    }
    public function scopeCompany($query)
    {
        if (Auth::check()) {
            $company_id = auth()->user()->company_id;
            return $query->where('company_id', $company_id);
        }
    }

    public function monthlyAmountHistory()
    {
        return $this->hasMany(RmMonthlyAmountHistory::class, 'rm_id')->where('status', 1)
            ->orderBy('effective_year')
            ->orderBy('effective_month');
    }

    public function installmentAmountHistory()
    {

        return $this->hasMany(RmMonthlyAmountHistory::class, 'rm_id')
            ->orderBy('effective_year')
            ->orderBy('effective_month');
    }

    public function getMonthlyAmountAttribute($value)
    {
        return $this->resolveAmountFromHistory('monthly_amount', $value);
    }

    public function getInstallmentAmountAttribute($value)
    {
        return $this->resolveAmountFromHistory('installment_amount', $value);
    }
    private function resolveAmountFromHistory($field, $defaultValue)
    {
        $now = now();
        $history = $this->monthlyAmountHistory
            ->filter(function ($row) use ($now) {

                return $row->effective_year < $now->year ||
                    ($row->effective_year == $now->year &&
                        $row->effective_month <= $now->month);
            })->where('status', 1)
            ->sortByDesc(function ($row) {

                return $row->effective_year * 100 + $row->effective_month;
            })
            ->first();
        if ($history && isset($history->$field)) {
            return (int)$history->$field;
        }

        $rawMonthly = $this->getRawOriginal('monthly_amount');
        $rawInstallment = $this->getRawOriginal('installment_amount');

        if ($rawMonthly > 0) {
            RmMonthlyAmountHistory::create([
                'rm_id'              => $this->id,
                'effective_month'    => $this->opening_month ?? date('m'),
                'effective_year'     => $this->opening_year ?? date('Y'),
                'monthly_amount'     => $rawMonthly,
                'installment_amount' => $rawInstallment,
                'status'             => 1
            ]);

            $this->unsetRelation('monthlyAmountHistory');
        }

        return (int)$this->getRawOriginal($field) ?: (int)$defaultValue;
    }
}
