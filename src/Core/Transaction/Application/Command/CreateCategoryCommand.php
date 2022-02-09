<?php

declare(strict_types=1);

namespace App\Core\Transaction\Application\Command;


final class CreateCategoryCommand
{
    private function __construct(
        private string $name
    ) {
    }

    /**
     * @psalm-param array{
     *   name: string
     * }
     *
     * @param array<string, mixed> $formData
     */
    public static function fromFormData(array $formData): self
    {
        return new self(
            name: $formData['name']
        );
    }

    public function name(): string
    {
        return $this->name;
    }
}
