<?php

declare(strict_types=1);

namespace App\Entity;

class Order
{
    /**
     * @var array|Item[]
     */
    protected array $items;

    /**
     * @var int
     */
    protected int $price = 0;

    /**
     * @var int
     */
    protected int $vatPrice = 0;

    /**
     * @var int
     */
    protected int $promotionReduction = 0;

    /**
     * @var int
     */
    protected int $shippingFees = 0;

    /**
     * @param Item $item
     */
    public function addItem(Item $item): void
    {
        $this->items[] = $item;
        $this->price += $item->getProduct()->getPrice() * $item->getQuantity();
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getItemsByBrands(): array
    {
        $byBrands = [];
        foreach ($this->items as $item) {
            $byBrands[$item->getProduct()->getBrand()->getName()][] = $item;
        }

        return $byBrands;
    }

    /**
     * @param string $name
     *
     * @return Brand|null
     */
    public function getBrandByName(string $name): ?Brand
    {
        foreach ($this->items as $item) {
            $brand = $item->getProduct()->getBrand();
            if ($brand->getName() === $name) {
                return $brand;
            }
        }

        return null;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->vatPrice + $this->price + $this->shippingFees - $this->promotionReduction;
    }

    /**
     * @param array $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getVatPrice(): int
    {
        return $this->vatPrice;
    }

    /**
     * @param int $vatPrice
     */
    public function setVatPrice(int $vatPrice): void
    {
        $this->vatPrice = $vatPrice;
    }

    /**
     * @return int
     */
    public function getPromotionReduction(): int
    {
        return $this->promotionReduction;
    }

    /**
     * @param int $promotionReduction
     */
    public function setPromotionReduction(int $promotionReduction): void
    {
        $this->promotionReduction = $promotionReduction;
    }

    /**
     * @return int
     */
    public function getShippingFees(): int
    {
        return $this->shippingFees;
    }

    /**
     * @param int $shippingFees
     */
    public function setShippingFees(int $shippingFees): void
    {
        $this->shippingFees = $shippingFees;
    }
}
