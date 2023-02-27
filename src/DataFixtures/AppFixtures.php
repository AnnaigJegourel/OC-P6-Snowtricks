<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\TrickFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        CategoryFactory::createMany(2);

        TrickFactory::createMany(
            6,
            function() {
                return ['category' => CategoryFactory::random()];
            }
        );

        $manager->flush();
    }
}
