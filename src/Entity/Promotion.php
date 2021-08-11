<?php

declare(strict_types=1);

namespace App\Entity;

use App\Promotion\Condition\PromotionConditionInterface;

class Promotion
{
    /**
     * @var int
     */
    protected int $reduction;

    /**
     * @var array|PromotionConditionInterface[]
     */
    protected array $conditions;

    /**
     * @param int   $reduction
     * @param array $conditions
     */
    public function __construct(int $reduction, array $conditions)
    {
        $this->reduction = $reduction;
        $this->conditions = $conditions;
    }

    public function getReduction(): int
    {
        return $this->reduction;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }
}
