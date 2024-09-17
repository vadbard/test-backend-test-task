<?php

namespace App\Service\Tax;

class GreeceTax extends AbstractTax
{
    protected const string REGEX = '/^GR\d+$/';

    protected const int RATE_PERCENT = 24;

    protected const string NAME = 'Greece';
}