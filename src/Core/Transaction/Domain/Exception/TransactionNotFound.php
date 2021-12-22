<?php

declare(strict_types=1);

namespace App\Core\Transaction\Domain\Exception;

use Exception;
use App\Shared\Transaction\Domain\TransactionId;

final class TransactionNotFound extends Exception
{
    private const MESSAGE = 'Transaction doesn\'t not exist for id %s';

    public function __construct(TransactionId $transactionId)
    {
        parent::__construct(sprintf(self::MESSAGE, $transactionId->value()));
    }
}
