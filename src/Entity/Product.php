<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use App\Service\Price\Price;
use App\Value\Money;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name;

    #[ORM\Column(nullable: false)]
    private ?int $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?Price
    {
        return new Price(new Money($this->price));
    }

    public function setPrice(?Price $price): static
    {
        $this->price = $price->getMoney()->amount;

        return $this;
    }
}
