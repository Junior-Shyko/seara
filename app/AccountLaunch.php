<?php

namespace Seara;

use Illuminate\Database\Eloquent\Model;

class AccountLaunch extends Model
{
    protected $table = 'account_launches';

    protected $fillable = [
        'accountlaunch_name',
        'accountlaunch_type',
        'accountlaunch_history',
        'accountlaunch_id_user',
        'account_launches_referring',
        'account_launches_status',
        'account_launches_id_type'
    ];
    /**
     * Relacionamento com FinancialEntries
     */
    public function financialEntries()
    {
        return $this->hasMany(FinancialEntry::class, 'category_id', 'id');
    }

    /**
     * Scope: Apenas ativas
     */
    public function scopeActive($query)
    {
        return $query->where('account_launches_status', 'AT');
    }
}
