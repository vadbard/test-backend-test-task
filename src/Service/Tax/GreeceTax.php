<?php

namespace App\Service\Tax;

use App\Value\Money;

class GreeceTax extends AbstractTax
{
    public const string REGEX = '/^(GR\d+)$/';

    protected const int RATE_PERCENT = 24;
}