<?php

namespace App\DataFixtures;

use App\Enum\CouponTypeEnum;
use App\Factory\CouponFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CouponFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        CouponFactory::createOne([
            'type' => CouponTypeEnum::DiscountAmount,
            'value' => 500,
            'code' => 'A-5',
        ]);

        CouponFactory::createOne([
            'type' => CouponTypeEnum::DiscountPercent,
            'value' => 10,
            'code' => 'P-10',
        ]);
    }
}
