<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class SavingCustomer extends Authenticatable implements JWTSubject
{

    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'rm_code', 'qr_code', 'mobile', 'password', 'is_password_updated', 'status'];

    protected $casts = [
        'installment_amount' => 'integer',
        'monthly_amount' => 'integer'
    ];

    public function getMonthlyAmountAttribute($value)
    {
        return $this->resolveAmountFromHistory('monthly_amount', $value);
    }

    public function getInstallmentAmountAttribute($value)
    {
        return $this->resolveAmountFromHistory('installment_amount', $value);
    }

    public function RmDetail()
    {
        return $this->belongsTo(User::class, 'rm_id', 'id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
