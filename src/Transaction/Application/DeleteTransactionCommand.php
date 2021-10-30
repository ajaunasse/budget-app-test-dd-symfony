<?php

declare(strict_types=1);

namespace App\Transaction\Application;

use App\Transaction\Domain\Entity\Transaction;
use App\Transaction\Domain\Entity\TransactionId;
use App\Transaction\Domain\ValueObject\Amount;
use DateTimeImmutable;

final class DeleteTransactionCommand
{
    private function __construct(
        private TransactionId $transactionId
    ) {
    }

    public static function generate(TransactionId $transactionId): self
    {
        return new self($transactionId);
    }

    public function transactionId(): TransactionId
    {
        return $this->transactionId;
    }
}

