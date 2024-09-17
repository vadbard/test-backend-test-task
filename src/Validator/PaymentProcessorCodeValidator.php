<?php

namespace App\Validator;

use App\Enum\PaymentProcessorEnum;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PaymentProcessorCodeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if ($value === null || $value === '') {
            return;
        }

        $processorEnum = PaymentProcessorEnum::tryFrom($value);

        if (is_null($processorEnum)) {
            $allPatternsString = implode(', ', PaymentProcessorEnum::names());

            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $allPatternsString)
                ->addViolation();
        }
    }
}