<?php

declare(strict_types=1);

namespace App\Core\Transaction\Domain\Exception;

use App\Shared\BankAccount\Domain\CategoryId;
use Exception;

final class CategoryNotFound extends Exception
{
    private const MESSAGE = 'Category doesn\'t not exist for id %s';

    public function __construct(CategoryId $categoryId)
    {
        parent::__construct(sprintf(self::MESSAGE, $categoryId->getId()));
    }
}
