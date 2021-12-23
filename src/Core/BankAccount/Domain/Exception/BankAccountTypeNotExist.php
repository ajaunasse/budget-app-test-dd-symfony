<?php

declare(strict_types=1);

namespace App\Core\BankAccount\Domain\Exception;

use App\Core\BankAccount\Domain\ValueObject\BankAccountType;
use Exception;

final class BankAccountTypeNotExist extends Exception
{
    private const MESSAGE = 'Bank Account type %s does not exist, available values are (%s)';

    public function __construct(string $wrongType)
    {
        parent::__construct(sprintf(self::MESSAGE, $wrongType, implode(',', BankAccountType::toArray())));
    }
}
