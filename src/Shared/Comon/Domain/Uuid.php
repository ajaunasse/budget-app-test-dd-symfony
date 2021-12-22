<?php

declare(strict_types=1);

namespace App\Shared\Comon\Domain;

use InvalidArgumentException;
use Stringable;
use Symfony\Component\Uid\Uuid as SymfonyUuid;

class Uuid implements Stringable
{
    public function __construct(protected string $uuid)
    {
        $this->ensureIsValidUuid($uuid);
    }

    public static function random(): string
    {
        return SymfonyUuid::v4()->toRfc4122();
    }

    public function value(): string
    {
        return $this->uuid;
    }

    public function equals(Uuid $other): bool
    {
        return $this->value() === $other->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }

    private function ensureIsValidUuid(string $id): void
    {
        if (!SymfonyUuid::isValid($id)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $id));
        }
    }
}
