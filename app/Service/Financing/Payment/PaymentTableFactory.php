<?php

declare(strict_types=1);

namespace App\Service\Financing\Payment;

use App\Service\Core\DataTable\DataTableBuilder;
use App\Service\Core\DataTable\DataTableResponseFactory;
use App\Service\Core\DataTable\Formatters\Format;
use App\Service\Core\DataTable\QueryFilter;
use DB;
use Illuminate\Database\Query\Builder;
use Symfony\Component\HttpFoundation\Response;

class PaymentTableFactory implements QueryFilter, DataTableResponseFactory
{
    /**
     * @var DataTableBuilder
     */
    private $builder;

    public function __construct(DataTableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @inheritDoc
     */
    public function make(): Response
    {
        return $this->builder
            ->withQuery($this->getQuery())
            ->formatColumn('payment_date', Format::asDate())
            ->formatColumn('amount', Format::asCurrency())
            ->formatColumn('created_at', Format::asDate())
            ->addColumn('action', function () {return '';})
            ->build();
    }

    private function getQuery(): Builder
    {
        return DB::table('payment_view')
            ->select();
    }

    /**
     * @inheritDoc
     */
    public function apply(array $filters, Builder $query): void
    {
        // TODO: Implement apply() method.
    }
}
