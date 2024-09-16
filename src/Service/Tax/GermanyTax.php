<?php

namespace App\Service\Tax;

class GermanyTax extends AbstractTax
{
    public const string REGEX = '/^DE\d+$/';

    protected const int RATE_PERCENT = 19;
}