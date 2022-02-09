<?php

declare(strict_types=1);

namespace App\Core\Transaction\Domain\Repository;

use App\Core\Transaction\Domain\Exception\CategoryNotFound;
use App\Core\Transaction\Domain\Model\Category;
use App\Shared\BankAccount\Domain\CategoryId;

interface CategoryRepository
{
    public function add(Category $category): void;

    /**
     * @throws CategoryNotFound
     */
    public function get(CategoryId $categoryId): Category;

    /**
     * @psalm-return null|list<Category>
     */
    public function list(): ?array;

    public function delete(CategoryId $categoryId): void;
}
