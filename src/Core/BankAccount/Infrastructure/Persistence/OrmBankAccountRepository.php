<?php

declare(strict_types=1);

namespace App\Core\BankAccount\Infrastructure\Persistence;

use App\Core\BankAccount\Domain\Exception\BankAccountNotFound;
use App\Core\BankAccount\Domain\Model\BankAccount;
use App\Core\BankAccount\Domain\Repository\BankAccountRepository;
use App\Shared\BankAccount\Domain\BankAccountId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class OrmBankAccountRepository extends ServiceEntityRepository implements BankAccountRepository
{
    public const TABLE = 'bank_account';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BankAccount::class);
    }

    public function add(BankAccount $bankAccount): void
    {
        $this->_em->persist($bankAccount);
        $this->_em->flush();
    }

    public function get(BankAccountId $bankAccountId): BankAccount
    {
        $bankAccount = $this->find($bankAccountId);

        if (null == $bankAccount) {
            throw new BankAccountNotFound($bankAccountId);
        }

        return $bankAccount;
    }

    public function list(): ?array
    {
        return $this->findAll();
    }

    public function update(BankAccountId $bankAccountId): void
    {
    }

    public function delete(BankAccountId $bankAccountId): void
    {
    }
}
