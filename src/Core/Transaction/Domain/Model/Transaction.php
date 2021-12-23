<?php

declare(strict_types=1);

namespace App\Core\Transaction\Domain\Model;

use App\Core\Transaction\Domain\Exception\TransactionTypeNotExist;
use App\Shared\Common\Domain\ValueObject\Amount;
use App\Shared\Transaction\Domain\TransactionId;
use DateTimeImmutable;

final class Transaction
{
    public const DEBIT = 'Debit';
    public const CREDIT = 'Credit';

    public const TYPES = [
        1 => self::DEBIT,
        2 => self::CREDIT,
    ];

    private TransactionId $id;

    private string $name;

    private int $amount;

    private DateTimeImmutable $transactionDate;

    private string $type;

    private function __construct()
    {
    }

    public static function createFromCommand(
        TransactionId $id,
        string $name,
        int $amount,
        DateTimeImmutable $transactionDate,
        string $type
    ): self {
        $self = new self();

        $self->id = $id;
        $self->name = $name;
        $self->amount = $amount;
        $self->transactionDate = $transactionDate;

        if (!in_array($type, self::TYPES)) {
            throw new TransactionTypeNotExist();
        }

        $self->type = $type;

        return $self;
    }

    public function getId(): ?TransactionId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function amount()
    {
        return $this->amount;
    }

    public function formattedAmount(): float
    {
        $amount = Amount::fromFormattedValue($this->amount);

        return $amount->toFloat();
    }

    public function type(): string
    {
        return $this->type;
    }

    public function transactionDate(): DateTimeImmutable
    {
        return $this->transactionDate;
    }
}
