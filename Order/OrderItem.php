<?php

declare(strict_types=1);

namespace App\Order;

use App\Model\Product;

/**
 * Représente une ligne de commande
 */
class OrderItem
{
    private Product $product;
    private int $quantity;
    private float $priceAtPurchase;

    public function __construct(Product $product, int $quantity)
    {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException("La quantité doit être positive");
        }

        $this->product = $product;
        $this->quantity = $quantity;
        // On capture le prix au moment de la création
        $this->priceAtPurchase = $product->getPrice();
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPriceAtPurchase(): float
    {
        return $this->priceAtPurchase;
    }

    /**
     * Calcule le sous-total de cette ligne
     */
    public function getSubtotal(): float
    {
        return $this->priceAtPurchase * $this->quantity;
    }

    public function __toString(): string
    {
        return "{$this->product->getName()} x{$this->quantity} @ {$this->priceAtPurchase} PO";
    }
}
