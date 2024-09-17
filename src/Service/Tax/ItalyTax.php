<?php

namespace App\Service\Tax;

class ItalyTax extends AbstractTax
{
    protected const string REGEX = '/^IT\d+$/';

    protected const int RATE_PERCENT = 22;

    protected const string NAME = 'Italy';
}