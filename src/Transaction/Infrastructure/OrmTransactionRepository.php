<?php

namespace App\Transaction\Infrastructure;

use App\Transaction\Domain\Entity\Transaction;
use App\Transaction\Domain\Entity\TransactionId;
use App\Transaction\Domain\Exception\TransactionNotFound;
use App\Transaction\Domain\Repository\TransactionRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Transaction>
 */
final class OrmTransactionRepository extends ServiceEntityRepository implements TransactionRepository
{
    public const TABLE = 'transaction';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    public function add(Transaction $transaction): void
    {
        $this->_em->persist($transaction);
        $this->_em->flush();
    }

    /**
     * @throws TransactionNotFound
     */
    public function get(TransactionId $transactionId): Transaction
    {
        $transaction = $this->find($transactionId->id());

        if (null == $transaction) {
            throw new TransactionNotFound($transactionId);
        }

        return $transaction;
    }

    /**
     * @psalm-return null|list<Transaction>
     */
    public function list(): ?array
    {
        return $this->findAll();
    }

    public function delete(TransactionId $transactionId): void
    {
        $transaction = $this->get($transactionId);

        $this->_em->remove($transaction);

        $this->_em->flush();
    }
}
