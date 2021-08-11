<?php

declare(strict_types=1);

namespace App\Entity;

class ShippingCalculationByOrder extends AbstractShippingCalculation
{
    public function calculateFees(Order $order, $items): int
    {
        return \count($items) > 0 ? (int) ($this->getShippingFees()) : 0;
    }
}
