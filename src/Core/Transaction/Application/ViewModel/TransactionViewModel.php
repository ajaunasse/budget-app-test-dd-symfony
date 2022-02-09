<?php

declare(strict_types=1);

namespace App\Core\Transaction\Application\ViewModel;

use App\Core\Transaction\Domain\Model\Category;
use App\Core\Transaction\Domain\Model\Transaction;
use App\Shared\Transaction\Domain\TransactionId;
use DateTimeImmutable;

final class TransactionViewModel
{
    public function __construct(
        private Transaction $transaction,
        private string $categoryName
    ) {
    }

    public function id(): TransactionId
    {
        return $this->transaction->getId();
    }

    public function name(): string
    {
        return $this->transaction->name();
    }

    public function amount(): float
    {
        return $this->transaction->formattedAmount();
    }

    public function transactionDate(): DateTimeImmutable
    {
        return $this->transaction->transactionDate();
    }

    public function category(): Category
    {
        return Category::createFromViewModel(
            categoryId: $this->transaction->categoryId(),
            categoryName: $this->categoryName
        );
    }
}
