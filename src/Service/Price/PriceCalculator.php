<?php

namespace App\Service\Price;

use App\Entity\Coupon;
use App\Entity\Product;
use App\Service\Tax\TaxInterface;

class PriceCalculator
{
    public function calculatePrice(Product $product, TaxInterface $tax, Coupon $coupon = null): Price
    {
        $price = $product->getPrice();

        if (! is_null($coupon)) {
            $price->addCoupon($coupon);
        }

        $price->applyTax($tax);

        return $price->calculatePrice();
    }
}