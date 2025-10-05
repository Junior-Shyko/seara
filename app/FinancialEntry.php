<?php

namespace Seara;

use Seara\Models\User;
use Seara\Models\Company;
use Illuminate\Database\Eloquent\Model;

class FinancialEntry extends Model
{
    /**
     * Nome da tabela
     */
    protected $table = 'financial_entries';

    /**
     * Campos que podem ser preenchidos em massa
     */
    protected $fillable = [
        'transaction_id',
        'account_id',
        'category_id',
        'type',
        'description',
        'amount',
        'entry_date',
        'document_file',
        'company_id',
        'created_by_user_id',
    ];

    /**
     * Casts de tipos
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'entry_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relacionamento: Lançamento pertence a uma Transação
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    /**
     * Relacionamento: Lançamento pertence a uma Conta
     */
    public function account()
    {
        return $this->belongsTo(FinancialAccount::class, 'account_id', 'id');
    }

    /**
     * Relacionamento: Lançamento pertence a uma Categoria
     */
    public function category()
    {
        return $this->belongsTo(AccountLaunch::class, 'category_id', 'id');
    }

    /**
     * Relacionamento: Lançamento pertence a uma Empresa
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    /**
     * Relacionamento: Lançamento foi criado por um Usuário
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_user_id', 'id');
    }

    /**
     * Scope: Apenas débitos
     */
    public function scopeDebit($query)
    {
        return $query->where('type', 'debit');
    }

    /**
     * Scope: Apenas créditos
     */
    public function scopeCredit($query)
    {
        return $query->where('type', 'credit');
    }

    /**
     * Scope: Por empresa
     */
    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Scope: Por conta
     */
    public function scopeByAccount($query, $accountId)
    {
        return $query->where('account_id', $accountId);
    }

    /**
     * Scope: Por período
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('entry_date', [$startDate, $endDate]);
    }

    /**
     * Accessor: Tipo formatado com badge
     */
    public function getTypeBadgeAttribute()
    {
        $badges = [
            'debit' => '<span class="badge badge-danger">Débito</span>',
            'credit' => '<span class="badge badge-success">Crédito</span>',
        ];

        return $badges[$this->type] ?? $this->type;
    }

    /**
     * Accessor: Valor formatado
     */
    public function getAmountFormattedAttribute()
    {
        $signal = $this->type === 'debit' ? '-' : '+';
        $color = $this->type === 'debit' ? 'text-danger' : 'text-success';
        
        $formatted = number_format($this->amount, 2, ',', '.');
        
        return "<span class='{$color}'>{$signal}R$ {$formatted}</span>";
    }

    /**
     * Accessor: Data formatada
     */
    public function getDateFormattedAttribute()
    {
        return $this->entry_date->format('d/m/Y');
    }

    /**
     * Método: Verificar se é débito
     */
    public function isDebit()
    {
        return $this->type === 'debit';
    }

    /**
     * Método: Verificar se é crédito
     */
    public function isCredit()
    {
        return $this->type === 'credit';
    }

    /**
     * Método: Obter valor com sinal correto
     */
    public function getSignedAmount()
    {
        return $this->type === 'debit' ? -$this->amount : $this->amount;
    }
}
