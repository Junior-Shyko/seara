<?php

declare(strict_types=1);

namespace Seara\Service\Core\DataTable;

use Illuminate\Database\Query\Builder;

interface QueryFilter
{
    /**
     * Applies a filter to the given query
     * @param array $filters
     * @param Builder $query
     */
    public function apply(array $filters, Builder $query): void;
}
