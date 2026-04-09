<?php

namespace App\Models;

use App\Observers\SavingExpensesObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([SavingExpensesObserver::class])]
class SavingExpenses extends Model
{
    use HasFactory;
    protected $fillable = ['company_id','user_id','account_id','amount','amount_type','expenses_type','expenses_date','reason'];

    public function Agent(){
        return $this->belongsTo(User::class, 'user_id','id')->select(['id','username']);
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
    
    public function formatData(){

        $data = [
            'id' => $this->id,
            'agent'=>$this->Agent->username,
            'user_id'=>$this->user_id,
            'account_id'=>$this->account_id,
            'amount_type'=>$this->amount_type,
            'expenses_type'=>$this->expenses_type,
            'reason'=>$this->reason,
            'amount'=>$this->amount,
            'expenses_date'=>date('d-M-Y',strtotime($this->expenses_date)),
            'expenses_time'=>date('h:i A',strtotime($this->created_at)),
        ];
        return $data;
    }
}
