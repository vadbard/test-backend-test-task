<?php

namespace App\Service\Tax;

use App\Value\Money;

interface TaxInterface
{
    public function calculateTax(Money $money): Money;
}