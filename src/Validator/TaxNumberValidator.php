<?php

namespace App\Validator;

use App\Service\Tax\TaxFactory;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TaxNumberValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if ($value === null || $value === '') {
            return;
        }

        $factory = new TaxFactory();

        try {
            (new TaxFactory())->make($value);
        } catch (\Exception $exception) {
            $allPatternsString = implode(', ', $factory->getTaxNames());

            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $allPatternsString)
                ->addViolation();
        }
    }
}