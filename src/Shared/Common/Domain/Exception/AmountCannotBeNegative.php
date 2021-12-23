<?php

declare(strict_types=1);

namespace App\Shared\Common\Domain\Exception;

use Exception;

final class AmountCannotBeNegative extends Exception
{
    private const MESSAGE = 'Amount cannot be negative';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
