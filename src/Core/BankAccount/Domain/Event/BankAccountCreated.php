<?php

namespace App\Core\BankAccount\Domain\Event;

use App\Shared\BankAccount\Domain\BankAccountId;
use App\Shared\Common\Domain\Model\DomainEventInterface;

final class BankAccountCreated implements DomainEventInterface
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
