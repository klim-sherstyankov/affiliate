<?php

namespace App\Controller\Api;

use App\Service\ItemsService;
use App\Service\ShopService;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $em, protected ShopService $shopService, protected ItemsService $itemsService)
    {
    }

    #[Route('/api/shop', name: 'app_shop', methods: ['GET'])]
    public function getShops(): Response
    {
        return $this->json($this->shopService->getShops());
    }

    #[Route('/api/shopItems', name: 'app_shop_items', methods: ['GET'])]
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
        name: 'shopId',
        description: 'shop Id',
        in: 'query',
        schema: new OA\Schema(type: 'string')
    )]
    public function getShopsItems(Request $request): Response
    {
        return $this->json($this->itemsService->getShopItems($request));
    }
}
