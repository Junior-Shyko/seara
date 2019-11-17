<?php

declare(strict_types=1);

namespace App\Service\Financing\Receivable;

use App\Service\Core\DataTable\DataTableBuilder;
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
            ->editColumn('due_date', Closure::fromCallable([$this, 'editDueDate']))
            ->editColumn('amount', Closure::fromCallable([$this, 'editAmount']))
            ->editColumn('paid_amount', Closure::fromCallable([$this, 'editPaidAmount']))
            ->editColumn('description', Closure::fromCallable([$this, 'editDescription']))
            ->editColumn('payment_date', Closure::fromCallable([$this, 'editPaymentDate']))
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
            $query->whereNull('payment_date');
            return;
        }

        if ('effective' === $status) {
            $query->whereNotNull('payment_date');
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
            ['Efetivar conta', 'payReceivable', 'fa fa-check'],
            ['Editar', 'editReceivable', 'fa fa-pencil'],
            ['Remover', 'deleteReceivable', 'fa fa-ban', 'btn-danger'],
        ]);

        return $buttons;
    }

    private function editDueDate($receivable)
    {
        return $this->formatDateToBr($receivable->due_date);
    }

    private function formatDateToBr($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)
            ->format('d/m/Y');
    }

    private function editPaymentDate($receivable)
    {
        if ($paymentDate = $receivable->payment_date) {
            return $this->formatDateToBr($paymentDate);
        }
        return null;
    }

    private function editAmount($receivable)
    {
        return number_format(
            $receivable->amount,
            2,
            ',',
            '.'
        );
    }

    private function editPaidAmount($receivable)
    {
        $paidAmount = $receivable->paid_amount;
        if (null === $paidAmount) {
            return '';
        }

        return number_format(
            $paidAmount,
            2,
            ',',
            '.'
        );
    }

    private function editDescription($receivable)
    {
        if (!$receivable->sequence_number) {
            return $receivable->description;
        }

        return sprintf(
            '%s (%d/%d)',
            $receivable->description,
            $receivable->sequence_number,
            $receivable->sequence_count
        );
    }
}
