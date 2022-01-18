<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Core\BankAccount\Domain\Model\BankAccount;
use App\Core\BankAccount\Domain\ValueObject\BankAccountType;
use App\Core\Transaction\Domain\Model\Transaction;
use App\Shared\BankAccount\Domain\BankAccountId;
use App\Shared\Common\Domain\Uuid;
use App\Shared\Transaction\Domain\TransactionId;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BankAccountData extends Fixture
{
    public const CURRENT_BANK_ACCOUNT = 'current-bank-account';
    public const SAVING_BANK_ACCOUNT = 'saving-bank-account';
    public const CURRENT_BANK_ACCOUNT_REF = '1ca243ff-bef3-41d4-aa34-8376c4a370aa';
    public const SAVING_BANK_ACCOUNT_REF = 'da451c54-d6df-4c57-b02a-0ca3b06e61a9';

    public function load(ObjectManager $manager): void
    {
        $ccurrentBankAccount = BankAccount::createFromCommand(
            bankAccountId: new BankAccountId(self::CURRENT_BANK_ACCOUNT_REF),
            name: 'Current bank account',
            bankAccountType: BankAccountType::CURRENT(),
            startBalance: 230025,
            mainAccount: true
        );

        $savingBankAccount = BankAccount::createFromCommand(
            bankAccountId: new BankAccountId(self::SAVING_BANK_ACCOUNT_REF),
            name: 'Livret A',
            bankAccountType: BankAccountType::SAVING(),
            startBalance: 1000000,
            mainAccount: false
        );

        $manager->persist($ccurrentBankAccount);
        $manager->persist($savingBankAccount);

        $manager->flush();

        $this->addReference(self::CURRENT_BANK_ACCOUNT, $ccurrentBankAccount);
        $this->addReference(self::SAVING_BANK_ACCOUNT, $savingBankAccount);
    }
}
