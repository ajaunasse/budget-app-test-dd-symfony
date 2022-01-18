<?php

declare(strict_types=1);

namespace App\Core\BankAccount\Infrastructure\Persistence;

use App\Core\BankAccount\Domain\Exception\BankAccountActivityNotFound;
use App\Core\BankAccount\Domain\Model\BankAccountActivity;
use App\Core\BankAccount\Domain\Repository\BankAccountActivityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class OrmBankAccountActivityRepository extends ServiceEntityRepository implements BankAccountActivityRepository
{
    public const TABLE = 'bank_account';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BankAccountActivity::class);
    }

    public function add(BankAccountActivity $bankAccountActivity): void
    {
        $this->_em->persist($bankAccountActivity);
        $this->_em->flush();
    }

    public function get(int $id): BankAccountActivity
    {
        $bankAccountActivity = $this->find($id);
        if (null == $bankAccountActivity) {
            throw new BankAccountActivityNotFound($id);
        }

        return $bankAccountActivity;
    }

    public function list(): ?array
    {
        return $this->findAll();
    }
}
