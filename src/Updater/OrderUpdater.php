<?php

declare(strict_types=1);

namespace App\Updater;

use App\Calculator\PromotionCalculator;
use App\Calculator\ShippingCalculator;
use App\Calculator\VatCalculator;
use App\Entity\Item;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Promotion;

class OrderUpdater
{
    /**
     * @var ShippingCalculator
     */
    protected ShippingCalculator $shippingCalculator;

    /**
     * @var VatCalculator
     */
    protected VatCalculator $vatCalculator;

    private PromotionCalculator $promotionCalculator;

    /**
     * @param ShippingCalculator $shippingCalculator
     * @param VatCalculator      $vatCalculator
     */
    public function __construct(ShippingCalculator $shippingCalculator, VatCalculator $vatCalculator, PromotionCalculator $promotionCalculator)
    {
        $this->shippingCalculator = $shippingCalculator;
        $this->vatCalculator = $vatCalculator;
        $this->promotionCalculator = $promotionCalculator;
    }

    /**
     * @param Order   $order
     * @param Product $product
     * @param int     $quantity
     */
    public function addProduct(Order $order, Product $product, int $quantity)
    {
        $item = new Item($product, $quantity);
        $order->addItem($item);

        $shippingFees = $this->shippingCalculator->calculate($order);
        $vatPrice = $this->vatCalculator->calculate($order);

        $order->setShippingFees($shippingFees);
        $order->setVatPrice($vatPrice);
    }

    public function addPromotion(Order $order, Promotion $promotion)
    {
        $order->addPromotion($promotion);
        $promotion = $this->promotionCalculator->calculate($order);
        if (null !== $promotion) {
            $order->setPromotionReduction($promotion);
        }
    }
}
