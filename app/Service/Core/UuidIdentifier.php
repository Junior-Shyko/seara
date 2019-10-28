<?php

declare(strict_types=1);

namespace App\Service\Core;

use App\Service\Core\Util\UuidGenerator;

trait UuidIdentifier
{
    public function nextIdentity(): string
    {
        return UuidGenerator::generate();
    }
}
