<?php

namespace App\Tests\Service\Discount;

use App\Service\Discount\PercentDiscountCalculator;
use App\Value\Money;
use PHPUnit\Framework\TestCase;

class PercentDiscountServiceTest extends TestCase
{
    public function testOk(): void
    {
        $calculator = new PercentDiscountCalculator(50);

        $discount = $calculator->calculateDiscount(new Money(1000));

        $this->assertSame(500, $discount->amount);
    }

    public function testNegativeAmount(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $calculator = new PercentDiscountCalculator(-1);
    }


    public function testExceed100(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $calculator = new PercentDiscountCalculator(101);
    }
}
