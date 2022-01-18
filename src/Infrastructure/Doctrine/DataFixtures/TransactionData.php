<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Core\Transaction\Domain\Model\Transaction;
use App\Shared\Common\Domain\Uuid;
use App\Shared\Transaction\Domain\TransactionId;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TransactionData extends Fixture
{
    public const TRANSACTION_WITH_DEBIT = 'transaction-debit';
    public const TRANSACTION_WITH_CREDIT = 'transaction-credit';
    public const TRANSACTION_WITH_DEBIT_REF = '8a11a0a7-0731-4b72-a5a4-18a5424738b3';
    public const TRANSACTION_WITH_CREDIT_REF = 'e63249da-9830-46c9-ad53-7b87fd9c43dc';

    public function load(ObjectManager $manager): void
    {
        $transactionWithDebit = Transaction::createFromCommand(
            id: new TransactionId(self::TRANSACTION_WITH_DEBIT_REF),
            name: 'Grocery bill',
            amount: 12555,
            transactionDate: new DateTimeImmutable(),
            type: Transaction::DEBIT
        );

        $transactionWithCredit = Transaction::createFromCommand(
            id: new TransactionId(self::TRANSACTION_WITH_CREDIT_REF),
            name: 'Salary',
            amount: 200000,
            transactionDate: new DateTimeImmutable(),
            type: Transaction::CREDIT
        );

        $manager->persist($transactionWithDebit);
        $manager->persist($transactionWithCredit);

        $manager->flush();

        $this->addReference(self::TRANSACTION_WITH_DEBIT, $transactionWithDebit);
        $this->addReference(self::TRANSACTION_WITH_CREDIT, $transactionWithCredit);
    }
}
