<?php

declare(strict_types=1);

namespace App\Service\Core\DataTable\Formatters;

use App\Service\Core\DataTable\Formatter;
use \stdClass;

class Format
{
    public static function asCurrency(): MoneyFormatter
    {
        return new MoneyFormatter();
    }

    public static function asDate(): DateFormatter
    {
        return new DateFormatter(['Y-m-d', 'Y-m-d H:i:s'], 'd/m/Y');
    }

    /**
     * Receives a callable which the first argument is the column and the second the row
     *
     * @param callable $formatterFunc
     * @return Formatter
     */
    public static function using(callable $formatterFunc): Formatter
    {
        return new class($formatterFunc) implements Formatter {
            private $formatterFunc;

            public function __construct(callable $formatterFunc)
            {
                $this->formatterFunc = $formatterFunc;
            }

            public function format($value, stdClass $row)
            {
                return call_user_func($this->formatterFunc, $value, $row);
            }
        };
    }
}
