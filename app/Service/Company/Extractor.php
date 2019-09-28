<?php

declare(strict_types=1);

namespace App\Service\Company;

use Iterator;

interface Extractor
{
    /**
     * Extracts a collection of company data from a file
     *
     * @param string $filePath
     * @return Iterator
     */
    public function extract(string $filePath): Iterator;
}