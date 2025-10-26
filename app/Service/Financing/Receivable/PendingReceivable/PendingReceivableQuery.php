<?php

declare(strict_types=1);

namespace Seara\Service\Financing\Receivable\PendingReceivable;

use Seara\Receivable;
use DateTime;

interface PendingReceivableQuery
{
    /**
     * @param Receivable $receivable
     * @return PendingReceivable[]
     */
    public function nextPendingReceivables(Receivable $receivable): array;
}
