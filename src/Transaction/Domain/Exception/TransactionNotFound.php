<?php

declare(strict_types=1);

namespace App\Transaction\Domain\Exception;

use App\Transaction\Domain\Entity\TransactionId;
use Exception;

final class TransactionNotFound extends Exception
{
    private const MESSAGE = 'Transaction doesn\'t not exist for id %d';

    public function __construct(TransactionId $transactionId)
    {
        parent::__construct(sprintf(self::MESSAGE, $transactionId->id()));
    }
}
