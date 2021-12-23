<?php

declare(strict_types=1);

namespace App\Infrastructure\Transaction\Persistence\Doctrine;

use App\Shared\Transaction\Domain\TransactionId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class TransactionIdType extends StringType
{
    public const TYPE_NAME = 'transaction_id';

    public function getName(): string
    {
        return self::TYPE_NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): TransactionId
    {
        return new TransactionId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value;
    }


}
