<?php

declare(strict_types=1);

namespace App\Service\Financing\Receivable\PendingReceivable;

use App\Receivable;
use DateTime;

interface PendingReceivableQuery
{
    /**
     * @param Receivable $receivable
     * @return PendingReceivable[]
     */
    public function nextPendingReceivables(Receivable $receivable): array;
}
