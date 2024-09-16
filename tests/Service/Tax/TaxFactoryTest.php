<?php

namespace App\Tests\Service\Tax;

use App\Exception\Service\Tax\TaxFactoryException;
use App\Service\Tax\TaxFactory;
use App\Service\Tax\FranceTax;
use App\Service\Tax\GermanyTax;
use App\Service\Tax\GreeceTax;
use App\Service\Tax\ItalyTax;
use PHPUnit\Framework\TestCase;

class TaxFactoryTest extends TestCase
{
    private TaxFactory $taxFactory;

    protected function setUp(): void
    {
        $this->taxFactory = new TaxFactory();
    }

    public function testMakeReturnsFranceTax(): void
    {
        $tax = $this->taxFactory->make('FRAA00');
        $this->assertInstanceOf(FranceTax::class, $tax);

        $tax = $this->taxFactory->make('FRaa00');
        $this->assertInstanceOf(FranceTax::class, $tax);
    }

    public function testMakeReturnsGermanyTax(): void
    {
        $tax = $this->taxFactory->make('DE00');
        $this->assertInstanceOf(GermanyTax::class, $tax);
    }

    public function testMakeReturnsGreeceTax(): void
    {
        $tax = $this->taxFactory->make('GR00');
        $this->assertInstanceOf(GreeceTax::class, $tax);
    }

    public function testMakeReturnsItalyTax(): void
    {
        $tax = $this->taxFactory->make('IT00');
        $this->assertInstanceOf(ItalyTax::class, $tax);
    }

    public function testMakeThrowsException(): void
    {
        $this->expectException(TaxFactoryException::class);
        $tax = $this->taxFactory->make('F01');
    }
}