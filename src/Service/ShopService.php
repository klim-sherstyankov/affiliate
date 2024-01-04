<?php

namespace App\Service;

use App\Entity\Items;
use App\Entity\Shop;
use Doctrine\ORM\EntityManagerInterface;

class ShopService
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function getShops(): array
    {
        $data = [];
        $shops = $this->em->getRepository(Shop::class)->findAll();

        /** @var Shop $shop */
        foreach ($shops as $shop) {
            $result['id'] = $shop->getId();
            $result['name'] = $shop->getName();
            $result['url'] = $shop->getUrl();
            $result['image'] = $shop->getImage();
            $result['description'] = $shop->getDescription();

            $data[] = $result;
        }

        return $data;
    }
}
