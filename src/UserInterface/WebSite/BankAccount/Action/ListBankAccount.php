<?php

declare(strict_types=1);

namespace App\UserInterface\WebSite\BankAccount\Action;

use App\Core\BankAccount\Domain\Repository\BankAccountRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route("/bank-account/list", name="list_bank_account")
 */
final class ListBankAccount
{
    public function __construct(
        private BankAccountRepository $bankAccountRepository,
        private Environment $templating
    ) {
    }

    public function __invoke(): Response
    {
        return new Response(
            $this->templating->render('bank_account/list.html.twig', [
                'bankAccounts' => $this->bankAccountRepository->list(),
            ])
        );
    }
}
