<?php

declare(strict_types=1);

namespace Seara\Service\Core\DataTable;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Datatables;

final class DataTableBuilder
{
    /**
     * @var array
     */
    private $adds = [];
    /**
     * @var Formatter[]
     */
    private $formatters = [];
    /**
     * @var Builder
     */
    private $query;
    /**
     * @var QueryFilter
     */
    private $filter;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var callable
     */
    private $rowData;
    /**
     * @var callable
     */
    private $rowAttr;

    public function __construct(Request $request)
    {
        $this->filter = new class implements QueryFilter {
            public function apply(array $filters, Builder $query): void {}
        };
        $this->request = $request;
    }

    /**
     * Adds a column to the generated table
     *
     * @param string $column
     * @param callable $callback
     * @return $this
     */
    public function addColumn(string $column, callable $callback): self
    {
        $builder = clone $this;
        $builder->adds[$column] = $callback;
        return $builder;
    }

    /**
     * Edits a column value before generating the table
     *
     * @param string $column
     * @param Formatter $formatter
     * @return $this
     */
    public function formatColumn(string $column, Formatter $formatter): self
    {
        $builder = clone $this;
        $builder->formatters[$column] = $formatter;
        return $builder;
    }

    /**
     * Sets the row data
     *
     * @param array $rowData
     * @return $this
     */
    public function setRowData(array $rowData): self
    {
        $builder = clone $this;
        $builder->rowData = $rowData;
        return $builder;
    }

    /**
     * Sets the row attributes
     *
     * @param array $rowAttr
     * @return $this
     */
    public function setRowAttr(array $rowAttr): self
    {
        $builder = clone $this;
        $builder->rowAttr = $rowAttr;
        return $builder;
    }

    /**
     * Sets the query to generate the datatable
     *
     * @param Builder $query
     * @return $this
     */
    public function withQuery(Builder $query): self
    {
        $builder = clone $this;
        $builder->query = $query;
        return $builder;
    }

    /**
     * Applies the given filter to the query before generating the table
     * @param QueryFilter $filter
     * @return $this
     */
    public function withFilter(QueryFilter $filter): self
    {
        $builder = clone $this;
        $builder->filter = $filter;
        return $builder;
    }

    /**
     * Builds the datatable response
     */
    public function build(): Response
    {
        $this->filter->apply($this->request->get('query', []), $this->query);
        $dataTable = DataTables::of($this->query);

        foreach ($this->adds as $column => $formatter) {
            $dataTable->addColumn($column, $formatter);
        }

        foreach ($this->formatters as $column => $formatter) {
            $dataTable->editColumn($column, function ($row) use ($formatter, $column) {
                return $formatter->format($row->{$column}, $row);
            });
        }

        if (is_array($this->rowData)) {
            $dataTable->setRowData($this->rowData);
        }

        if (is_array($this->rowAttr)) {
            $dataTable->setRowAttr($this->rowAttr);
        }

        return $dataTable->make(true);
    }
}
