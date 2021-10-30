<?php

declare(strict_types=1);

namespace App\Transaction\Domain\Repository;

use App\Transaction\Domain\Entity\Transaction;
use App\Transaction\Domain\Entity\TransactionId;
use App\Transaction\Domain\Exception\TransactionNotFound;

interface TransactionRepository
{
    public function add(Transaction $transaction): void;

    /**
     * @throws TransactionNotFound
     */
    public function get(TransactionId $transactionId): Transaction;

    /**
     * @psalm-return null|list<Transaction>
     */
    public function list(): ?array;

    public function delete(TransactionId $transactionId): void;
}
