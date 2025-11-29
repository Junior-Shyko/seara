<?php

declare(strict_types=1);

namespace Seara\Service\Core\DataTable\Formatters;

use Seara\Service\Core\DataTable\Formatter;
use stdClass;

class MoneyFormatter implements Formatter
{
    /**
     * @inheritDoc
     */
    public function format($value, stdClass $row)
    {
        if (null === $value) {
            return '';
        }

        return number_format(
            $value,
            2,
            ',',
            '.'
        );
    }

}
