<?php

namespace App\Service\Discount;

use App\Value\Money;

class PercentDiscountCalculator implements DiscountCalculatorInterface
{
    public function __construct(private readonly int $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('Value must be positive');
        }

        if ($value > 100) {
            throw new \InvalidArgumentException('Value must be not exceed 100');
        }
    }

    public function calculateDiscount(Money $money): Money
    {
        return new Money( $this->value / 100 * $money->amount);
    }
}