<?php

namespace App\Models;

use App\Observers\SavingRmEntriesObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

#[ObservedBy([SavingRmEntriesObserver::class])]
class SavingRmEntries extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['company_id', 'user_id', 'rm_id', 'account_id', 'transaction_id', 'amount', 'amount_type', 'entry_type', 'payment_month', 'payment_year', 'entry_date'];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the Rm that owns the SavingRmEntries
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function RmDetail()
    {
        return $this->belongsTo(SavingRm::class, 'rm_id', 'id')->select(['id', 'name', 'account_type', 'monthly_amount']);
    }
    public function company()
    {
        return $this->belongsTo(SavingCompany::class, 'company_id', 'id');
    }
    public function Agent()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->select(['id', 'username']);
    }

    public function companyAccount()
    {
        return $this->belongsTo(CompanyAccount::class);
    }

    public function transaction()
    {
        return $this->morphOne(
            SavingAccountTransaction::class,
            'transactionable'
        );
    }

    public function scopeCompany($query)
    {
        if (Auth::check()) {
            $company_id = getUser()->company_id;
            return $query->where('company_id', $company_id);
        }
    }

    public function formatData()
    {

        $data = [
            'id' => $this->id,
            'name' => $this?->RmDetail?->name,
            'rm_code' => $this?->RmDetail?->rm_code,
            'account_type' => ucwords($this?->RmDetail?->account_type),
            'amount_type' => $this->amount_type,
            'entry_type' => $this->entry_type,
            'amount' => $this->amount,
            'account_id' => $this->account_id,
            'payment_month' => $this->payment_month,
            'payment_year' => $this->payment_year,
            'entry_date' => date('d-M-Y', strtotime($this->entry_date)),
            'entry_date_key' => date('d-m-Y', strtotime($this->entry_date)),
            'entry_time' => date('h:i A', strtotime($this->created_at)),
            'user_id' => $this->user_id,
            'rm_id' => $this->rm_id,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at
        ];
        if (isset($this->Agent)) {
            $data['agent'] = $this->Agent->username;
        }
        $data['trashed'] = method_exists($this, 'trashed') ? $this->trashed() : false;
        return $data;
    }
    public function excelFormatData()
    {

        $data = [
            'id' => $this->id,
            'name' => $this->RmDetail->name,
            'rm_code' => $this->RmDetail->rm_code,
            'account_type' => ucwords($this->RmDetail->account_type),
            'amount_type' => $this->amount_type,
            'amount' => $this->amount,
            'payment_month' => $this->payment_month,
            'payment_year' => $this->payment_year,
            'entry_date' => date('d-M-Y', strtotime($this->created_at)),
            'entry_time' => date('h:i A', strtotime($this->created_at)),
            'user_id' => $this->user_id,
            'rm_id' => $this->rm_id,
            'created_at' => $this->created_at,
        ];
        // include soft-delete info
        $data['deleted_at'] = $this->deleted_at ? date('d-M-Y H:i:s', strtotime($this->deleted_at)) : null;
        $data['trashed'] = method_exists($this, 'trashed') ? $this->trashed() : false;
        if (isset($this->Agent)) {
            $data['agent'] = $this->Agent->username;
        }
        return $data;
    }
}
