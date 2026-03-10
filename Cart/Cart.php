<?php

declare(strict_types=1);

namespace App\Cart;

use App\Model\Product;
use InvalidArgumentException;
use OutOfBoundsException;



class Cart
{
    private array $items = [];
    public function addProduct(Product $product, int $quantity = 1): void
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException("la quantité doit être positive");
        }
        if ($quantity > $product->getStock()) {
            throw new OutOfBoundsException(
                "Stock insuffisant pour {$product->getStock()}. " .
                    "Disponible: {$product->getStock()}, Demandé: {$quantity}"
            );
        }
        $productId = $product->getId();
        if (isset($this->items[$productId])) {
            $newQuantity = $this->items[$productId] + $quantity;
            if ($newQuantity > $product->getStock()) {
                throw new OutOfBoundsException(
                    "Quantité totale demandée ($newQuantity) superieure au stock disponible"
                );
            }
            $this->items[$productId] = $newQuantity;
        } else {
            $this->items[$productId] = $quantity;
        }
    }
    public function removeProduct(Product $product): void
    {
        $productId = $product->getId();

        if (!isset($this->items[$productId])) {
            throw new OutOfBoundsException("Le produit n'est pas dans le panier");
        }

        unset($this->items[$productId]);
    }
    public function getItems(): array
    {
        return $this->items;
    }
    public function getTotal(array $products): float
    {
        $total = 0.0;
        foreach ($this->items as $productId => $quantity) {
            if (!isset($products[$productId])) {
                throw new OutOfBoundsException("Produit #$productId non trouvé");
            }
            $total += $products[$productId]->getPrice() * $quantity;
        }
        return $total;
    }
    public function clear(): void
    {
        $this->items = [];
    }
    public function getItemCount(): int
    {
        return array_sum($this->items);
    }
}
