<?php

namespace App\Factory;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Trick>
 *
 * @method        Trick|Proxy create(array|callable $attributes = [])
 * @method static Trick|Proxy createOne(array $attributes = [])
 * @method static Trick|Proxy find(object|array|mixed $criteria)
 * @method static Trick|Proxy findOrCreate(array $attributes)
 * @method static Trick|Proxy first(string $sortedField = 'id')
 * @method static Trick|Proxy last(string $sortedField = 'id')
 * @method static Trick|Proxy random(array $attributes = [])
 * @method static Trick|Proxy randomOrCreate(array $attributes = [])
 * @method static TrickRepository|RepositoryProxy repository()
 * @method static Trick[]|Proxy[] all()
 * @method static Trick[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Trick[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Trick[]|Proxy[] findBy(array $attributes)
 * @method static Trick[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Trick[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class TrickFactory extends ModelFactory
{
    protected $slugger;

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        $name = self::faker()->words(2, true);

        return [
            'description' => self::faker()->paragraph(),
            'name' => $name,
            'slug' => $this->slugger->slug($name),
            'updatedAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Trick $trick): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Trick::class;
    }
}
