<?php

declare(strict_types=1);

namespace App\Service\Core\Transformation;

use Carbon\Carbon;
use \InvalidArgumentException;

class FormatBrDate
{
    public function __invoke($input)
    {
        if (! is_string($input)) {
            return $input;
        }

        try {
            $date = Carbon::createFromFormat('d/m/Y', $input);
            if ($date->format('d/m/Y') !== $input) {
                return $input;
            }
            return $date->format('Y-m-d');
        } catch (InvalidArgumentException $e) {
            return $input;
        }
    }
}
