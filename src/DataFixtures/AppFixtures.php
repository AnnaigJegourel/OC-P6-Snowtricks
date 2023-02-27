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
        CategoryFactory::createMany(5);

        TrickFactory::createMany(
            25,
            function() {
                return ['category' => CategoryFactory::random()];
            }
        );

        VideoFactory::createMany(
            30,
            function() {
                return [
                    'trick' => TrickFactory::random()
                ];
            }
        );

        ImageFactory::createMany(
            30,
            function() {
                return [
                    'trick' => TrickFactory::random()
                ];
            }
        );
    
        UserFactory::createMany(5);

        CommentFactory::createMany(
            50,
            function() {
                return [
                    'author' => UserFactory::random(),
                    'trick' => TrickFactory::random()
                ];
            }
        );

        $manager->flush();
    }
}
