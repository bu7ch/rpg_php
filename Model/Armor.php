<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Product;
use Category;


class Armor extends Product
{
    private int $defense;
    private string $size;

    public function __construct(
        int $id,
        string $name,
        float $price,
        Category $category,
        int $stock,
        int $defense,
        string $size
    ) {
        parent::__construct($id, $name, $price, $category, $stock);
        $this->defense = $defense;
        $this->size = $size;
    }

    public function getDefense(): int
    {
        return $this->defense;
    }

    public function setDefense(int $defense): void
    {
        $this->defense = $defense;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function setSize(string $size): void
    {
        $this->size = $size;
    }

    public function __toString(): string
    {
        return parent::__toString() . 
               " [Armure] Défense: {$this->defense}, Taille: {$this->size}";
    }
}
