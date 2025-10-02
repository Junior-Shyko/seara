<?php

namespace Seara;

use Seara\Models\User;
use Seara\Models\Company;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
     /**
     * Nome da tabela
     */
    protected $table = 'transactions';

    /**
     * Campos que podem ser preenchidos em massa
     */
    protected $fillable = [
        'uuid',
        'type',
        'status',
        'description',
        'total_amount',
        'from_account_id',
        'to_account_id',
        'company_id',
        'created_by_user_id',
    ];

    /**
     * Casts de tipos
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot do modelo
     */
    protected static function boot()
    {
        parent::boot();

        // Gerar UUID automaticamente ao criar
        static::creating(function ($transaction) {
            if (empty($transaction->uuid)) {
                $transaction->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Relacionamento: Transação pertence a uma Empresa
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    /**
     * Relacionamento: Transação foi criada por um Usuário
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_user_id', 'id');
    }

    /**
     * Relacionamento: Transação tem muitos lançamentos
     */
    public function entries()
    {
        return $this->hasMany(FinancialEntry::class, 'transaction_id', 'id');
    }

    /**
     * Relacionamento: Conta de origem (para transferências)
     */
    public function fromAccount()
    {
        return $this->belongsTo(FinancialAccount::class, 'from_account_id', 'id');
    }

    /**
     * Relacionamento: Conta de destino (para transferências)
     */
    public function toAccount()
    {
        return $this->belongsTo(FinancialAccount::class, 'to_account_id', 'id');
    }

    /**
     * Scope: Apenas receitas
     */
    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    /**
     * Scope: Apenas despesas
     */
    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    /**
     * Scope: Apenas transferências
     */
    public function scopeTransfer($query)
    {
        return $query->where('type', 'transfer');
    }

    /**
     * Scope: Apenas concluídas
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope: Apenas pendentes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Por empresa
     */
    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Scope: Por período
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Accessor: Tipo formatado com ícone
     */
    public function getTypeFormattedAttribute()
    {
        $types = [
            'income' => '💚 Receita',
            'expense' => '🔴 Despesa',
            'transfer' => '🔄 Transferência',
        ];

        return $types[$this->type] ?? $this->type;
    }

    /**
     * Accessor: Status formatado com badge
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="badge badge-warning">Pendente</span>',
            'completed' => '<span class="badge badge-success">Concluído</span>',
            'cancelled' => '<span class="badge badge-danger">Cancelado</span>',
        ];

        return $badges[$this->status] ?? $this->status;
    }

    /**
     * Accessor: Valor formatado
     */
    public function getAmountFormattedAttribute()
    {
        $signal = $this->type === 'expense' ? '-' : '+';
        $color = $this->type === 'expense' ? 'text-danger' : 'text-success';
        
        if ($this->type === 'transfer') {
            $color = 'text-info';
            $signal = '';
        }

        $formatted = number_format($this->total_amount, 2, ',', '.');
        
        return "<span class='{$color}'>{$signal}R$ {$formatted}</span>";
    }

    /**
     * Accessor: Descrição da transferência
     */
    public function getTransferDescriptionAttribute()
    {
        if ($this->type !== 'transfer') {
            return null;
        }

        $from = $this->fromAccount ? $this->fromAccount->name : 'N/A';
        $to = $this->toAccount ? $this->toAccount->name : 'N/A';

        return "De: {$from} → Para: {$to}";
    }

    /**
     * Método: Verificar se é transferência
     */
    public function isTransfer()
    {
        return $this->type === 'transfer';
    }

    /**
     * Método: Verificar se é receita
     */
    public function isIncome()
    {
        return $this->type === 'income';
    }

    /**
     * Método: Verificar se é despesa
     */
    public function isExpense()
    {
        return $this->type === 'expense';
    }
}
