<?php

declare(strict_types=1);

namespace App\Service\Financing\Account;

use RuntimeException;
use Throwable;

final class AccountNotFound extends RuntimeException
{
    public static function withId(string $id): self
    {
        $message = sprintf("Account of id '%s' was not found", $id);
        return new self($message);
    }
}