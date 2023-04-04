<?php

declare(strict_types=1);

namespace Seara\Service\Core;

use Seara\Service\Core\Util\UuidGenerator;

trait UuidIdentifier
{
    public function nextIdentity(): string
    {
        return UuidGenerator::generate();
    }
}
