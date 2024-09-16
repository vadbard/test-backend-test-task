<?php

namespace App\Service\Discount;

use App\Entity\Coupon;
use App\Value\Money;

class PercentDiscountCalculator implements DiscountCalculatorInterface
{
    public function __construct(private readonly Coupon $coupon)
    {
    }

    public function calculateDiscount(Money $money): Money
    {
        return new Money($money->amount * $this->coupon->getValue() * 0.1);
    }
}