<?php

declare(strict_types=1);

namespace App\Core\BankAccount\Domain\ValueObject;

use MyCLabs\Enum\Enum;

/**
 * @method static BankAccountActivityType CREATED()
 * @method static BankAccountActivityType CLOSED()
 * @method static BankAccountActivityType TRANSACTION_TRIGGERED()
 */
final class BankAccountActivityType extends Enum
{
    public const CREATED = 'created';
    public const CLOSED = 'closed';
    public const TRANSACTION_TRIGGERED = 'transaction_triggered';
}
