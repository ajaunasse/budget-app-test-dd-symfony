<?php

declare(strict_types=1);

namespace App\Core\Transaction\Application\ViewModel;

final class TransactionListViewModel
{
    private function __construct(private array $transactions)
    {
    }

    public static function fromRepositoryResult(array $result): TransactionListViewModel
    {
        $transactions = [];

        foreach ($result as $value) {
            $transactions[] = new TransactionViewModel(
                transaction: $value['transaction'],
                categoryName: $value['categoryName']
            );
        }
        return new self($transactions);
    }

    public function list(): array
    {
        return $this->transactions;
    }
}
