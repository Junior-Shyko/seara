<?php

declare(strict_types=1);

namespace Seara\Service\Core\Transformation;

class FormatMoney
{
    public function __invoke($input)
    {
        if (! is_string($input)) {
            return $input;
        }

        $output = str_replace('.', '', $input);
        $output = str_replace(',', '.', $output);
        return floatval($output);
    }
}
