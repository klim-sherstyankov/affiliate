<?php

namespace App\DataFixtures;

use App\Entity\Redirects;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RedirectFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $redirects = new Redirects();
        $redirects->setSourceUrl('0001');
        $redirects->setDestinationUrl('https://www.pepper.ru/new');

        $manager->persist($redirects);
        $manager->flush();
    }
}
