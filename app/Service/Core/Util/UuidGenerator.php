<?php

declare(strict_types=1);

namespace Seara\Service\Core\Util;

use Ramsey\Uuid\Uuid;

class UuidGenerator
{
    public static function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
