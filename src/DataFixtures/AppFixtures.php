<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\CommentFactory;
use App\Factory\ImageFactory;
use App\Factory\TrickFactory;
use App\Factory\UserFactory;
use App\Factory\VideoFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        CategoryFactory::createMany(5);

        TrickFactory::createMany(
            5,
            function() {
                return ['category' => CategoryFactory::random()];
            }
        );

        VideoFactory::createMany(
            2,
            function() {
                return [
                    'trick' => TrickFactory::random()
                ];
            }
        );

        ImageFactory::createMany(
            2,
            function() {
                return [
                    'trick' => TrickFactory::random()
                ];
            }
        );
    
        UserFactory::createMany(5);

        CommentFactory::createMany(
            5,
            function() {
                return [
                    'author' => UserFactory::random(),
                    'trick' => TrickFactory::random()
                ];
            }
        );
        // CommentFactory::createMany(2);

        $manager->flush();
    }
}
