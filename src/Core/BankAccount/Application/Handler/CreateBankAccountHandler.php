<?php

declare(strict_types=1);

namespace App\Core\BankAccount\Application\Handler;

use App\Core\BankAccount\Application\Command\CreateBankAccountCommand;
use App\Core\BankAccount\Domain\Model\BankAccount;
use App\Core\BankAccount\Domain\Repository\BankAccountRepository;
use App\Infrastructure\Bus\Command\CommandHandlerInterface;

final class CreateBankAccountHandler implements CommandHandlerInterface
{
    public function __construct(
        private BankAccountRepository $bankAccountRepository
    ) {
    }

    public function __invoke(CreateBankAccountCommand $bankAccountCommand)
    {
        $bankAccount = BankAccount::createFromCommand(
            bankAccountId: $bankAccountCommand->getBankAccountId(),
            name: $bankAccountCommand->getName(),
            bankAccountType: $bankAccountCommand->getBankAccountType(),
            startBalance: $bankAccountCommand->getStartBalance(),
            mainAccount: $bankAccountCommand->isMainAccount()
        );

        $this->bankAccountRepository->add($bankAccount);
    }
}
