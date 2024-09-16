<?php

namespace App\UseCase;

use App\Entity\Coupon;
use App\Entity\Product;
use App\Exception\UseCase\PaypalGatewayException;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Service\Price\Price;
use App\Service\Price\PriceCalculator;
use App\Service\Tax\TaxFactory;
use App\Service\Tax\TaxInterface;

final class CalculatePriceUseCase
{
    public function __construct(
        private ProductRepository $productRepository,
        private CouponRepository $couponRepository,
        private TaxFactory $taxFactory,
        private PriceCalculator $priceCalculator,
    )
    {
    }

    public function do(int $product, string $taxNumber, string $couponCode = null): Price
    {
        $product = $this->getProduct($product);
        $tax = $this->getTax($taxNumber);
        $coupon = $this->getCoupon($couponCode);

        return $this->priceCalculator->calculatePrice($product, $tax, $coupon);
    }

    private function getProduct(int $productId): Product
    {
        $product = $this->productRepository->find($productId);

        if (is_null($product)) {
            throw new PaypalGatewayException("Product not found by id $productId");
        }

        return $product;
    }

    private function getTax(string $taxNumber): TaxInterface
    {
        try {
            $this->taxFactory->make($taxNumber);
        } catch (\Exception $e) {
            throw new PaypalGatewayException("Tax not found by number $taxNumber");
        }
    }

    private function getCoupon(?string $couponCode): ?Coupon
    {
        if (is_null($couponCode)) {
            return null;
        }

        $coupon = $this->couponRepository->findByCode($couponCode);

        if (is_null($coupon)) {
            throw new PaypalGatewayException("Coupon not found by code $couponCode");
        }

        return $coupon;
    }
}