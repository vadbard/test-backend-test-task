<?php

namespace App\Tests\Web;

use App\Entity\Coupon;
use App\Entity\Product;
use App\Enum\CouponTypeEnum;
use App\Factory\CouponFactory;
use App\Factory\ProductFactory;
use App\Service\Price\Price;
use App\Tests\Web\Traits\TestRequestTrait;
use App\Value\Money;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class CalculatePriceTest extends WebTestCase
{
    use TestRequestTrait;
    use ResetDatabase;
    use Factories;

    private const string URL = '/calculate-price';

    private Product|Proxy $product;
    private Coupon|Proxy $coupon;

    private KernelBrowser $client;


    protected function setUp(): void
    {
        $this->client = static::createClient();

        $this->product = ProductFactory::createOne([
            'name' => 'test name',
            'price' => new Price(new Money(10000)),
        ]);

        $this->coupon = CouponFactory::createOne([
            'type' => CouponTypeEnum::DiscountAmount,
            'value' => 1000,
            'code' => 'test-code',
        ]);
    }

    public function testPurchaseSuccess(): void
    {
        $this->post(self::URL, [
            'product' => $this->product->getId(),
            'taxNumber' => 'FRAA00',
            'couponCode' => $this->coupon->getCode(),
        ]);

        $this->assertResponseStatusCodeSame(200);

        $this->post(self::URL, [
            'product' => $this->product->getId(),
            'taxNumber' => 'FRAA00',
            'couponCode' => $this->coupon->getCode(),
        ]);

        $this->assertResponseStatusCodeSame(200);
    }

    public function testPurchaseFailBusinessRules(): void
    {
        $this->post(self::URL, [
            'product' => 100,
            'taxNumber' => 'FRAA00',
            'couponCode' => $this->coupon->getCode(),
        ]);

        $this->assertResponseStatusCodeSame(400);

        $this->post(self::URL, [
            'product' => $this->product->getId(),
            'taxNumber' => 'FRAA00',
            'couponCode' => 'wrong-code',
        ]);

        $this->assertResponseStatusCodeSame(400);
    }
}
