<?php

declare(strict_types=1);

namespace App\Transaction\UseCase;

use App\Transaction\Application\DeleteTransactionCommand;
use App\Transaction\Domain\Entity\TransactionId;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * @Route(
 *     "/transaction/delete/{id}",
 *     name="delete_transaction",
 *     requirements={"id"="\d+"}
 * )
 */
final class DeleteTransaction
{
    private Session $session;

    public function __construct(
        private RouterInterface $router,
        private MessageBusInterface $commandBus,
        private RequestStack $requestStack
    ) {
        $this->session = $this->requestStack->getSession();
    }

    public function __invoke(Request $request, int $id): Response
    {
        try {
            $command = DeleteTransactionCommand::generate(new TransactionId($id));

            $this->commandBus->dispatch($command);

            $this->session->getFlashBag()->add('success', 'Transaction supprimée');
        } catch (Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        return new RedirectResponse($this->router->generate('list_transaction'));
    }
}
