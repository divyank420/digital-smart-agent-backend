<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SavingCustomer;
use App\Models\SavingRmEntries;
use Illuminate\Support\Facades\Auth;

class SavingRm extends Model
{
    use SoftDeletes,HasFactory;
    protected $fillable = ['company_id','agent_id','customer_id','name','monthly_amount','installment_amount','account_type','previous_balance'];
    protected $casts = [
        'installment_amount' => 'integer',
    ];
    protected $appends = ['total_deposit_amount','current_month_deposit_amount'];

    public function getTotalDepositAmount(){

        $totalAmount = SavingRmEntries::where('rm_id',$this->id)->sum('amount');
        return number_format($totalAmount);
    }
    public function getTotalDepositAmountAttribute(){
        $user = getUser();
        $totalAmount = 0;
        if(!empty($user)){
            $totalAmount = SavingRmEntries::where('rm_id',$this->id)->where('company_id',$user->company_id)->sum('amount');
        }
        return number_format($totalAmount);
    }
    public function getCurrentMonthDepositAmountAttribute(){
        $user = getUser();
        $totalAmount = 0;
        if(!empty($user)){
            $totalAmount = SavingRmEntries::where('rm_id',$this->id)->whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))
            ->where('company_id',$user->company_id)->sum('amount');
            //dd($totalAmount);
        }
        return number_format($totalAmount);
    }

    public function customer(){
        return $this->belongsTo(SavingCustomer::class, 'customer_id','id');
    }

    /**
     * Get all of the Entries for the SavingRm
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entries(){
        return $this->hasMany(SavingRmEntries::class, 'rm_id', 'id');
    }


    public function formatData(){
        $data = [
            'id' => $this->id,
            'name'=>$this->name,
            'customer_id'=>$this->customer_id,
            'mobile'=>$this->customer->mobile??'',
            'email'=>$this->customer->email??'',
            'rm_code'=>$this->rm_code,
            'account_type'=>$this->account_type,
            'monthly_amount'=>$this->monthly_amount,
            'installment_amount'=>$this->installment_amount,
            'previous_balance'=>$this->previous_balance,
            'total_deposit'=>$this->current_month_deposit_amount,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
        ];
        return $data;
    }
    public function scopeCompany($query){
        if(Auth::check()){
            $company_id = auth()->user()->company_id;
            return $query->where('company_id', $company_id);
        }
    }
}
