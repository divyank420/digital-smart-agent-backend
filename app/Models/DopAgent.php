<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Override;

class DopAgent extends Model
{
    protected $table = 'agents';

    public $fillable = [
        'company_id',
        'agent_name',
        'agent_code',
        'post_office',
        'dop_id',
        'dop_password',
        'last_account_synced_at',
    ];

    public function company(){
        return $this->belongsTo(SavingCompany::class, 'company_id', 'id');
    }
    public function accounts(){
        return $this->hasMany(DopAccount::class, 'agent_id', 'id');
    }
}
