<?php

declare(strict_types=1);

namespace App\Transaction\Application;

use App\Transaction\Domain\Entity\Transaction;
use App\Transaction\Domain\Repository\TransactionRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CreateTransactionHandler implements MessageHandlerInterface
{
    public function __construct(private TransactionRepository $transactionRepository)
    {
    }

    public function __invoke(CreateTransactionCommand $command): void
    {
        $transaction = Transaction::createFromCommand(
            name: $command->name(),
            amount: $command->amount()->toInt(),
            transactionDate: $command->transactionDate(),
            type: $command->type()
        );

        $this->transactionRepository
            ->add($transaction)
        ;
    }
}
