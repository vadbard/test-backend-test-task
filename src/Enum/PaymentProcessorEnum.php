<?php

namespace App\Enum;

use App\Enum\Traits\ToArrayTrait;

enum PaymentProcessorEnum: string
{
    use ToArrayTrait;

    case Paypal = 'paypal';

    case Stripe = 'stripe';
}
