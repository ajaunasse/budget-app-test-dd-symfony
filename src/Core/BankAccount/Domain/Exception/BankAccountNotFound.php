<?php
declare(strict_types=1);

namespace App\Core\BankAccount\Domain\Exception;

use App\Shared\BankAccount\Domain\BankAccountId;
use Exception;

final class BankAccountNotFound extends Exception
{
    private const MESSAGE = 'Bank Account does not exist for id %s';

    public function __construct(BankAccountId $bankAccountId)
    {
        parent::__construct(sprintf(self::MESSAGE, $bankAccountId->value()));
    }
}