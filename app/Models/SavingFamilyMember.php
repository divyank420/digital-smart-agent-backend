<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingFamilyMember extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id','company_id','name','relation','status'];
}
