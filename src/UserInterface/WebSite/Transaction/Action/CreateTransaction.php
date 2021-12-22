<?php

declare(strict_types=1);

namespace App\UserInterface\WebSite\Transaction\Action;

use App\Core\Transaction\Application\Command\CreateTransactionCommand;
use App\Shared\Comon\Domain\Uuid;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;
use App\UserInterface\WebSite\Transaction\Form\CreateTransactionType;

/**
 * @Route("/transaction/create", name="create_transaction")
 */
final class CreateTransaction
{
    private SessionInterface $session;

    public function __construct(
        private FormFactoryInterface $formFactory,
        private Environment $twig,
        private MessageBusInterface $commandBus,
        private RequestStack $requestStack,
        private RouterInterface $router
    ) {
        $this->session = $this->requestStack->getSession();
    }

    public function __invoke(Request $request): Response
    {

        $form = $this->formFactory->create(CreateTransactionType::class);

        $form->handleRequest($request);

        $response = new Response();

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $command = CreateTransactionCommand::fromFormData($form->getData());

                $this->commandBus->dispatch($command);

                /* @phpstan-ignore-next-line */
                $this->session->getFlashBag()->add('success', 'Transaction prise en compte');

                return new RedirectResponse($this->router->generate('list_transaction'));
            } catch (\Exception $e) {

                /* @phpstan-ignore-next-line */
                $this->session->getFlashBag()->add('danger', $e->getMessage());
            }
        }

        $response->setContent($this->twig->render('transaction/create.html.twig', [
            'form' => $form->createView(),
        ]));

        return $response;
    }
}
