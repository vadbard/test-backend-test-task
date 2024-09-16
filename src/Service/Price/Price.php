<?php

namespace App\Service\Price;

use App\Entity\Coupon;
use App\Service\Tax\TaxInterface;
use App\Value\Money;

class Price
{
    private Coupon $coupon;

    private TaxInterface $tax;

    private Money $resultMoney;

    public function __construct(private readonly Money $money)
    {
    }

    public function getMoney(): Money
    {
        $this->resultMoney = $this->money;

        if (isset($this->coupon) || isset($this->tax)) {
            $this->calculatePrice();
        }

        return $this->resultMoney;
    }

    public function addCoupon(Coupon $coupon): self
    {
        $this->coupon = $coupon;

        return $this;
    }

    public function applyTax(TaxInterface $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    private function calculatePrice(): void
    {
        $this->doApplyCoupon();
        $this->doApplyTax();
    }

    private function doApplyCoupon(): void
    {
        if (! isset($this->coupon)) {
            return;
        }

        $discountMoney = $this->coupon->getDiscountCalculator()->calculateDiscount($this->money);

        $value = $this->resultMoney->amount - $discountMoney->amount;

        $this->resultMoney = new Money(max($value, 0));
    }

    private function doApplyTax(): void
    {
        if (! isset($this->tax)) {
            return;
        }

        if ($this->money->amount === 0) {
            return;
        }

        $taxMoney = $this->tax->calculateTax($this->money);

        $value = $this->resultMoney->amount + $taxMoney->amount;

        $this->resultMoney = new Money($value);
    }
}