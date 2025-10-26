<?php

declare(strict_types=1);

namespace Seara\Service\Core\Transformation;

use Carbon\Carbon;
use \InvalidArgumentException;

class FormatBrDate
{
    public function __invoke($input)
    {
        if (! is_string($input)) {
            return $input;
        }

        if ($date = $this->parseDate($input)) {
            return $date->format('Y-m-d');
        }

        return $input;
    }

    private function parseDate($input): ?Carbon
    {
        if ($fullDate = $this->parseFullDate($input)) {
            return $fullDate;
        }

        return $this->parseTwoDigitsYearDate($input);
    }

    private function parseFullDate($input): ?Carbon
    {
        return $this->parseDateWithFormat($input, 'd/m/Y');
    }

    private function parseTwoDigitsYearDate($input): ?Carbon
    {
        return $this->parseDateWithFormat($input, 'd/m/y');
    }

    private function parseDateWithFormat($input, $format): ?Carbon
    {
        try {
            $date = Carbon::createFromFormat($format, $input);
            if ($date->format($format) === $input) {
                return $date;
            }
            return null;
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }
}
