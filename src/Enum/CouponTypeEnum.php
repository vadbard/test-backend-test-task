<?php

namespace App\Enum;

enum CouponTypeEnum: string
{
    case DiscountPercent = 'discount_percent';

    case DiscountAmount = 'discount_amount';
}
