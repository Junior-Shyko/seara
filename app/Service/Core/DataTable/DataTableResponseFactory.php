<?php

declare(strict_types=1);

namespace App\Service\Core\DataTable;

use Symfony\Component\HttpFoundation\Response;

interface DataTableResponseFactory
{
    /**
     * Makes a datatable response
     *
     * @return Response
     */
    public function make(): Response;
}
