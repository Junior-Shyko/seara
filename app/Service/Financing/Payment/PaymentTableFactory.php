<?php

declare(strict_types=1);

namespace App\Service\Financing\Payment;

use App\Service\Core\DataTable\DataTableBuilder;
use App\Service\Core\DataTable\DataTableResponseFactory;
use App\Service\Core\DataTable\Formatters\Format;
use App\Service\Core\DataTable\QueryFilter;
use App\Service\Core\Transformation\ArrayTransformer;
use App\Service\Core\Transformation\FormatBrDate;
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
            ->withFilter($this)
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
        $filters = (new ArrayTransformer())
            ->transform($filters, [
                'created_date_start' => [new FormatBrDate()],
                'created_date_end' => [new FormatBrDate()],
                'payment_date_start' => [new FormatBrDate()],
                'payment_date_end' => [new FormatBrDate()],
            ]);

        // If the advanced filter is empty, I wont'd do anything
        if (!array_filter($filters)) {
            return;
        }

        $this->applyCustomerFilter(
            $filters['customer'] ?? null,
            $query
        );

        $this->applyCreatedDateFilter(
            $filters['created_date_start'] ?? null,
            $filters['created_date_end'] ?? null,
            $query
        );

        $this->applyPaymentDateFilter(
            $filters['payment_date_start'] ?? null,
            $filters['payment_date_end'] ?? null,
            $query
        );
    }

    private function applyCustomerFilter($customer, Builder $query): void
    {
        if ('none' === $customer) {
            $query->whereNull('company_id');
        }

        if (null !== $customer) {
            $query->where('company_id', '=', $customer);
        }
    }

    private function applyCreatedDateFilter($start, $end, Builder $query): void
    {
        if (null !== $start) {
            $query->whereDate('created_at', '>=', $start);
        }

        if (null !== $end) {
            $query->whereDate('created_at', '<=', $end);
        }
    }

    private function applyPaymentDateFilter($start, $end, Builder $query): void
    {
        if (null !== $start) {
            $query->whereDate('payment_date', '>=', $start);
        }

        if (null !== $end) {
            $query->whereDate('payment_date', '<=', $end);
        }
    }

    private function addActionColumn($payment)
    {
        return $this->actionButtons($payment->id, [
//            ['Editar', 'editPayment', 'fa fa-pencil'],
            ['Remover', 'deletePayment', 'fa fa-ban', 'btn-danger'],
        ]);
    }
}
