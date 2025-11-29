<?php

declare(strict_types=1);

namespace Seara\Service\Financing\Receivable;

use Seara\Receivable;
use Seara\Service\Core\UuidIdentifier;

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

    /**
     * @inheritDoc
     */
    public function find(string $id): Receivable
    {
        if ($receivable = Receivable::find($id)) {
            return $receivable;
        }

        throw ReceivableNotFound::withId($id);
    }

    /**
     * @inheritDoc
     */
    public function update(string $id, array $receivable): void
    {
        $model = $this->find($id);
        $model->fill($receivable);
        $model->save();
    }
}
