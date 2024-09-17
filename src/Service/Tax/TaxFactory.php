<?php

namespace App\Service\Tax;

use App\Exception\Service\Tax\TaxFactoryException;

class TaxFactory
{
    /**
     * @var TaxInterface[]
     */
    private array $taxes;

    public function __construct()
    {
        $this->taxes = [
            new FranceTax(),
            new GermanyTax(),
            new GreeceTax(),
            new ItalyTax(),
        ];
    }

    public function make(string $taxNumber): TaxInterface
    {
        foreach ($this->getTaxes() as $tax) {
            if (preg_match($tax->getRegexPattern(), $taxNumber) === 1) {
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
       return $this->taxes;
    }

    /**
     * @return string[]
     */
    public function getTaxNames(): array
    {
        return array_map(function($tax) {
            return $tax->getName();
        }, $this->taxes);
    }
}