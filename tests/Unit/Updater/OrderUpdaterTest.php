<?php

declare(strict_types=1);

namespace App\Tests\Unit\Updater;

use App\Calculator\ShippingCalculator;
use App\Calculator\VatCalculator;
use App\Entity\Brand;
use App\Entity\Item;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\ShippingCalculationByOrder;
use App\Entity\ShippingCalculationBySlice;
use App\Updater\OrderUpdater;
use PHPUnit\Framework\TestCase;

class OrderUpdaterTest extends TestCase
{
    protected ShippingCalculator $shippingCalculator;
    protected VatCalculator $vatCalculator;
    protected OrderUpdater $orderUpdater;

    public function testAddProduct()
    {
        $farmitooBrand = new Brand('Farmitoo', new ShippingCalculationByOrder(1200), 20);
        $gallagherBrand = new Brand('Gallagher', new ShippingCalculationBySlice(1400, 2), 10);

        $order = new Order();
        $product1 = new Product('Cuve à gasoil', 10000, $farmitooBrand);
        $product2 = new Product('Electrificateur de clôture', 2500, $gallagherBrand);
        $product3 = new Product('Couveuse', 6000, $gallagherBrand);

        $item1 = new Item($product1, 10);
        $item2 = new Item($product2, 2);

        $order->addItem($item1);
        $order->addItem($item2);

        $this->orderUpdater->addProduct($order, $product3, 1);

        $this->assertCount(3, $order->getItems());
        $this->assertSame(111000, $order->getPrice());
//        $this->assertEquals(1000, $order->getPromotionReduction());
        //Shipping
        //Farmitoo + 12
        //Gallagher + 14 ou + 28
        //Donc soit 2600 ou 4000 a moins que l'on ne prenne que le Shipping le plus chère ?
        $this->assertSame(4000, $order->getShippingFees());
        $this->assertSame(21100, $order->getVatPrice());
    }

    protected function setUp(): void
    {
        $this->shippingCalculator = new ShippingCalculator();
        $this->vatCalculator = new VatCalculator();

        $this->orderUpdater = new OrderUpdater($this->shippingCalculator, $this->vatCalculator);
    }
}
