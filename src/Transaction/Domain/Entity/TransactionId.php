<?php

declare(strict_types=1);

namespace App\Transaction\Domain\Entity;

final class TransactionId
{
    public function __construct(private int $id)
    {
    }

    public function id(): int
    {
        return $this->id;
    }
}
