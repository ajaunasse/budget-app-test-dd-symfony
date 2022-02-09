<?php

namespace App\Core\Transaction\Infrastructure\Persistence;

use App\Core\Transaction\Domain\Exception\TransactionNotFound;
use App\Core\Transaction\Domain\Model\Category;
use App\Core\Transaction\Domain\Model\Transaction;
use App\Core\Transaction\Domain\Repository\TransactionRepository;
use App\Shared\Transaction\Domain\TransactionId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
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
        $transaction = $this->find($transactionId);

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
        return $this->createQueryBuilder('t')
            ->select('t as transaction, c.name as categoryName')
            ->innerJoin(Category::class, 'c', Join::WITH, 'c.id = t.categoryId')
            ->getQuery()
            ->getResult()
        ;
    }

    public function delete(TransactionId $transactionId): void
    {
        $transaction = $this->get($transactionId);

        $this->_em->remove($transaction);

        $this->_em->flush();
    }
}
