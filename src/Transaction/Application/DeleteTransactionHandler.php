<?php

declare(strict_types=1);

namespace App\Transaction\Application;

use App\Transaction\Domain\Repository\TransactionRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class DeleteTransactionHandler implements MessageHandlerInterface
{
    public function __construct(private TransactionRepository $transactionRepository)
    {
    }

    public function __invoke(DeleteTransactionCommand $command): void
    {
        $this->transactionRepository->delete($command->transactionId());
    }
}
