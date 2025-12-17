<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class SavingCustomer extends Authenticatable implements JWTSubject{

	use Notifiable;
	
	protected $fillable = ['name','email','rm_code','qr_code','mobile','password','status'];

	public function RmDetail(){
        return $this->belongsTo(User::class, 'rm_id','id');
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
?>