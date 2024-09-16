<?php

namespace App\Tests\Service\Payment;

use App\Exception\Service\Payment\StripeGatewayException;
use App\Service\Payment\StripeGateway;
use App\Service\Price\Price;
use App\Value\Money;
use PHPUnit\Framework\TestCase;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class StripeGatewayTest extends TestCase
{
    private StripePaymentProcessor $paypalPaymentProcessor;

    private Price $price;

    private StripeGateway $paypalGateway;

    protected function setUp(): void
    {
        $this->paypalPaymentProcessor = $this->createMock(StripePaymentProcessor::class);
        $this->price = $this->createMock(Price::class);

        $this->paypalGateway = new StripeGateway($this->paypalPaymentProcessor);
    }

    public function testPaySuccessfully(): void
    {
        $moneyAmount = 100;
        $processorArgument = 1.0;

        $this->price->method('getMoney')->willReturn(new Money($moneyAmount));

        $this->paypalPaymentProcessor->expects($this->once())
            ->method('processPayment')
            ->with($processorArgument)
            ->willReturn(true);

        $this->paypalGateway->pay($this->price);
    }

    public function testThrowsExceptionOnFailure(): void
    {
        $price = $this->createMock(Price::class);
        $moneyAmount = 100;

        $price->method('getMoney')->willReturn(new Money($moneyAmount));

        $this->paypalPaymentProcessor->method('processPayment')
            ->willReturn(false);

        $this->expectException(StripeGatewayException::class);

        $this->paypalGateway->pay($price);
    }
}