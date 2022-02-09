<?php

declare(strict_types=1);

namespace App\Core\Transaction\Domain\Model;

use App\Shared\BankAccount\Domain\CategoryId;

final class Category
{
    private ?CategoryId $id;

    private string $name;

    private function __construct()
    {
    }

    public static function createFromCommand(string $name): Category
    {
        $self = new self();

        $self->name = $name;

        return $self;
    }

    public static function createFromViewModel(CategoryId $categoryId, string $categoryName): Category
    {
        $self = new self();
        $self->id = $categoryId;
        $self->name = $categoryName;

        return $self;
    }

    public function id(): ?CategoryId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->name();
    }
}
