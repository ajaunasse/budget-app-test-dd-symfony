<?php

declare(strict_types=1);

namespace App\Tests\Transaction\Domain;

use App\Transaction\Domain\Exception\AmountCannotBeNegative;
use App\Transaction\Domain\Exception\AmountCannotBeNull;
use App\Transaction\Domain\ValueObject\Amount;
use PHPUnit\Framework\TestCase;

final class AmountTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldReturnAnIntegerAmountFromAFloatTransaction(): void
    {
        $amount = Amount::fromUnformattedValue(125.52);

        $this->assertSame($amount->toInt(), 12552);
    }

    /**
     * @test
     */
    public function aNegativeTransactionShouldReturnANegativeInteger(): void
    {
        $this->expectException(AmountCannotBeNegative::class);
        $amount = Amount::fromUnformattedValue(-125.52);
    }

    /**
     * @test
     */
    public function itShouldAddTwoZeroToAnIntegerTransaction(): void
    {
        $amount = Amount::fromUnformattedValue(125);

        $this->assertSame($amount->toInt(), 12500);
    }

    /**
     * @test
     */
    public function itShouldNotCreateANullAmount(): void
    {
        $this->expectException(AmountCannotBeNull::class);
        Amount::fromUnformattedValue(0);
    }

    /**
     * @test
     */
    public function itShouldNotCreateANullFloatAmount(): void
    {
        $this->expectException(AmountCannotBeNull::class);
        Amount::fromUnformattedValue(0.0);
    }

    /**
     * @test
     */
    public function formattedAmountShouldReturnAFloat(): void
    {
        $amount = Amount::fromUnformattedValue(125.52);

        $this->assertSame(125.52, $amount->toFloat());
    }
}
