<?php

declare(strict_types=1);

namespace App\Promotion\Condition;

class DurationCondition implements PromotionConditionInterface
{
    private \DateTimeInterface $from;

    private \DateTimeInterface $to;

    public function __construct(\DateTimeInterface $from, \DateTimeInterface $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function isConditionApplied(): bool
    {
        $now = new \DateTime();

        return $this->from < $now && $now < $this->to;
    }
}
