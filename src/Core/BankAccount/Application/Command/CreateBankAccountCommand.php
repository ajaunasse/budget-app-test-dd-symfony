<?php

declare(strict_types=1);

namespace App\Core\BankAccount\Application\Command;

use App\Core\BankAccount\Domain\Exception\BankAccountTypeNotExist;
use App\Core\BankAccount\Domain\ValueObject\BankAccountType;
use App\Shared\BankAccount\Domain\BankAccountId;
use App\Shared\Common\Domain\Uuid;
use App\Shared\Common\Domain\ValueObject\Amount;

final class CreateBankAccountCommand
{
    private function __construct(
        private BankAccountId $bankAccountId,
        private string $name,
        private BankAccountType $bankAccountType,
        private Amount $startBalance,
        private bool $mainAccount = false
    ) {
    }

    public static function fromFormData(array $formData): CreateBankAccountCommand
    {
        if (!BankAccountType::isValid($formData['type'])) {
            throw new BankAccountTypeNotExist($formData['type']);
        }

        return new self(
            bankAccountId: new BankAccountId(Uuid::random()),
            name: $formData['name'],
            bankAccountType: BankAccountType::from($formData['type']),
            startBalance: Amount::fromUnformattedValue($formData['currentBalance']),
            mainAccount: $formData['mainAccount'] ?? false
        );
    }

    public function getBankAccountId(): BankAccountId
    {
        return $this->bankAccountId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBankAccountType(): BankAccountType
    {
        return $this->bankAccountType;
    }

    public function getStartBalance(): int
    {
        return $this->startBalance->toInt();
    }

    public function isMainAccount(): bool
    {
        return $this->mainAccount;
    }
}
