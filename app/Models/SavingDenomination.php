<?php

namespace App\Models;

use App\Observers\DenominationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([DenominationObserver::class])]
class SavingDenomination extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','n_2000','n_500','n_200','n_100','n_50','n_20','n_10','online','type','denomination_date'];

    public function scopeCompany($query){
        if(auth()->check()){
            $company_id = auth()->user()->company_id;
            return $query->where('company_id', $company_id);
        }
    }
}
