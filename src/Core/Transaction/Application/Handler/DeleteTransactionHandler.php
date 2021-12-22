<?php

declare(strict_types=1);

namespace App\Core\Transaction\Application\Handler;

use App\Core\Transaction\Application\Command\DeleteTransactionCommand;
use App\Core\Transaction\Domain\Repository\TransactionRepository;
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
