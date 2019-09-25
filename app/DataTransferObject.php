<?php

declare(strict_types=1);

namespace App;

use Spatie\DataTransferObject\DataTransferObject as DTO;

class DataTransferObject extends DTO
{
    public function __construct(array $parameters)
    {
        foreach ($parameters as $field => $value) {
            if (! property_exists(static::class, $field)) {
                unset($parameters[$field]);
            }
        }

        parent::__construct($parameters);
    }
}