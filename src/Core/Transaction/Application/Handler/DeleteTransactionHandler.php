<?php

declare(strict_types=1);

namespace App\Core\Transaction\Application\Handler;

use App\Core\Transaction\Application\Command\DeleteTransactionCommand;
use App\Core\Transaction\Domain\Repository\TransactionRepository;
use App\Infrastructure\Bus\Command\CommandHandlerInterface;

final class DeleteTransactionHandler implements CommandHandlerInterface
{
    public function __construct(private TransactionRepository $transactionRepository)
    {
    }

    public function __invoke(DeleteTransactionCommand $command): void
    {
        $this->transactionRepository->delete($command->transactionId());
    }
}
