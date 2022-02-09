<?php

namespace App\Core\Transaction\Infrastructure\Persistence;

use App\Core\Transaction\Domain\Exception\CategoryNotFound;
use App\Core\Transaction\Domain\Model\Category;
use App\Core\Transaction\Domain\Repository\CategoryRepository;
use App\Shared\BankAccount\Domain\CategoryId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
final class OrmCategoryRepository extends ServiceEntityRepository implements CategoryRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function add(Category $category): void
    {
        $this->_em->persist($category);
        $this->_em->flush();
    }

    /**
     * @throws CategoryNotFound
     */
    public function get(CategoryId $categoryId): Category
    {
        $category = $this->find($categoryId);

        if (null == $category) {
            throw new CategoryNotFound($categoryId);
        }

        return $category;
    }

    /**
     * @psalm-return null|list<Category>
     */
    public function list(): ?array
    {
        return $this->findAll();
    }

    public function delete(CategoryId $categoryId): void
    {
        $transaction = $this->get($categoryId);

        $this->_em->remove($transaction);

        $this->_em->flush();
    }
}
