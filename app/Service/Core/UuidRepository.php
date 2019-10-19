<?php

declare(strict_types=1);

namespace App\Service\Core;

interface UuidRepository
{
    /**
     * Gets an identifier
     * @return string
     */
    public function nextIdentity(): string;
}
