<?php

namespace App\UseCase;

use App\Enum\PaymentProcessorEnum;
use App\Exception\UseCase\PurchasePaymentGatewayException;
use App\Service\Payment\PaymentGatewayInterface;
use App\Service\Payment\PaypalGateway;
use App\Service\Payment\StripeGateway;
use App\Service\Price\Price;

final class PayUseCase
{
    public function __construct(
        private PaypalGateway $paypalGateway,
        private StripeGateway $stripeGateway,
    )
    {
    }

    public function do(Price $price, string $paymentProcessorString): void
    {
        $gateway = $this->getPaymentGateway($paymentProcessorString);

        try {
            $gateway->pay($price);
        } catch (\Exception $e) {
            throw new PurchasePaymentGatewayException('Payment error. Details: ' . $e->getMessage());
        }
    }


    private function getPaymentGateway(string $processorString): PaymentGatewayInterface
    {
        $processorEnum = PaymentProcessorEnum::tryFrom($processorString);

        if (is_null($processorEnum)) {
            throw new PurchasePaymentGatewayException("Payment processor not found by code $processorString");
        }

        return match ($processorEnum) {
            PaymentProcessorEnum::Paypal => $this->paypalGateway,
            PaymentProcessorEnum::Stripe => $this->stripeGateway,
        };
    }
}