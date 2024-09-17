<?php

namespace App\Tests\Service\Price;

use App\Entity\Coupon;
use App\Service\Discount\DiscountCalculatorInterface;
use App\Service\Price\Price;
use App\Service\Tax\TaxInterface;
use App\Value\Money;
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    public function testGetMoneyWithoutCouponOrTax(): void
    {
        $money = new Money(100);
        $price = new Price($money);

        $this->assertEquals($money, $price->getMoney());
    }

    public function testAddCoupon(): void
    {
        $price = new Price(new Money(100));
        $discountMoney = new Money(20);
        $expectedMoney = new Money(80);

        $discountCalculator = $this->createMock(DiscountCalculatorInterface::class);
        $discountCalculator->method('calculateDiscount')
            ->willReturn($discountMoney);

        $coupon = $this->createMock(Coupon::class);
        $coupon->method('getDiscountCalculator')
            ->willReturn($discountCalculator);

        $price->addCoupon($coupon)->calculatePrice();

        $this->assertEquals($expectedMoney, $price->getMoney());
    }

    public function testApplyTax(): void
    {
        $price = new Price(new Money(100));
        $taxMoney = new Money(10);
        $expectedMoney = new Money(110);

        $tax = $this->createMock(TaxInterface::class);
        $tax->method('calculateTax')
            ->willReturn($taxMoney);

        $price->applyTax($tax)->calculatePrice();

        $this->assertEquals($expectedMoney, $price->getMoney());
    }

    public function testAddCouponAndApplyTax(): void
    {
        $price = new Price(new Money(100));
        $discountMoney = new Money(20);
        $taxMoney = new Money(8); // 10%
        $expectedMoney = new Money(88);

        $discountCalculator = $this->createMock(DiscountCalculatorInterface::class);
        $discountCalculator->method('calculateDiscount')
            ->willReturn($discountMoney);

        $coupon = $this->createMock(Coupon::class);
        $coupon->method('getDiscountCalculator')
            ->willReturn($discountCalculator);

        $tax = $this->createMock(TaxInterface::class);
        $tax->method('calculateTax')
            ->willReturn($taxMoney);

        $price->addCoupon($coupon);
        $price->applyTax($tax);
        $price->calculatePrice();

        $this->assertEquals($expectedMoney, $price->getMoney());

        // double check state
        $this->assertEquals($expectedMoney, $price->getMoney());
    }
}