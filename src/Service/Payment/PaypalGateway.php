<?php

namespace App\Service\Payment;

use App\Exception\Service\Tax\TaxFactoryException;
use App\Service\Price\Price;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

final readonly class PaypalGateway implements PaymentGatewayInterface
{
    public function __construct(
        private PaypalPaymentProcessor $paypalPaymentProcessor,
    )
    {
    }

    public function pay(Price $price): void
    {
        try {
            $this->paypalPaymentProcessor->pay($price->getMoney()->amount);
        } catch (\Exception $e) {
            throw new TaxFactoryException('Paypal payment failed');
        }
    }
}