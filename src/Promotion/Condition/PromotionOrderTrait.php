<?php

declare(strict_types=1);

namespace App\Promotion\Condition;

use App\Entity\Order;

trait PromotionOrderTrait
{
    protected Order $order;

    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }
}
