<?php

declare(strict_types=1);

namespace App\UserInterface\WebSite\Transaction\Action;

use App\Core\Transaction\Domain\Exception\TransactionNotFound;
use App\Core\Transaction\Domain\Repository\TransactionRepository;
use App\Shared\Transaction\Domain\TransactionId;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route(
 *     "/transaction/show/{id}",
 *     name="show_transaction"
 * )
 */
final class ShowTransaction
{
    public function __construct(
        private TransactionRepository $transactionRepository,
        private Environment $twig,
    ) {
    }

    public function __invoke(Request $request, string $id): Response
    {
        try {
            $transaction = $this->transactionRepository
                ->get(new TransactionId($id))
            ;
        } catch (TransactionNotFound $e) {
            return new Response($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        return new Response($this->twig->render('transaction/show.html.twig', [
            'transaction' => $transaction,
        ]));
    }
}
