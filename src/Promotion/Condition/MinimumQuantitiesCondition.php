<?php

declare(strict_types=1);

namespace App\Promotion\Condition;

class MinimumQuantitiesCondition implements PromotionConditionInterface, PromotionConditionOrderInterface
{
    use PromotionOrderTrait;

    private int $minimumQuantities;

    public function __construct(int $minimumQuantities)
    {
        $this->minimumQuantities = $minimumQuantities;
    }

    public function isConditionApplied(): bool
    {
        $orderQuantities = $this->order->getItemsQuantities();

        return $orderQuantities > $this->minimumQuantities;
    }
}
