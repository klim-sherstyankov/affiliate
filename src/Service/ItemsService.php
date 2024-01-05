<?php

namespace App\Service;

use App\Entity\Items;
use Doctrine\ORM\EntityManagerInterface;

class ItemsService
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function getItems(): array
    {
        $data = [];
        $items = $this->em->getRepository(Items::class)->findBy([], ['id' => 'DESC']);

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
            $result['feature'] = $item->getFeature();
            $result['category'] = $item->getCategory()?->getName();

            $data[] = $result;
        }

        return $data;
    }

    public function getItem(mixed $id): array
    {
        $result = [];
        /** @var Items $item */
        $item = $this->em->getRepository(Items::class)->findOneBy(['id' => $id]);

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
            $result['feature'] = $item->getFeature();
            $result['category'] = $item->getCategory()?->getName();
        }

        return $result;
    }

    public function getSearchItems(mixed $search): array
    {
        $data = [];
        /** @var Items $item */
        $items = $this->em->getRepository(Items::class)->findBySearch($search);

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
            $result['feature'] = $item->getFeature();
            $result['category'] = $item->getCategory()?->getName();

            $data[] = $result;
        }

        return $data;
    }
}
