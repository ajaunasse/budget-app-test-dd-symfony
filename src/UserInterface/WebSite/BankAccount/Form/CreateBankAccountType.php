<?php

declare(strict_types=1);

namespace App\UserInterface\WebSite\BankAccount\Form;

use App\Core\BankAccount\Domain\ValueObject\BankAccountType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class CreateBankAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('currentBalance', MoneyType::class)
            ->add('type', ChoiceType::class, [
                'choices' => array_flip(BankAccountType::toArray()),
            ])
            ->add('mainAccount', CheckboxType::class)

            ->add('submit', SubmitType::class)
        ;
    }
}
