<?php

namespace App\ResponseDto;

use App\Value\Money;

readonly class CalculatePriceResponseDto
{
    public function __construct(
        public Money $price,
    ) {
    }
}