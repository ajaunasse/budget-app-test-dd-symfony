<?php

declare(strict_types=1);

namespace App\Core\Transaction\Domain\ValueObject;

use App\Core\Transaction\Domain\Exception\AmountCannotBeNegative;
use App\Core\Transaction\Domain\Exception\AmountCannotBeNull;

final class Amount
{
    public const DIVISOR = 100;

    private int $amount;

    private function __construct(int $amount)
    {
        if (0 == $amount) {
            throw new AmountCannotBeNull();
        }

        if ($amount < 0) {
            throw new AmountCannotBeNegative();
        }

        $this->amount = $amount;
    }

    public static function fromUnformattedValue(float $value): self
    {
        return new self(amount: intval($value * self::DIVISOR));
    }

    public static function fromFormattedValue(int $value): self
    {
        return new self(amount: $value);
    }

    public function toInt(): int
    {
        return $this->amount;
    }

    public function toFloat(): float
    {
        return round($this->amount / self::DIVISOR, 2);
    }
}
