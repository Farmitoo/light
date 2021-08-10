<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Entity\Order;
use App\Entity\ShippingCalculationByOrder;
use App\Entity\ShippingCalculationBySlice;

class ShippingCalculator
{
    /**
     * Return only the shipping calculated value.
     *
     * @param Order $order
     *
     * @return int
     */
    public function calculate(Order $order): int
    {
        $shippingFees = 0;

        $itemsByBrand = $order->getItemsByBrands();
        foreach ($itemsByBrand as $brandName => $items) {
            $brand = $order->getBrandByName($brandName);

            if (null === $brand) {
                throw new \Exception("The Brand $brandName does not have any ShippingCalculation. Please add one");
            }

            if ($brand->getShippingCalculation() instanceof ShippingCalculationByOrder) {
                $shippingFees += $brand->getShippingCalculation()->getShippingFees();
            } elseif ($brand->getShippingCalculation() instanceof ShippingCalculationBySlice) {
                $shippingFees += (floor(\count($items) / $brand->getShippingCalculation()->getCountItemBySlice())) * $brand->getShippingCalculation()->getShippingFees();
            }
        }

        return (int) $shippingFees;
    }
}
