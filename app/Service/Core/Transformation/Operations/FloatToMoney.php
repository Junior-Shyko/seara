<?php

declare(strict_types=1);

namespace App\Service\Core\Transformation\Operations;

class FloatToMoney
{
    public function __invoke($input)
    {
        if (! is_numeric($input)) {
            return $input;
        }

        return number_format($input, 2, ',', '.');
    }
}
