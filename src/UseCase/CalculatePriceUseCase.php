<?php

namespace App\UseCase;

use App\Entity\Coupon;
use App\Entity\Product;
use App\Exception\UseCase\CalculatePriceUseCaseException;
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
            throw new CalculatePriceUseCaseException("Product not found by id $productId");
        }

        return $product;
    }

    private function getTax(string $taxNumber): TaxInterface
    {
        try {
            $tax = $this->taxFactory->make($taxNumber);
        } catch (\Exception $e) {
            throw new CalculatePriceUseCaseException("Tax not found by number $taxNumber");
        }

        return $tax;
    }

    private function getCoupon(?string $couponCode): ?Coupon
    {
        if (is_null($couponCode)) {
            return null;
        }

        $coupon = $this->couponRepository->findByCode($couponCode);

        if (is_null($coupon)) {
            throw new CalculatePriceUseCaseException("Coupon not found by code $couponCode");
        }

        return $coupon;
    }
}