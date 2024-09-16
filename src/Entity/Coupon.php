<?php

namespace App\Entity;

use App\Enum\CouponTypeEnum;
use App\Repository\CouponRepository;
use App\Service\Discount\AmountDiscountCalculator;
use App\Service\Discount\DiscountCalculatorInterface;
use App\Service\Discount\PercentDiscountCalculator;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50, nullable: false, enumType: CouponTypeEnum::class)]
    private ?CouponTypeEnum $type;

    #[ORM\Column(nullable: true)]
    private ?int $value = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $code = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?CouponTypeEnum
    {
        return $this->type;
    }

    public function setType(?CouponTypeEnum $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(?int $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getDiscountCalculator(): DiscountCalculatorInterface
    {
        if ($this->type === CouponTypeEnum::DiscountPercent) {
            return new PercentDiscountCalculator($this);
        } elseif ($this->type === CouponTypeEnum::DiscountAmount) {
            return new AmountDiscountCalculator($this);
        }

        throw new \Exception('Unknown coupon type');
    }
}
