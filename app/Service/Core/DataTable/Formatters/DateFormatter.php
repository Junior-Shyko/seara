<?php

declare(strict_types=1);

namespace App\Service\Core\DataTable\Formatters;

use Carbon\Carbon;
use stdClass;
use App\Service\Core\DataTable\Formatter;

class DateFormatter implements Formatter
{
    /**
     * @var string
     */
    private $srcFormat;
    /**
     * @var string
     */
    private $destFormat;

    public function __construct(string $srcFormat, string $destFormat)
    {
        $this->srcFormat = $srcFormat;
        $this->destFormat = $destFormat;
    }

    /**
     * @inheritDoc
     */
    public function format($value, stdClass $row)
    {
        if (null === $value) {
            return '';
        }

        return $this->formatDate($value);
    }

    private function formatDate(string $date): string
    {
        return Carbon::createFromFormat($this->srcFormat, $date)
            ->format($this->destFormat);
    }
}
