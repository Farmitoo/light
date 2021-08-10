<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Entity\ShippingCalculationByOrder;
use App\Entity\ShippingCalculationBySlice;
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

        /*
        ---------------------------------------------
        $promotion1 = new Promotion(); // réduction de 12€, applicable du 01 au 10 aout 2021 pour une commande de 200€ minimum
        $promotion2 = new Promotion(); // réduction de 5€, applicable dès 5 produits achetés sur le site.
        -- à mettre où vous voulez dans le projet  --
        */

        $orderUpdater->addProduct($order, $product1, 10);
        $orderUpdater->addProduct($order, $product2, 2);
        $orderUpdater->addProduct($order, $product3, 1);

        return $this->render('cart.html.twig', [
            'order' => $order,
        ]);
    }
}
