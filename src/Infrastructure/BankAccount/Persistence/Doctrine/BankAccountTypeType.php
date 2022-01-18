<?php

declare(strict_types=1);

namespace App\Infrastructure\BankAccount\Persistence\Doctrine;

use App\Core\BankAccount\Domain\ValueObject\BankAccountType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class BankAccountTypeType extends StringType
{
    public const TYPE_NAME = 'bank_account_type';

    public function getName(): string
    {
        return self::TYPE_NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): BankAccountType
    {
        return BankAccountType::from($value);
    }

    /**
     * @param BankAccountType $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->getValue();
    }
}
