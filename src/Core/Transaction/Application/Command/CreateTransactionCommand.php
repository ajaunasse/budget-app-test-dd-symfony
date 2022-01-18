<?php

declare(strict_types=1);

namespace App\Core\Transaction\Application\Command;

use App\Core\Transaction\Domain\Model\Transaction;
use App\Shared\Common\Domain\Uuid;
use App\Shared\Common\Domain\ValueObject\Amount;
use App\Shared\Transaction\Domain\TransactionId;
use DateTimeImmutable;

final class CreateTransactionCommand
{
    private function __construct(
        private TransactionId $id,
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
        $transactionId = new TransactionId(Uuid::random());

        return new self(
            id: $transactionId,
            name: $formData['name'],
            amount: Amount::fromUnformattedValue((float) $formData['amount']),
            transactionDate: $formData['transactionDate'],
            type: Transaction::TYPES[$formData['type']]
        );
    }

    public function id(): TransactionId
    {
        return $this->id;
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
