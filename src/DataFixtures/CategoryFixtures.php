<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setName('Автотовары');
        $category->setDescription('Автотовары');
        $category->setParent(null);

        $manager->persist($category);
        $manager->flush();
    }
}
