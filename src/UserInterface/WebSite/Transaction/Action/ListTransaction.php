<?php

namespace App\UserInterface\WebSite\Transaction\Action;

use App\Core\Transaction\Application\ViewModel\TransactionListViewModel;
use App\Core\Transaction\Domain\Repository\TransactionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route("/transaction/list", name="list_transaction")
 */
final class ListTransaction
{
    public function __construct(
        private TransactionRepository $transactionRepository,
        private Environment $templating
    ) {
    }

    public function __invoke(): Response
    {
        return new Response(
            $this->templating->render('transaction/list.html.twig', [
                'transactions' => TransactionListViewModel::fromRepositoryResult($this->transactionRepository->list()),
            ])
        );
    }
}
