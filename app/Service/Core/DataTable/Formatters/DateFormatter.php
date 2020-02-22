<?php

declare(strict_types=1);

namespace App\Service\Core\DataTable\Formatters;

use Carbon\Carbon;
use InvalidArgumentException;
use stdClass;
use App\Service\Core\DataTable\Formatter;

class DateFormatter implements Formatter
{
    /**
     * @var array
     */
    private $srcFormats;
    /**
     * @var string
     */
    private $destFormat;

    public function __construct(array $srcFormats, string $destFormat)
    {
        $this->srcFormats = $srcFormats;
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

        foreach ($this->srcFormats as $srcFormat) {
            try {
                return $this->formatDate($srcFormat, $this->destFormat, $value);
            } catch (InvalidArgumentException $exception) {
                continue;
            }
        }

        throw new InvalidArgumentException('It was not possible to convert the date ' . $value);
    }

    private function formatDate(
        string $srcFormat,
        string $destFormat,
        string $date
    ): string {
        return Carbon::createFromFormat($srcFormat, $date)
            ->format($destFormat);
    }
}
