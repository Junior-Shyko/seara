<?php

declare(strict_types=1);

namespace Seara\Service\Core\Csv;

use Iterator;
use League\Csv\Reader;

class LeagueCsvReader implements CsvReader
{
    /**
     * @inheritDoc
     */
    public function readFromPath(string $filePath): Iterator
    {
        /** @var Reader $reader */
        $reader = Reader::createFromPath($filePath);
        $reader->setDelimiter(",");
        $reader->setHeaderOffset(0);
        return $reader->getRecords();
    }
}