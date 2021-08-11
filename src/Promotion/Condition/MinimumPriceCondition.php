<?php

declare(strict_types=1);

namespace App\Promotion\Condition;

class MinimumPriceCondition implements PromotionConditionInterface, PromotionConditionOrderInterface
{
    use PromotionOrderTrait;

    private int $minimumPrice;

    public function __construct(int $minimumPrice)
    {
        $this->minimumPrice = $minimumPrice;
    }

    public function isConditionApplied(): bool
    {
        return $this->order->getPrice() > $this->minimumPrice;
    }
}
