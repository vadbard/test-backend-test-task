<?php

namespace App\Service\Tax;

class GreeceTax extends AbstractTax
{
    public const string REGEX = '/^GR\d+$/';

    protected const int RATE_PERCENT = 24;
}