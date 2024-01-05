<?php

namespace App\Controller\Api;

use App\Service\ItemsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $em, protected ItemsService $itemsService)
    {
    }

    #[Route('/api/items', name: 'app_items')]
    public function getItems(Request $request): Response
    {
        return $this->json($this->itemsService->getItems($request));
    }

    #[Route('/api/item/{id}', name: 'app_item')]
    public function getItem(Request $request): Response
    {
        return $this->json($this->itemsService->getItem($request->get('id')));
    }

    #[Route('/api/alike', name: 'app_alike')]
    public function getAlike(Request $request): Response
    {
        return $this->json($this->itemsService->getAlike());
    }
}
