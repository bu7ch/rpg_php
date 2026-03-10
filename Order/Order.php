<?php

declare(strict_types=1);

namespace App\Order;

use App\Model\Product;
use App\Order\OrderItem;
use Customer;
use DateTime;
use InvalidArgumentException;
use OutOfBoundsException;
use RuntimeException;

/**
 * Représente une commande client
 */
class Order
{
    private int $id;
    private Customer $customer;
    /** @var OrderItem[] */
    private array $items = [];
    private string $status;
    private float $total;
    private DateTime $createdAt;

    private const VALID_STATUSES = ['pending', 'paid', 'shipped', 'cancelled', 'completed'];

    public function __construct(int $id, Customer $customer)
    {
        $this->id = $id;
        $this->customer = $customer;
        $this->status = 'pending';
        $this->total = 0.0;
        $this->createdAt = new DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return OrderItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        if (!in_array($status, self::VALID_STATUSES, true)) {
            throw new InvalidArgumentException("Statut invalide: $status");
        }
        $this->status = $status;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Ajoute un article à la commande et décrémente le stock
     * @throws RuntimeException si le stock est insuffisant
     */
    public function addItem(Product $product, int $quantity): void
    {
        if ($this->status !== 'pending') {
            throw new RuntimeException("Impossible de modifier une commande non en attente");
        }

        if ($quantity <= 0) {
            throw new InvalidArgumentException("La quantité doit être positive");
        }

        if ($quantity > $product->getStock()) {
            throw new RuntimeException(
                "Stock insuffisant pour {$product->getName()}. " .
                "Disponible: {$product->getStock()}, Demandé: {$quantity}"
            );
        }

        foreach ($this->items as $item) {
            if ($item->getProduct()->getId() === $product->getId()) {
                throw new RuntimeException(
                    "Le produit {$product->getName()} est déjà dans la commande. " .
                    "Utilisez removeItem puis addItem pour modifier."
                );
            }
        }

        $product->reduceStock($quantity);

        $this->items[] = new OrderItem( $product, $quantity);
        $this->recalculateTotal();
    }

    public function removeItem(Product $product): void
    {
        if ($this->status !== 'pending') {
            throw new RuntimeException("Impossible de modifier une commande non en attente");
        }

        $productId = $product->getId();
        $found = false;

        foreach ($this->items as $key => $item) {
            if ($item->getProduct()->getId() === $productId) {
                $currentStock = $product->getStock();
                $product->setStock($currentStock + $item->getQuantity());
                
                unset($this->items[$key]);
                $this->items = array_values($this->items); // Réindexe le tableau
                $found = true;
                break;
            }
        }

        if (!$found) {
            throw new OutOfBoundsException("Produit non trouvé dans la commande");
        }

        $this->recalculateTotal();
    }

    /**
     * Recalcule le total de la commande
     */
    private function recalculateTotal(): void
    {
        $this->total = 0.0;
        foreach ($this->items as $item) {
            $this->total += $item->getSubtotal();
        }
    }

    /**
     * Valide la commande avant paiement
     */
    public function validate(): bool
    {
        if (empty($this->items)) {
            throw new RuntimeException("La commande est vide");
        }

        foreach ($this->items as $item) {
            if (!$item->getProduct()->isAvailable()) {
                throw new RuntimeException(
                    "Le produit {$item->getProduct()->getName()} n'est plus disponible"
                );
            }
        }

        return true;
    }

    /**
     * Confirme la commande (après paiement)
     */
    public function confirm(): void
    {
        $this->validate();
        $this->status = 'paid';
    }

    public function __toString(): string
    {
        $output = "Commande #{$this->id} - {$this->customer->getFullName()}\n";
        $output .= "Statut: {$this->status} | Date: {$this->createdAt->format('Y-m-d H:i:s')}\n";
        $output .= "Articles:\n";
        
        foreach ($this->items as $item) {
            $output .= "  - {$item}\n";
        }
        
        $output .= "Total: {$this->total} PO";
        return $output;
    }
}
