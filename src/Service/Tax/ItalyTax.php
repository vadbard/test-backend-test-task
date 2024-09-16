<?php

namespace App\Service\Tax;

use App\Value\Money;

class ItalyTax extends AbstractTax
{
    public const string REGEX = '/^(IT\d+)$/';

    protected const int RATE_PERCENT = 22;
}