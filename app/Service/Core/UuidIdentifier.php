<?php

declare(strict_types=1);

namespace App\Service\Core;

use Ramsey\Uuid\Uuid;

trait UuidIdentifier
{
    public function nextIdentity(): string
    {
        return Uuid::uuid4()->toString();
    }
}
