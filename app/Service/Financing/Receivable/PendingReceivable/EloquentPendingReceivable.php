<?php

declare(strict_types=1);

namespace Seara\Service\Financing\Receivable\PendingReceivable;

use Seara\Receivable;
use DB;

class EloquentPendingReceivable implements PendingReceivableQuery
{
    /**
     * @inheritDoc
     */
    public function nextPendingReceivables(Receivable $receivable): array
    {
        $receivables = DB::table('receivable_view')
            ->select('id', DB::raw('amount - coalesce(paid_amount, 0) as pending_amount'))
            ->where('due_date', '>', $receivable->due_date)
            ->where('company_id', '=', $receivable->company_id)
            ->whereColumn('paid_amount', '<', 'amount')
            ->orWhere('id', '=', $receivable->id)
            ->orderBy('due_date')
            ->get();

        return $receivables
            ->map(function ($pendingReceivable) {
                return new PendingReceivable(
                    $pendingReceivable->id,
                    $pendingReceivable->pending_amount
                );
            })
            ->toArray();

    }
}
