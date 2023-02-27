<?php

namespace App\Factory;

use App\Entity\Image;
use App\Repository\ImageRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Image>
 *
 * @method        Image|Proxy create(array|callable $attributes = [])
 * @method static Image|Proxy createOne(array $attributes = [])
 * @method static Image|Proxy find(object|array|mixed $criteria)
 * @method static Image|Proxy findOrCreate(array $attributes)
 * @method static Image|Proxy first(string $sortedField = 'id')
 * @method static Image|Proxy last(string $sortedField = 'id')
 * @method static Image|Proxy random(array $attributes = [])
 * @method static Image|Proxy randomOrCreate(array $attributes = [])
 * @method static ImageRepository|RepositoryProxy repository()
 * @method static Image[]|Proxy[] all()
 * @method static Image[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Image[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Image[]|Proxy[] findBy(array $attributes)
 * @method static Image[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Image[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class ImageFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        // self::faker->image("/public/images/tricks_pictures/");
        return [
            'name' => self::faker()->randomElement([
                'pexels-john-robertnicoud-38242-63fcd95f69307834351447.jpg',
                'flip0-63f4e14056f57019997248.jpg', 
                'lucas-ludwig-kvbvijaxfpc-unsplash-63cbbb5d40777551381705.jpg', 
                'lucian-dachman-cbwtzaikaac-unsplash-63eb650c5400c595573319.jpg', 
                'pexels-john-robertnicoud-38242-63da7a3e805d3541655224.jpg'
            ]),
            'updatedAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Image $image): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Image::class;
    }
}
