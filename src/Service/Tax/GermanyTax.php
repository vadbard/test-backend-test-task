<?php

namespace App\Service\Tax;

use App\Value\Money;

class GermanyTax extends AbstractTax
{
    public const string REGEX = '/^(DE\d+)$/';

    protected const int RATE_PERCENT = 19;
}