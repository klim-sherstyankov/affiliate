<?php

namespace App\Controller\Api;

use App\Entity\Items;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/api/items', name: 'app_items')]
    public function index(): Response
    {
        $data = [];
        $items = $this->em->getRepository(Items::class)->findAll();

        /** @var Items $item */
        foreach ($items as $item) {
            $result['id'] = $item->getId();
            $result['price'] = $item->getPrice();
            $result['shortName'] = $item->getShortName();
            $result['url'] = $item->getUrl();
            $result['shopName'] = $item->getShopId()?->getName();
            $result['shopImg'] = $item->getShopId()?->getImage();
            $result['description'] = $item->getDescription();
            $result['priceOffPercent'] = $item->getPriceOffPercent();
            $result['salePrice'] = $item->getSalePrice();
            $result['image'] = $item->getImage();

            $data[] = $result;
        }

        return $this->json($data);
    }

    #[Route('/api/item/{id}', name: 'app_item')]
    public function getItem(Request $request): Response
    {
        $result = [];
        /** @var Items $item */
        $item = $this->em->getRepository(Items::class)->findOneBy(['id' => $request->get('id')], ['id' => 'ASC']);

        if (null !== $item) {
            $result['id'] = $item->getId();
            $result['price'] = $item->getPrice();
            $result['shortName'] = $item->getShortName();
            $result['url'] = $item->getUrl();
            $result['shopName'] = $item->getShopId()?->getName();
            $result['shopImg'] = $item->getShopId()?->getImage();
            $result['description'] = $item->getDescription();
            $result['priceOffPercent'] = $item->getPriceOffPercent();
            $result['salePrice'] = $item->getSalePrice();
            $result['image'] = $item->getImage();
        }

        return $this->json($result);
    }
}
