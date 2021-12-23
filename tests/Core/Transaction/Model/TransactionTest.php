<?php

declare(strict_types=1);

namespace App\Tests\Core\Transaction\Model;

use App\Core\Transaction\Domain\Exception\TransactionTypeNotExist;
use App\Core\Transaction\Domain\Model\Transaction;
use App\Shared\Common\Domain\Uuid;
use App\Shared\Transaction\Domain\TransactionId;
use PHPUnit\Framework\TestCase;

final class TransactionTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldCreateTransactionFromCommand()
    {
        $uuid = Uuid::random();
        $transactionId = new TransactionId($uuid);
        $transaction = Transaction::createFromCommand(
            id: $transactionId,
            name: 'Transaction test',
            amount: 10000,
            transactionDate: new \DateTimeImmutable(),
            type: Transaction::CREDIT
        );

        $this->assertSame('Transaction test', $transaction->name());
        $this->assertSame($transactionId, $transaction->getId());
        $this->assertSame(10000, $transaction->amount());
        $this->assertSame(100.00, $transaction->formattedAmount());
        $this->assertSame(Transaction::CREDIT, $transaction->type());
    }

    /**
     * @test
     */
    public function itShouldFailForAnUnknownType()
    {
        $this->expectException(TransactionTypeNotExist::class);

        $uuid = Uuid::random();
        $transactionId = new TransactionId($uuid);

        Transaction::createFromCommand(
            id: $transactionId,
            name: 'Transaction test',
            amount: 10000,
            transactionDate: new \DateTimeImmutable(),
            type: 'Unknown type'
        );
    }
}
