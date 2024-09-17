<?php

namespace App\Service\Tax;

class GermanyTax extends AbstractTax
{
    protected const string REGEX = '/^DE\d+$/';

    protected const int RATE_PERCENT = 19;

    protected const string NAME = 'Germany';
}