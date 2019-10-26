<?php

declare(strict_types=1);

namespace App\Service\Financing\Receivable;

use App\Receivable;
use App\Service\Core\UuidIdentifier;

class EloquentReceivableRepository implements ReceivableRepository
{
    use UuidIdentifier;

    /**
     * @inheritDoc
     */
    public function save(array $receivable): void
    {
        $model = new Receivable();
        $model->fill($receivable);
        $model->save();
    }
}
