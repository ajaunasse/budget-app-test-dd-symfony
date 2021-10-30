<?php

declare(strict_types=1);

namespace App\Transaction\Domain\Entity;

use App\Transaction\Domain\Exception\TransactionTypeNotExist;
use App\Transaction\Domain\ValueObject\Amount;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
final class Transaction
{
    public const DEBIT = 'Debit';
    public const CREDIT = 'Credit';

    public const TYPES = [
        1 => self::DEBIT,
        2 => self::CREDIT,
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $name;

    /**
     * @ORM\Column(type="integer")
     */
    private int $amount;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private DateTimeImmutable $transactionDate;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private string $type;

    private function __construct()
    {
    }

    public static function createFromCommand(
        string $name,
        int $amount,
        DateTimeImmutable $transactionDate,
        string $type
    ): self {
        $self = new self();

        $self->name = $name;
        $self->amount = $amount;
        $self->transactionDate = $transactionDate;

        if (!in_array($type, self::TYPES)) {
            throw new TransactionTypeNotExist();
        }

        $self->type = $type;

        return $self;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
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
