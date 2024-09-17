<?php

namespace App\RequestDto;

use App\Validator\PaymentProcessorCode;
use App\Validator\TaxNumber;
use Symfony\Component\Validator\Constraints as Assert;

readonly class PurchaseRequestDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('int')]
        #[Assert\Positive]
        public int $product,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[TaxNumber]
        public string $taxNumber,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[PaymentProcessorCode]
        public string $paymentProcessor,

        #[Assert\Type('string')]
        public ?string $couponCode = null,
    ) {
    }
}