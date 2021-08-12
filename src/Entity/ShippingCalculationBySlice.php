<?php

declare(strict_types=1);

namespace App\Entity;

class ShippingCalculationBySlice extends AbstractShippingCalculation
{
    /**
     * @var int
     */
    protected int $countItemBySlice;

    /**
     * @param int $shippingFees
     * @param int $countItemBySlice
     */
    public function __construct(int $shippingFees, int $countItemBySlice)
    {
        parent::__construct($shippingFees);
        $this->countItemBySlice = $countItemBySlice;
    }

    /**
     * @return int
     */
    public function getCountItemBySlice(): int
    {
        return $this->countItemBySlice;
    }

    public function calculateFees(Order $order, array $items): int
    {
        $quantities = $this->countQuantities($items);
        $slices = $this->getCountItemBySlice();
        $shippingFeesBrand = $this->getShippingFees();

        return (int) ((round($quantities / $slices)) * $shippingFeesBrand);
    }

    /**
     * @param array|Item[] $items
     *
     * @return int
     */
    private function countQuantities(array $items): int
    {
        $count = 0;

        foreach ($items as $item) {
            $count += $item->getQuantity();
        }

        return $count;
    }
}
