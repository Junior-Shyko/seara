<?php

declare(strict_types=1);

namespace App\Service\Financing\Receivable;

use App\Service\Core\DataTable\DataTableBuilder;
use App\Service\Core\DataTable\Formatters\Format;
use App\Service\Core\DataTable\QueryFilter;
use App\Service\Core\Transformation\ArrayTransformer;
use App\Service\Core\Transformation\FormatBrDate;
use App\Traits\ActionTable;
use Carbon\Carbon;
use Closure;
use DB;
use Illuminate\Database\Query\Builder;

class ReceivableTableFactory implements QueryFilter
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

    public function make()
    {
        return $this->builder
            ->withQuery($this->getQuery())
            ->withFilter($this)
            ->addColumn('action', Closure::fromCallable([$this, 'addActionColumn']))
            ->formatColumn('due_date', Format::asDate())
            ->formatColumn('amount', Format::asCurrency())
            ->formatColumn('paid_amount', Format::asCurrency())
            ->formatColumn('description', Format::using(Closure::fromCallable([$this, 'editDescription'])))
            ->formatColumn('payment_date', Format::asDate())
            ->setRowData([
                'remainingAmount' => function ($receivable) {
                    $remainingAmount = $receivable->amount - ($receivable->paid_amount ?? 0);
                    return $this->formatMoney($remainingAmount);
                }
            ])
            ->setRowAttr([
                'id' => function ($receivable) {
                    return 'receivable-' . $receivable->id;
                }
            ])
            ->build();
    }

    private function getQuery(): Builder
    {
        $query = DB::table('receivable_view')
            ->select();
        return $query;
    }

    /**
     * @inheritDoc
     */
    public function apply(array $filters, Builder $query): void
    {
        $filters = (new ArrayTransformer())
            ->transform($filters, [
                'due_date_start' => [new FormatBrDate()],
                'due_date_end' => [new FormatBrDate()],
                'payment_date_start' => [new FormatBrDate()],
                'payment_date_end' => [new FormatBrDate()],
            ]);

        if (!array_filter($filters)) {
            $this->applyDefaultFilter($query);
            return;
        }

        $this->applyStatusFilter($filters['status'] ?? null, $query);
        $this->applyCustomerFilter($filters['customer'] ?? null, $query);
        $this->applyDueDateFilter(
            $filters['due_date_start'] ?? null,
            $filters['due_date_end'] ?? null,
            $query
        );
        $this->applyPaymentDateFilter(
            $filters['payment_date_start'] ?? null,
            $filters['payment_date_end'] ?? null,
            $query
        );
    }

    private function applyDefaultFilter(Builder $query)
    {
        $query->where(function (Builder $query) {
            $query->whereNull('paid_amount')
                ->orWhereColumn('paid_amount', '<', 'amount');
        });
        $this->applyDefaultPeriodFilter($query);
    }

    private function applyDefaultPeriodFilter(Builder $query)
    {
        $now = Carbon::now();
        $query
            ->where(function (Builder $query) use ($now) {
                $query
                    ->whereDate('due_date', '<=', $now->format('Y-m-d'))
                    ->orWhere(function (Builder $query) use ($now) {
                        $query->whereMonth('due_date', '<=', (int)$now->format('t'))
                            ->whereYear('due_date', '<=', (int)$now->format('Y'));
                    });;
            });
    }

    private function applyStatusFilter($status, Builder $query)
    {
        if (null === $status || 'pending' === $status) {
            $query->whereColumn('paid_amount', '<', 'amount');
            return;
        }

        if ('effective' === $status) {
            $query->whereColumn('paid_amount', '>=', 'amount');
            return;
        }
    }

    private function applyCustomerFilter($customer, Builder $query)
    {
        if (null === $customer) {
            return;
        }

        if ('none' === $customer) {
            $query->whereNull('company_id');
            return;
        }

        $query->where('company_id', '=', $customer);
    }

    private function applyDueDateFilter($start, $end, Builder $query)
    {
        if (null === $start && null === $end) {
            $this->applyDefaultPeriodFilter($query);
            return;
        }

        if (null !== $start) {
            $query->whereDate('due_date', '>=', $start);
        }

        if (null !== $end) {
            $query->whereDate('due_date', '<=', $end);
        }
    }

    private function applyPaymentDateFilter($start, $end, Builder $query)
    {
        if (null !== $start) {
            $query->whereDate('payment_date', '>=', $start);
        }

        if (null !== $end) {
            $query->whereDate('payment_date', '<=', $end);
        }
    }

    private function addActionColumn($receivable)
    {
        $buttons = '';
        if (!empty($receivable->customer)) {
            $buttons .= $this->actionButton($receivable->id, 'Gerar Recibo', 'generateReceipt', 'fa fa-file');
        }

        $buttons .= $this->actionButtons($receivable->id, [
            ['Efetivar conta', 'payReceivable', 'fa fa-check', 'btn-success'],
            ['Editar', 'editReceivable', 'fa fa-pencil'],
            ['Remover', 'deleteReceivable', 'fa fa-ban', 'btn-danger'],
        ]);

        return $buttons;
    }

    private function editDescription(string $description, $receivable)
    {
        if (!$receivable->sequence_number) {
            return $description;
        }

        return sprintf(
            '%s (%d/%d)',
            $description,
            $receivable->sequence_number,
            $receivable->sequence_count
        );
    }

    private function formatMoney($amount)
    {
        if (null === $amount) {
            return '';
        }

        return number_format(
            $amount,
            2,
            ',',
            '.'
        );
    }
}
