<?php

declare(strict_types=1);

namespace App\Shared\Common\Domain;

use App\Shared\Common\Domain\Exception\InvalidId;

abstract class AbstractId
{
    public function __construct(private int $id)
    {
        if (!$this->validate($id)) {
            throw new InvalidId($id);
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function jsonSerialize(): int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }

    protected function validate($id): bool
    {
        return !is_bool($id) && preg_match('/^[1-9]\d*$/', (string) $id);
    }
}
