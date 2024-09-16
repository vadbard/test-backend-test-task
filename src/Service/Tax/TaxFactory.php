<?php

namespace App\Service\Tax;

use App\Value\Money;

class TaxFactory extends AbstractTax
{
    public function make(string $taxNumber): TaxInterface
    {
        foreach ($this->getTaxes() as $tax) {
            if (preg_match($taxNumber, $tax::REGEX) !== false) {
                return $tax;
            }
        }

        throw new \Exception('Tax not found');
    }

    /**
     * @return TaxInterface[]
     */
    public function getTaxes(): array
    {
        return [
            new FranceTax(),
            new GermanyTax(),
            new GreeceTax(),
            new ItalyTax(),
        ];
    }
}