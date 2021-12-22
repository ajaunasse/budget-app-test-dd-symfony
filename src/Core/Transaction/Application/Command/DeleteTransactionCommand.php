<?php

declare(strict_types=1);

namespace App\Core\Transaction\Application\Command;

use App\Shared\Transaction\Domain\TransactionId;

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

