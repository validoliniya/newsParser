<?php

namespace App\DataFixtures;

use App\Entity\NewsResource;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NewsResourceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $resource = (new NewsResource())
            ->setName(NewsResource::RBK)
            ->setUrl('https://www.rbc.ru/');
        $manager->persist($resource);
        $manager->flush();
    }
}
