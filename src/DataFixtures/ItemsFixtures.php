<?php

namespace App\DataFixtures;

use App\Entity\Items;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ItemsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Items();
        $product->setUrl('https://github.com/klim-sherstyankov');
        $product->setDescription('Описание товара');
        $product->setPrice(11.1);
        $product->setPriceOffPercent(5);
        $product->setShortName('Короткое имя товара');
        $manager->persist($product);

        $manager->flush();
    }
}
