<?php

namespace App\Models;

use App\Models\User;
use App\Models\SavingRmEntries;
use App\Models\SavingExpenses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingCompany extends Model
{
    use HasFactory;
    protected $fillable = ['firm_name','agent_name','email','multiple_agent','agent_count','status'];
    
    public function agents(){
        return $this->hasMany(User::class, 'company_id','id');
    }
    public function entries(){
        return $this->hasMany(SavingRmEntries::class, 'company_id','id')
        ->whereDate('created_at','=',date('Y-m-d',strtotime(date('Y-m-d').'yesterday')));
    }
    public function expenses(){
        return $this->hasMany(SavingExpenses::class, 'company_id','id')
        ->whereDate('created_at','=',date('Y-m-d',strtotime(date('Y-m-d').'yesterday')));
    }
}
