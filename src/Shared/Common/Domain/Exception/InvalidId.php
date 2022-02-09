<?php

declare(strict_types=1);

namespace App\Shared\Common\Domain\Exception;

use Exception;

final class InvalidId extends Exception
{
    private const MESSAGE = 'The id %s is invalid, numeric value expected';

    public function __construct(mixed $value)
    {
        parent::__construct(sprintf(self::MESSAGE, $value));
    }
}
