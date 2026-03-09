<?php

declare(strict_types=1);

use Category;

class Product
{
    private int $id;
    private string $name;
    private float $price;
    private Category $category;
    private int $stock;

    public function __construct(int $id, string $name, float $price, Category $category, int $stock = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->stock = $stock;
    }
    // getter getId
    public function getId(): int
    {
        return $this->id;
    }
    // setter setId
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    // getName
    public function getName(): string
    {
        return $this->name;
    }
    // setName
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    // getPrice
    public function getPrice(): float
    {
        return $this->price;
    }
    // setprice
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
    // getCategory
    public function getCategory(): Category
    {
        return $this->category;
    }
    // setCategory
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }
    // getStock
    public function getStock(): int
    {
        return $this->stock;
    }
    // setStock
    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    public function isAvailable(): bool
    {
        return $this->stock > 0;
    }
    public function reduceStock(int $quantity): void
    {
        if ($quantity <= 0) {
        }
        if ($quantity > $this->stock) {
        }
        $this->stock -= $quantity;
    }

    public function __toString(): string
    {
        return " Produit #{$this->id} : {$this->name} ({$this->price} PO) - Stock: {$this->stock}";
    }
}
