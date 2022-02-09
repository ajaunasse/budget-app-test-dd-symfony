<?php

declare(strict_types=1);

namespace App\Infrastructure\Transaction\Persistence\Doctrine;

use App\Shared\BankAccount\Domain\CategoryId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;

final class CategoryIdType extends IntegerType
{
    public const TYPE_NAME = 'category_id';

    public function getName(): string
    {
        return self::TYPE_NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): CategoryId
    {
        return new CategoryId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {

        if (null === $value) {
            return null;
        }

        return $value->getId();
    }

}
