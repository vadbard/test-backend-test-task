<?php

namespace App\Tests\Service\Payment;

use App\Exception\Service\Payment\PaypalGatewayException;
use App\Service\Payment\PaypalGateway;
use App\Service\Price\Price;
use App\Value\Money;
use PHPUnit\Framework\TestCase;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

class PaypalGatewayTest extends TestCase
{
    private PaypalPaymentProcessor $paypalPaymentProcessor;

    private Price $price;

    private PaypalGateway $paypalGateway;

    protected function setUp(): void
    {
        $this->paypalPaymentProcessor = $this->createMock(PaypalPaymentProcessor::class);
        $this->price = $this->createMock(Price::class);

        $this->paypalGateway = new PaypalGateway($this->paypalPaymentProcessor);
    }

    public function testPaySuccessfully(): void
    {
        $moneyAmount = 100;
        $processorArgument = 100;

        $this->price->method('getMoney')->willReturn(new Money($moneyAmount));

        $this->paypalPaymentProcessor->expects($this->once())
            ->method('pay')
            ->with($processorArgument);

        $this->paypalGateway->pay($this->price);
    }

    public function testThrowsExceptionOnFailure(): void
    {
        $price = $this->createMock(Price::class);
        $moneyAmount = 100001;

        $price->method('getMoney')->willReturn(new Money($moneyAmount));

        $this->paypalPaymentProcessor->method('pay')
            ->will($this->throwException(new \Exception()));

        $this->expectException(PaypalGatewayException::class);

        $this->paypalGateway->pay($price);
    }
}