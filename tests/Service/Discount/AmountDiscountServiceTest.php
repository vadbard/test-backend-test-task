<?php

namespace App\Tests\Service\Discount;

use App\Service\Discount\AmountDiscountCalculator;
use App\Value\Money;
use PHPUnit\Framework\TestCase;

class AmountDiscountServiceTest extends TestCase
{
    public function testOk(): void
    {
        $calculator = new AmountDiscountCalculator(50);

        $discount = $calculator->calculateDiscount(new Money(1000));

        $this->assertSame(50, $discount->amount);
    }

    public function testNegativeAmount(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $calculator = new AmountDiscountCalculator(-1);
    }
}
