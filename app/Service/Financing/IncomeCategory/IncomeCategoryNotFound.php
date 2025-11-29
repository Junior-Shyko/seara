<?php

declare(strict_types=1);

namespace Seara\Service\Financing\IncomeCategory;

use RuntimeException;

class IncomeCategoryNotFound extends RuntimeException
{
    public static function withId(string $id): self
    {
        $message = sprintf("The income category of id '%s' was not found", $id);
        return new self($message);
    }
}
