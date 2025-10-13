<?php

namespace Seara;

use Seara\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class FinancialAccount extends Model
{
/**
     * Nome da tabela
     */
    protected $table = 'financial_accounts';

    /**
     * Campos que podem ser preenchidos em massa
     */
    protected $fillable = [
        'name',
        'type',
        'bank_id',
        'agency_number',
        'account_number',
        'company_id',
        'current_balance',
        'is_active',
    ];

    /**
     * Casts de tipos
     */
    protected $casts = [
        'current_balance' => 'decimal:2',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relacionamento: Conta pertence a um Banco
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    /**
     * Relacionamento: Conta pertence a uma Empresa
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    /**
     * Relacionamento: Conta tem muitos lançamentos
     */
    public function entries()
    {
        return $this->hasMany(FinancialEntry::class, 'account_id', 'id');
    }

    /**
     * Relacionamento: Transferências que SAÍRAM desta conta
     */
    public function transfersFrom()
    {
        return $this->hasMany(Transaction::class, 'from_account_id', 'id')
                    ->where('type', 'transfer');
    }

    /**
     * Relacionamento: Transferências que ENTRARAM nesta conta
     */
    public function transfersTo()
    {
        return $this->hasMany(Transaction::class, 'to_account_id', 'id')
                    ->where('type', 'transfer');
    }

    /**
     * Scope: Apenas contas ativas
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Apenas bancos
     */
    public function scopeBanks($query)
    {
        return $query->where('type', 'bank');
    }

    /**
     * Scope: Apenas caixa
     */
    public function scopeCash($query)
    {
        return $query->where('type', 'cash');
    }

    /**
     * Scope: Por empresa
     */
    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Accessor: Nome formatado com tipo
     */
    public function getFullNameAttribute()
    {
        $icon = $this->type === 'bank' ? '🏦' : '💵';
        return "{$icon} {$this->name}";
    }

    /**
     * Accessor: Saldo formatado
     */
    public function getBalanceFormattedAttribute()
    {
        return 'R$ ' . number_format($this->current_balance, 2, ',', '.');
    }

    /**
     * Método: Calcular saldo real (baseado nos lançamentos)
     */
    public function calculateBalance()
    {
        $credits = $this->entries()->where('type', 'credit')->sum('amount');
        $debits = $this->entries()->where('type', 'debit')->sum('amount');
        
        return $credits - $debits;
    }

    /**
     * Método: Atualizar saldo atual
     */
    public function updateBalance()
    {
        $this->current_balance = $this->calculateBalance();
        $this->save();
        
        return $this;
    }

    static public function getbankInternal(Request $request, $account)
    {
        if($request->idAccountBank == ''){                   
            foreach($account as $acc){
                if($acc->type == 'cash'){
                    $account = FinancialAccount::find($acc->id);                            
                }
            }
        }else{
            $account = FinancialAccount::find($request->idAccountBank);
        }   
        return $account;
    }
}
