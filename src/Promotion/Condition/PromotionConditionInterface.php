<?php

declare(strict_types=1);

namespace App\Promotion\Condition;

interface PromotionConditionInterface
{
    public function isConditionApplied(): bool;
}
