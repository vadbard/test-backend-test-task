<?php

namespace App\Service\Discount;

use App\Value\Money;

class AmountDiscountCalculator implements DiscountCalculatorInterface
{
    public function __construct(private readonly int $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('Value must be positive');
        }
    }

    public function calculateDiscount(Money $money): Money
    {
        return new Money($this->value);
    }
}