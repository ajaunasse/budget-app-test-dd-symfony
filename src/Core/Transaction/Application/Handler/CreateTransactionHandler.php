<?php

declare(strict_types=1);

namespace App\Core\Transaction\Application\Handler;

use App\Core\Transaction\Application\Command\CreateTransactionCommand;
use App\Core\Transaction\Domain\Model\Transaction;
use App\Core\Transaction\Domain\Repository\TransactionRepository;
use App\Shared\Transaction\Domain\TransactionId;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CreateTransactionHandler implements MessageHandlerInterface
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
            type: $command->type()
        );

        $this->transactionRepository
            ->add($transaction)
        ;
    }
}
