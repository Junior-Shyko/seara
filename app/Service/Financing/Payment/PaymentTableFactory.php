<?php

declare(strict_types=1);

namespace App\Service\Financing\Payment;

use App\Service\Core\DataTable\DataTableBuilder;
use App\Service\Core\DataTable\DataTableResponseFactory;
use App\Service\Core\DataTable\Formatters\Format;
use App\Service\Core\DataTable\QueryFilter;
use App\Traits\ActionTable;
use Closure;
use DB;
use Illuminate\Database\Query\Builder;
use Symfony\Component\HttpFoundation\Response;

class PaymentTableFactory implements QueryFilter, DataTableResponseFactory
{
    use ActionTable;

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
            ->addColumn('action', Closure::fromCallable([$this, 'addActionColumn']))
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

    private function addActionColumn($payment)
    {
        return $this->actionButtons($payment->id, [
            ['Editar', 'editPayment', 'fa fa-pencil'],
            ['Remover', 'deletePayment', 'fa fa-ban', 'btn-danger'],
        ]);
    }
}
