<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\ShippingCalculationByOrder;
use App\Entity\ShippingCalculationBySlice;
use App\Promotion\PromotionBuilder;
use App\Updater\OrderUpdater;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    /**
     * @param OrderUpdater $orderUpdater
     *
     * @return Response
     */
    public function index(OrderUpdater $orderUpdater): Response
    {
        $farmitooBrand = new Brand('Farmitoo', new ShippingCalculationByOrder(1200), 20);
        $gallagherBrand = new Brand('Gallagher', new ShippingCalculationBySlice(1400, 2), 10);

        $order = new Order();

        $product1 = new Product('Cuve à gasoil', 10000, $farmitooBrand);
        $product2 = new Product('Electrificateur de clôture', 2500, $gallagherBrand);
        $product3 = new Product('Couveuse', 6000, $gallagherBrand);

        $startPromotion = (new \DateTime())->setDate(2021, 8, 1)->setTime(0, 0);
        $endPromotion = (new \DateTime())->setDate(2021, 8, 11)->setTime(0, 0);

        // réduction de 12€, applicable du 01 au 10 aout 2021 pour une commande de 200€ minimum
        $promotion1 = (new PromotionBuilder())
            ->setDuration($startPromotion, $endPromotion)
            ->setMinimumPrice(20000)
            ->setDiscount(1200)
            ->buildPromotion();

        // réduction de 5€, applicable dès 5 produits achetés sur le site.
        $promotion2 = (new PromotionBuilder())
            ->setMinimumQuantities(5)
            ->setDiscount(500)
            ->buildPromotion();

        $orderUpdater->addProduct($order, $product1, 10);
        $orderUpdater->addProduct($order, $product2, 2);
        $orderUpdater->addProduct($order, $product3, 1);
        $orderUpdater->addPromotion($order, $promotion1);
        $orderUpdater->addPromotion($order, $promotion2);

        return $this->render('cart.html.twig', [
            'order' => $order,
        ]);
    }
}
