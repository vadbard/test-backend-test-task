<?php

namespace App\Service\Payment;

use App\Exception\Service\Payment\StripeGatewayException;
use App\Service\Price\Price;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

final readonly class StripeGateway implements PaymentGatewayInterface
{
    public function __construct(
        private StripePaymentProcessor $stripePaymentProcessor,
    )
    {
    }

    public function pay(Price $price): void
    {
        $result = $this->stripePaymentProcessor->processPayment($price->getMoney()->float());

        if ($result === false) {
            throw new StripeGatewayException('Stripe payment failed');
        }
    }
}