<?php

namespace App\Factory;

use App\Entity\Video;
use App\Repository\VideoRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Video>
 *
 * @method        Video|Proxy create(array|callable $attributes = [])
 * @method static Video|Proxy createOne(array $attributes = [])
 * @method static Video|Proxy find(object|array|mixed $criteria)
 * @method static Video|Proxy findOrCreate(array $attributes)
 * @method static Video|Proxy first(string $sortedField = 'id')
 * @method static Video|Proxy last(string $sortedField = 'id')
 * @method static Video|Proxy random(array $attributes = [])
 * @method static Video|Proxy randomOrCreate(array $attributes = [])
 * @method static VideoRepository|RepositoryProxy repository()
 * @method static Video[]|Proxy[] all()
 * @method static Video[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Video[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Video[]|Proxy[] findBy(array $attributes)
 * @method static Video[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Video[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class VideoFactory extends ModelFactory
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
        $end = self::faker()->regexify('[a-z]{2}[A-Z]{1}[0-9]{1}[a-z]{2}[A-Z]{1}[a-z]{2}[0-9]{1}A-Z]{1}');
        $link = "https://youtu.be/" . $end;
        return [
            'updatedAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'link' => $link,
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Video $video): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Video::class;
    }
}
