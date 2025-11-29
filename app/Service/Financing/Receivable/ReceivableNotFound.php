<?php

declare(strict_types=1);

namespace Seara\Service\Financing\Receivable;

use RuntimeException;

final class ReceivableNotFound extends RuntimeException
{
    public static function withId(string $id): self
    {
        $message = sprintf("The receivable with id '%s' was not found", $id);
        return new self($message);
    }
}
