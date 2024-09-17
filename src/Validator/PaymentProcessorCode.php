<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class PaymentProcessorCode extends Constraint
{
    public string $message = 'Must be one of payment processors: "{{ string }}".';
}