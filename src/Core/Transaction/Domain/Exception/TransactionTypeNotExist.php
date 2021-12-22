<?php

declare(strict_types=1);

namespace App\Core\Transaction\Domain\Exception;

use App\Core\Transaction\Domain\Model\Transaction;
use Exception;

final class TransactionTypeNotExist extends Exception
{
    private const MESSAGE = 'Transaction type doesn\'t not exist, available type %s';

    public function __construct()
    {
        parent::__construct(sprintf(self::MESSAGE, implode(',', Transaction::TYPES)));
    }
}
