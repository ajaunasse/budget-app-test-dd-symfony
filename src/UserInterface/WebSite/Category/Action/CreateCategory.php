<?php

declare(strict_types=1);

namespace App\UserInterface\WebSite\Category\Action;

use App\Core\BankAccount\Application\Command\CreateBankAccountCommand;
use App\Core\Transaction\Application\Command\CreateCategoryCommand;
use App\UserInterface\WebSite\BankAccount\Form\CreateBankAccountType;
use App\UserInterface\WebSite\Category\Form\CreateCategoryType;
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

/**
 * @Route("/category/add", name="add_category")
 */
final class CreateCategory
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
        $form = $this->formFactory->create(CreateCategoryType::class);

        $form->handleRequest($request);

        $response = new Response();

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $command = CreateCategoryCommand::fromFormData($form->getData());

                $this->commandBus->dispatch($command);

                $this->session->getFlashBag()->add('success', 'Category créé');

                return new RedirectResponse($this->router->generate('list_category'));
            } catch (\Exception $e) {
                $this->session->getFlashBag()->add('danger', $e->getMessage());
            }
        }

        $response->setContent($this->twig->render('category/create.html.twig', [
            'form' => $form->createView(),
        ]));

        return $response;
    }
}
