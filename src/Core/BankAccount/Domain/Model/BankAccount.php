<?php

declare(strict_types=1);

namespace App\Core\BankAccount\Domain\Model;

use App\Core\BankAccount\Domain\ValueObject\BankAccountType;
use App\Shared\BankAccount\Domain\BankAccountId;
use App\Shared\Common\Domain\ValueObject\Amount;
use DateTimeImmutable;

final class BankAccount
{
    private BankAccountId $id;

    private string $name;

    private BankAccountType $type;

    private int $startBalance;

    private int $currentBalance;

    private bool $mainAccount;

    private \DateTimeImmutable $createdAt;

    private \DateTimeImmutable $updatedAt;

    private function __construct()
    {
    }

    public static function createFromCommand(
        BankAccountId $bankAccountId,
        string $name,
        BankAccountType $bankAccountType,
        int $startBalance,
        bool $mainAccount
    ): BankAccount {
        $self = new self();

        $self->id = $bankAccountId;
        $self->name = $name;
        $self->type = $bankAccountType;
        $self->startBalance = $self->currentBalance = $startBalance;
        $self->mainAccount = $mainAccount;
        $self->createdAt = $self->updatedAt = new DateTimeImmutable();

        return $self;
    }

    public function getId(): BankAccountId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): BankAccountType
    {
        return $this->type;
    }

    public function getStartBalance(): int
    {
        return $this->startBalance;
    }

    public function getCurrentBalance(): int
    {
        return $this->currentBalance;
    }

    public function isMainAccount(): bool
    {
        return $this->mainAccount;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function formattedCurrentBalance(): float
    {
        return Amount::fromFormattedValue($this->currentBalance)->toFloat();
    }
}
