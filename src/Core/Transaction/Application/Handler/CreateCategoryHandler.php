<?php

declare(strict_types=1);

namespace App\Core\Transaction\Application\Handler;

use App\Core\Transaction\Application\Command\CreateCategoryCommand;
use App\Core\Transaction\Domain\Model\Category;
use App\Core\Transaction\Domain\Repository\CategoryRepository;
use App\Infrastructure\Bus\Command\CommandHandlerInterface;

final class CreateCategoryHandler implements CommandHandlerInterface
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    public function __invoke(CreateCategoryCommand $command): void
    {
        $category = Category::createFromCommand(
            name: $command->name(),
        );

        $this->categoryRepository
            ->add($category)
        ;
    }
}
