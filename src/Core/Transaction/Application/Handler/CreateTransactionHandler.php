<?php

declare(strict_types=1);

namespace App\Core\Transaction\Application\Handler;

use App\Core\Transaction\Application\Command\CreateTransactionCommand;
use App\Core\Transaction\Domain\Model\Transaction;
use App\Core\Transaction\Domain\Repository\TransactionRepository;
use App\Infrastructure\Bus\Command\CommandHandlerInterface;

final class CreateTransactionHandler implements CommandHandlerInterface
{
    public function __construct(private TransactionRepository $transactionRepository)
    {
    }

    public function __invoke(CreateTransactionCommand $command): void
    {
        $transaction = Transaction::createFromCommand(
            id: $command->id(),
            name: $command->name(),
            amount: $command->amount()->toInt(),
            transactionDate: $command->transactionDate(),
            type: $command->type(),
            categoryId: $command->categoryId()
        );

        $this->transactionRepository
            ->add($transaction)
        ;
    }
}
