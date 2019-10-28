<?php

declare(strict_types=1);

namespace App\Service\Core\Transformation\Operations;

use Carbon\Carbon;
use \InvalidArgumentException;

class UsaDateToBr
{
    public function __invoke($input)
    {
        if (! is_string($input)) {
            return $input;
        }

        try {
            $date = Carbon::createFromFormat('Y-m-d', $input);
            if ($date->format('Y-m-d') !== $input) {
                return $input;
            }
            return $date->format('d/m/Y');
        } catch (InvalidArgumentException $e) {
            return $input;
        }
    }
}
