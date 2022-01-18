<?php

declare(strict_types=1);

namespace App\Core\Transaction\Domain\Repository;

use App\Core\Transaction\Domain\Exception\TransactionNotFound;
use App\Core\Transaction\Domain\Model\Transaction;
use App\Shared\Transaction\Domain\TransactionId;

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
