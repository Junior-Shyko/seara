<?php

namespace Seara;

use Illuminate\Database\Eloquent\Model;

class TransferDetail extends Model
{
     /**
     * Nome da tabela
     */
    protected $table = 'transfer_details';

    /**
     * Campos que podem ser preenchidos em massa
     */
    protected $fillable = [
        'transfer_group_id',
        'from_account_id',
        'to_account_id',
        'amount',
        'debit_entry_id',
        'credit_entry_id',
        'transfer_date',
        'notes',
    ];

    /**
     * Casts de tipos
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'transfer_date' => 'date',
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
        static::creating(function ($transfer) {
            if (empty($transfer->transfer_group_id)) {
                $transfer->transfer_group_id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relacionamento: Conta de origem
     */
    public function fromAccount()
    {
        return $this->belongsTo(FinancialAccount::class, 'from_account_id', 'id');
    }

    /**
     * Relacionamento: Conta de destino
     */
    public function toAccount()
    {
        return $this->belongsTo(FinancialAccount::class, 'to_account_id', 'id');
    }

    /**
     * Relacionamento: Lançamento de débito
     */
    public function debitEntry()
    {
        return $this->belongsTo(FinancialEntry::class, 'debit_entry_id', 'id');
    }

    /**
     * Relacionamento: Lançamento de crédito
     */
    public function creditEntry()
    {
        return $this->belongsTo(FinancialEntry::class, 'credit_entry_id', 'id');
    }

    /**
     * Accessor: Data formatada
     */
    public function getDateFormattedAttribute()
    {
        return $this->transfer_date->format('d/m/Y');
    }

    /**
     * Accessor: Valor formatado
     */
    public function getAmountFormattedAttribute()
    {
        return 'R$ ' . number_format($this->amount, 2, ',', '.');
    }

    /**
     * Accessor: Descrição completa
     */
    public function getFullDescriptionAttribute()
    {
        $from = $this->fromAccount ? $this->fromAccount->name : 'N/A';
        $to = $this->toAccount ? $this->toAccount->name : 'N/A';

        return "Transferência: {$from} → {$to}";
    }
}
