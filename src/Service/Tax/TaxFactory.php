<?php

namespace App\Service\Tax;

use App\Exception\Service\Tax\TaxFactoryException;

class TaxFactory extends AbstractTax
{
    public function make(string $taxNumber): TaxInterface
    {
        foreach ($this->getTaxes() as $tax) {
            if (preg_match($tax::REGEX, $taxNumber) === 1) {
                return $tax;
            }
        }

        throw new TaxFactoryException('Tax not found');
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