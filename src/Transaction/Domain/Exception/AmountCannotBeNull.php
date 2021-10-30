<?php

declare(strict_types=1);

namespace App\Transaction\Domain\Exception;

use Exception;

final class AmountCannotBeNull extends Exception
{
    private const MESSAGE = 'Amount cannot be null';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
