<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Core\Transaction\Domain\Model\Category;
use App\Shared\BankAccount\Domain\CategoryId;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryData extends Fixture
{
    public const FOOD_CATEGORY = 'food';
    public const LOAN_CATEGORY = 'Bank loan';

    public function load(ObjectManager $manager): void
    {
        $categoryFood = Category::createFromViewModel(
            categoryId: new CategoryId(1),
            categoryName: self::FOOD_CATEGORY
        );

        $categoryLoad = Category::createFromViewModel(
            categoryId: new CategoryId(1),
            categoryName: self::LOAN_CATEGORY
        );

        $manager->persist($categoryFood);
        $manager->persist($categoryLoad);

        $manager->flush();

        $this->addReference(self::FOOD_CATEGORY, $categoryFood);
        $this->addReference(self::LOAN_CATEGORY, $categoryLoad);
    }
}
