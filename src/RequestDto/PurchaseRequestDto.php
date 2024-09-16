<?php

namespace App\RequestDto;

use App\Enum\PaymentProcessorEnum;
use App\Service\Tax\FranceTax;
use App\Service\Tax\GermanyTax;
use App\Service\Tax\GreeceTax;
use App\Service\Tax\ItalyTax;
use Symfony\Component\Validator\Constraints as Assert;

readonly class PurchaseRequestDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('int')]
        #[Assert\Positive]
        public string $product,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\AtLeastOneOf([
            new Assert\Regex(FranceTax::REGEX),
            new Assert\Regex(GermanyTax::REGEX),
            new Assert\Regex(GreeceTax::REGEX),
            new Assert\Regex(ItalyTax::REGEX),
        ])]
        public string $taxNumber,

        #[Assert\NotBlank]
        #[Assert\Choice(choices: [
            PaymentProcessorEnum::Paypal->value,
            PaymentProcessorEnum::Stripe->value,
        ])]
        public string $paymentProcessor,

        #[Assert\Type('string')]
        public ?string $couponCode = null,
    ) {
    }
}