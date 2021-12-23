<?php

declare(strict_types=1);

namespace App\Core\BankAccount\Domain\ValueObject;

use MyCLabs\Enum\Enum;

/**
 * @method static BankAccountType CURRENT()
 * @method static BankAccountType SAVING()
 */
final class BankAccountType extends Enum
{
    public const CURRENT = 'CURRENT';
    public const SAVING = 'SAVING';
}
