<?php

declare(strict_types=1);

namespace App\UserInterface\WebSite\Transaction\Form;

use App\Core\Transaction\Domain\Model\Category;
use App\Core\Transaction\Domain\Model\Transaction;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

final class CreateTransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('amount', NumberType::class)
            ->add('transactionDate', DateType::class, [
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
            ])

            ->add('type', ChoiceType::class, [
                'choices' => array_flip(Transaction::TYPES),
            ])
            ->add('category', EntityType::class, [
               'class' => Category::class,
                'choice_name' => function (?Category $category) {
                    return $category ? $category->name() : '';
                },
                'choice_value' => function (?Category $category) {
                    return $category ? $category->id() : '';
                },
            ])

            ->add('submit', SubmitType::class)
        ;
    }
}
