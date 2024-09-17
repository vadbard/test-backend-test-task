<?php

namespace App\Service\Tax;

class FranceTax extends AbstractTax
{
    protected const string REGEX = '/^FR[a-zA-Z]{2}\d+$/';

    protected const int RATE_PERCENT = 20;

    protected const string NAME = 'France';
}