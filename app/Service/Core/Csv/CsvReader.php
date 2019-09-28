<?php

declare(strict_types=1);

namespace App\Service\Core\Csv;

use Iterator;

interface CsvReader
{
    /**
     * Reads a CSV file and returns the records
     *
     * @param string $filePath
     * @return Iterator The csv record rows
     */
    public function readFromPath(string $filePath): Iterator;
}
