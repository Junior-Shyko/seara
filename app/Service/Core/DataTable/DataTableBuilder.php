<?php

declare(strict_types=1);

namespace App\Service\Core\DataTable;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\Datatables\Datatables;

final class DataTableBuilder
{
    /**
     * @var array
     */
    private $adds = [];
    /**
     * @var array
     */
    private $edits = [];
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
     * @param callable $callback
     * @return $this
     */
    public function editColumn(string $column, callable $callback): self
    {
        $builder = clone $this;
        $builder->edits[$column] = $callback;
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
        $dataTable = Datatables::of($this->query);

        foreach ($this->adds as $column => $callback) {
            $dataTable->addColumn($column, $callback);
        }

        foreach ($this->edits as $column => $callback) {
            $dataTable->editColumn($column, $callback);
        }

        return $dataTable->make(true);
    }
}
