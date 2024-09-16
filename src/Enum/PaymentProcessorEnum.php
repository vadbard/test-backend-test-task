<?php

namespace App\Enum;

enum PaymentProcessorEnum: string
{
    case Paypal = 'paypal';

    case Stripe = 'stripe';
}
