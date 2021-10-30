<?php

declare(strict_types=1);

namespace App\Transaction\Domain\Exception;

use App\Transaction\Domain\Entity\Transaction;
use Exception;

final class TransactionTypeNotExist extends Exception
{
    private const MESSAGE = 'Transaction type doesn\'t not exist, available type %s';

    public function __construct()
    {
        parent::__construct(sprintf(self::MESSAGE, implode(',', Transaction::TYPES)));
    }
}
