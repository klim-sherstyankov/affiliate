<?php

namespace App\Controller\Api;

use App\Service\ItemsService;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $em, protected ItemsService $itemsService)
    {
    }

    #[Route('/api/search', name: 'app_search_items', methods: ['GET'])]
    #[OA\Parameter(
        name: 's',
        description: 'search',
        in: 'query',
        schema: new OA\Schema(type: 'string')
    )]
    public function getSearchItems(Request $request): Response
    {
        return $this->json($this->itemsService->getSearchItems($request->get('s')));
    }
}
