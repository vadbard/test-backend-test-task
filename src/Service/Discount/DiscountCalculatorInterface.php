<?php

namespace App\Service\Discount;

use App\Value\Money;

interface DiscountCalculatorInterface
{
    public function calculateDiscount(Money $money): Money;
}