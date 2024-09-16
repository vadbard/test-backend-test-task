<?php

namespace App\Service\Tax;

use App\Value\Money;

class FranceTax extends AbstractTax
{
    public const string REGEX = '/^(FR[a-zA-Z]{2}\d+)$/';

    protected const int RATE_PERCENT = 20;
}