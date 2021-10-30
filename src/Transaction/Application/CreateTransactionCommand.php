<?php

declare(strict_types=1);

namespace App\Transaction\Application;

use App\Transaction\Domain\Entity\Transaction;
use App\Transaction\Domain\ValueObject\Amount;
use DateTimeImmutable;

final class CreateTransactionCommand
{
    private function __construct(
        private string $name,
        private Amount $amount,
        private DateTimeImmutable $transactionDate,
        private string $type
    ) {
    }

    /**
     * @psalm-param array{
     *   name: string,
     *   amount: float,
     *   transactionDate: DateImmutable
     *   type: integer
     * }
     *
     * @param array<string, mixed> $formData
     */
    public static function fromFormData(array $formData): self
    {
        return new self(
            name: $formData['name'],
            amount: Amount::fromUnformattedValue((float) $formData['amount']),
            transactionDate: $formData['transactionDate'],
            type: Transaction::TYPES[$formData['type']]
        );
    }

    public function name(): string
    {
        return $this->name;
    }

    public function amount(): Amount
    {
        return $this->amount;
    }

    public function transactionDate(): DateTimeImmutable
    {
        return $this->transactionDate;
    }

    public function type(): string
    {
        return $this->type;
    }
}
