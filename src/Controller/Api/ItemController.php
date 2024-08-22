<?php

namespace App\Controller\Api;

use App\Service\ItemsService;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $em, protected ItemsService $itemsService)
    {
    }

    #[Route('/api/items', name: 'app_items', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Get all items'
    )]
    #[OA\Parameter(
        name: 'limit',
        description: 'limit',
        in: 'query',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'offset',
        description: 'offset',
        in: 'query',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'sort',
        description: 'sort',
        in: 'query',
        schema: new OA\Schema(type: 'json')
    )]
    public function getItems(Request $request): Response
    {
        return $this->json($this->itemsService->getItems($request));
    }

    #[Route('/api/item/{id}', name: 'app_item', methods: ['GET'])]
    #[OA\Parameter(
        name: 'id',
        description: 'id',
        in: 'query',
        schema: new OA\Schema(type: 'integer')
    )]
    public function getItem(Request $request): Response
    {
        return $this->json($this->itemsService->getItem($request->get('id')));
    }

    #[Route('/api/alike', name: 'app_alike', methods: ['GET'])]
    public function getAlike(Request $request): Response
    {
        return $this->json($this->itemsService->getAlike());
    }
}
