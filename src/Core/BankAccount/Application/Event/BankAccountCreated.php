<?php

namespace App\Core\BankAccount\Application\Event;

use App\Shared\BankAccount\Domain\BankAccountId;

final class BankAccountCreated
{
    public function __construct(
        private BankAccountId $bankAccountId,
        private int $startBalance,
        private \DateTimeImmutable $occuredAt
    ) {
    }

    public function getBankAccountId(): BankAccountId
    {
        return $this->bankAccountId;
    }

    public function getStartBalance(): int
    {
        return $this->startBalance;
    }

    public function getOccuredAt(): \DateTimeImmutable
    {
        return $this->occuredAt;
    }


}
