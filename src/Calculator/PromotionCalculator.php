<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Entity\Order;
use App\Promotion\Condition\PromotionConditionInterface;
use App\Promotion\Condition\PromotionConditionOrderInterface;

class PromotionCalculator
{
    public function calculate(Order $order): ?int
    {
        //If a promotion is already set for the order.
        if ($order->getPromotionReduction() > 0) {
            return null;
        }
        //We try to apply promotions to the order, only the first applicable will be applied, others will be skipped
        foreach ($order->getPromotions() as $promotion) {
            $conditions = $promotion->getConditions();

            $isApplicable = true;
            foreach ($conditions as $condition) {
                if (!$condition instanceof PromotionConditionInterface) {
                    throw new \Exception("Your condition doesn't implement the ".PromotionConditionInterface::class.'. Please implement the interface for your condition '.\get_class($condition));
                }

                if ($condition instanceof PromotionConditionOrderInterface) {
                    $condition->setOrder($order);
                }

                if (!$condition->isConditionApplied()) {
                    $isApplicable = false;
                }
            }

            if ($isApplicable) {
                return $promotion->getReduction();
            }
        }

        //If we are here, it means no promotion is applicable for the order. We then set it to 0
        return 0;
    }
}
