<?php

declare(strict_types=1);

namespace App\Transaction\UseCase;

use App\Transaction\Domain\Entity\TransactionId;
use App\Transaction\Domain\Exception\TransactionNotFound;
use App\Transaction\Domain\Repository\TransactionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route(
 *     "/transaction/show/{id}",
 *     name="show_transaction",
 *     requirements={"id"="\d+"}
 * )
 */
final class ShowTransaction
{
    public function __construct(
        private TransactionRepository $transactionRepository,
        private Environment $twig,
    ) {
    }

    public function __invoke(Request $request, int $id): Response
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
