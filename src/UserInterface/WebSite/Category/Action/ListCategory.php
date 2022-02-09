<?php

declare(strict_types=1);

namespace App\UserInterface\WebSite\Category\Action;

use App\Core\Transaction\Domain\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route("/category/list", name="list_category")
 */
final class ListCategory
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private Environment $templating
    ) {
    }

    public function __invoke(): Response
    {
        return new Response(
            $this->templating->render('category/list.html.twig', [
                'categories' => $this->categoryRepository->list(),
            ])
        );
    }
}
