<?php

declare(strict_types=1);

namespace App\Core\BankAccount\Domain\Model;

use App\Core\BankAccount\Domain\ValueObject\BankAccountActivityType;
use App\Shared\BankAccount\Domain\BankAccountId;
use App\Shared\Transaction\Domain\TransactionId;
use DateTimeImmutable;

final class BankAccountActivity
{
    private int $id;

    private BankAccountId $bankAccountId;

    private ?TransactionId $transactionId;

    private DateTimeImmutable $occuredAt;

    private BankAccountActivityType $bankAccountActivityType;

    private int $oldBalance;

    private int $newBalance;

    private function __construct()
    {
    }

    public static function newBankAccount(
        BankAccountId $bankAccountId,
        int $startBalance,
        DateTimeImmutable $occuredAt): BankAccountActivity
    {
        $self = new self();
        $self->bankAccountId = $bankAccountId;
        $self->newBalance = $self->oldBalance = $startBalance;
        $self->occuredAt = $occuredAt;
        $self->bankAccountActivityType = BankAccountActivityType::CREATED();

        return $self;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBankAccountId(): BankAccountId
    {
        return $this->bankAccountId;
    }

    public function getTransactionId(): ?TransactionId
    {
        return $this->transactionId;
    }

    public function getOccuredAt(): DateTimeImmutable
    {
        return $this->occuredAt;
    }

    public function getBankAccountActivityType(): BankAccountActivityType
    {
        return $this->bankAccountActivityType;
    }

    public function getOldBalance(): int
    {
        return $this->oldBalance;
    }

    public function getNewBalance(): int
    {
        return $this->newBalance;
    }
}
