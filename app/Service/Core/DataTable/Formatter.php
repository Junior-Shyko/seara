<?php

declare(strict_types=1);

namespace Seara\Service\Core\DataTable;

use stdClass;

interface Formatter
{
    /**
     * Formats a column value
     *
     * @param mixed $value The value being formatted
     * @param stdClass $row The current row data
     * @return mixed Returns the formatted column
     */
    public function format($value, stdClass $row);
}
