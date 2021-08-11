<?php

declare(strict_types=1);

namespace App\Promotion;

use App\Entity\Promotion;
use App\Promotion\Condition\DurationCondition;
use App\Promotion\Condition\MinimumPriceCondition;
use App\Promotion\Condition\MinimumQuantitiesCondition;

class PromotionBuilder
{
    private array $rules = [];

    private ?int $discount = null;

    public function setDuration(\DateTimeInterface $from, \DateTimeInterface $to): self
    {
        $this->rules[] = new DurationCondition($from, $to);

        return $this;
    }

    public function setMinimumQuantities(int $quantities): self
    {
        $this->rules[] = new MinimumQuantitiesCondition($quantities);

        return $this;
    }

    public function setMinimumPrice(int $price): self
    {
        $this->rules[] = new MinimumPriceCondition($price);

        return $this;
    }

    public function setDiscount(int $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function buildPromotion(): Promotion
    {
        if (null === $this->discount) {
            throw new \Exception("Can't build a promotion without setting a discount amount.");
        }

        return new Promotion($this->discount, $this->rules);
    }
}
