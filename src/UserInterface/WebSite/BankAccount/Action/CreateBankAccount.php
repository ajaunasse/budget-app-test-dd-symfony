<?php

declare(strict_types=1);

namespace App\UserInterface\WebSite\BankAccount\Action;

use App\Core\BankAccount\Application\Command\CreateBankAccountCommand;
use App\UserInterface\WebSite\BankAccount\Form\CreateBankAccountType;
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
 * @Route("/bank-account/add", name="add_bank_account")
 */
final class CreateBankAccount
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

        $form = $this->formFactory->create(CreateBankAccountType::class);

        $form->handleRequest($request);

        $response = new Response();

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $command = CreateBankAccountCommand::fromFormData($form->getData());

                $this->commandBus->dispatch($command);

                /* @phpstan-ignore-next-line */
                $this->session->getFlashBag()->add('success', 'Compte bancaire créé');

                return new RedirectResponse($this->router->generate('list_bank_account'));
            } catch (\Exception $e) {

                /* @phpstan-ignore-next-line */
                $this->session->getFlashBag()->add('danger', $e->getMessage());
            }
        }

        $response->setContent($this->twig->render('bank_account/create.html.twig', [
            'form' => $form->createView(),
        ]));

        return $response;
    }
}
