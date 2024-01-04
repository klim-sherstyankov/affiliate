<?php

namespace App\Controller\Api;

use App\Service\ShopService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $em, protected ShopService $shopService)
    {
    }

    #[Route('/api/shop', name: 'app_shop')]
    public function getShops(): Response
    {
        return $this->json($this->shopService->getShops());
    }
}
