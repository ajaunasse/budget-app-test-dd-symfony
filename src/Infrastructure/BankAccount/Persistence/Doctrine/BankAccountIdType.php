<?php

declare(strict_types=1);

namespace App\Infrastructure\BankAccount\Persistence\Doctrine;

use App\Shared\BankAccount\Domain\BankAccountId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class BankAccountIdType extends StringType
{
    public const TYPE_NAME = 'bank_account_id';

    public function getName(): string
    {
        return self::TYPE_NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): BankAccountId
    {
        return new BankAccountId($value);
    }

    /**
     * @param BankAccountId $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value();
    }


}
