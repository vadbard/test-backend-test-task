<?php

namespace App\DataFixtures;

use App\Factory\ProductFactory;
use App\Service\Price\Price;
use App\Value\Money;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ProductFactory::createOne([
            'name' => 'Iphone',
            'price' => new Price(new Money(10000)),
        ]);

        ProductFactory::createOne([
            'name' => 'Наушники',
            'price' => new Price(new Money(2000)),
        ]);

        ProductFactory::createOne([
            'name' => 'Чехол',
            'price' => new Price(new Money(1000)),
        ]);
    }
}
