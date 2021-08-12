<?php

declare(strict_types=1);

namespace App\Promotion\Condition;

use App\Entity\Order;

interface PromotionConditionOrderInterface
{
    public function setOrder(Order $order);

    public function getOrder(): Order;
}
