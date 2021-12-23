<?php

declare(strict_types=1);

namespace App\Core\BankAccount\Domain\Exception;

use Exception;

final class BankAccountActivityNotFound extends Exception
{
    private const MESSAGE = 'Bank Account activity does not exist for id %d';

    public function __construct(int $bankAccountActivityId)
    {
        parent::__construct(sprintf(self::MESSAGE, $bankAccountActivityId));
    }
}
