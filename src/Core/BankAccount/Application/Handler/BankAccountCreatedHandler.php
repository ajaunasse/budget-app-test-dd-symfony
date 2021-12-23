<?php

namespace App\Core\BankAccount\Application\Handler;

use App\Core\BankAccount\Application\Event\BankAccountCreated;
use App\Core\BankAccount\Domain\Model\BankAccountActivity;
use App\Core\BankAccount\Domain\Repository\BankAccountActivityRepository;
use App\Infrastructure\Bus\AsyncEvent\AsyncEventHandlerInterface;

final class BankAccountCreatedHandler implements AsyncEventHandlerInterface
{
    public function __construct(private BankAccountActivityRepository $bankAccountActivityRepository)
    {
    }

    public function __invoke(BankAccountCreated $bankAccountCreated)
    {
        $bankAccountActivity = BankAccountActivity::newBankAccount(
            $bankAccountCreated->getBankAccountId(),
            $bankAccountCreated->getStartBalance(),
            $bankAccountCreated->getOccuredAt()
        );

        $this->bankAccountActivityRepository->add($bankAccountActivity);
    }
}
