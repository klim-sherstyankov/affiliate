<?php

namespace App\Service;

use App\Entity\Items;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ItemsService
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    /**
     * @throws \JsonException
     */
    public function getItems(Request $request): array
    {
        $data = [];
        $limit = $request->get('limit', 30);
        $offset = $request->get('offset', 0);
        $shop = $request->get('shop', []);
        $sortString = (string) $request->get('sort');
        $sort = (array) json_decode($sortString, false);
        $items = $this->em->getRepository(Items::class)->findBy(['shopId' => $shop], $sort, $limit, $offset);

        /** @var Items $item */
        foreach ($items as $item) {
            $data[] = $this->getResultArray($item);
        }

        return $data;
    }

    public function getShopItems(Request $request): array
    {
        $data = [];
        $limit = $request->get('limit', 30);
        $offset = $request->get('offset', 0);
        $sortString = (string) $request->get('sort');
        $sort = (array) json_decode($sortString, false);
        $shopId = $request->get('shopId');

        $items = $this->em->getRepository(Items::class)->findBy(['shopId' => $shopId], $sort, $limit, $offset);

        /** @var Items $item */
        foreach ($items as $item) {
            $data[] = $this->getResultArray($item);
        }

        return $data;
    }

    public function getAlike(): array
    {
        $data = [];
        $items = $this->em->getRepository(Items::class)->findBy([], ['id' => 'DESC'], 5);

        /** @var Items $item */
        foreach ($items as $item) {
            $data[] = $this->getResultArray($item);
        }

        return $data;
    }

    public function getItem(mixed $id): array
    {
        /** @var Items $item */
        $item = $this->em->getRepository(Items::class)->findOneBy(['id' => $id]);

        return null !== $item ? $this->getResultArray($item) : [];
    }

    public function getSearchItems(mixed $search): array
    {
        $data = [];
        /** @var Items $item */
        $items = $this->em->getRepository(Items::class)->findBySearch($search);

        foreach ($items as $item) {
            $data[] = $this->getResultArray($item);
        }

        return $data;
    }

    public function getResultArray(Items $item): array
    {
        $result['id'] = $item->getId();
        $result['price'] = $item->getPrice();
        $result['shortName'] = $item->getShortName();
        $result['url'] = $item->getUrl();
        $result['shopId'] = $item->getShopId()?->getId();
        $result['shopName'] = $item->getShopId()?->getName();
        $result['shopImg'] = $item->getShopId()?->getImage();
        $result['description'] = $item->getDescription();
        $result['priceOffPercent'] = $item->getPriceOffPercent();
        $result['salePrice'] = $item->getSalePrice();
        $result['image'] = $item->getImage();
        $result['feature'] = $item->getFeature();
        $result['category'] = $item->getCategory()?->getName();

        return $result;
    }
}
