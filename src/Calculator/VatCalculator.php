<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Entity\Item;
use App\Entity\Order;

class VatCalculator
{
    /**
     * Return only the vat price without the item prices.
     *
     * @param Order $order
     *
     * @return int
     */
    public function calculate(Order $order): int
    {
        $vat = 0;
        foreach ($order->getItems() as $item) {
            //Its cross-multiplication. We multiply vat with product price then we divide by 100, finally we multiply by item quantity
            $vat += $this->calculateItem($item);
        }

        return $vat;
    }

    public function calculateItem(Item $item): int
    {
        return ($item->getProduct()->getBrand()->getVat() * $item->getProduct()->getPrice() / 100) * $item->getQuantity();
    }
}
