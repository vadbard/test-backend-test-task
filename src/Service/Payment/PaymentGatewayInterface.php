<?php

namespace App\Service\Payment;

use App\Service\Price\Price;

interface PaymentGatewayInterface
{
    public function pay(Price $price): void;
}