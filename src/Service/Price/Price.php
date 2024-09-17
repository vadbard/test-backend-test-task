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
        $this->resultMoney = $this->money;
    }

    public function getMoney(): Money
    {
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

    public function calculatePrice(): self
    {
        $this->resultMoney = $this->money;

        $this->doApplyCoupon();

        $this->doApplyTax();

        return $this;
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