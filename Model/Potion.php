<?php

declare(strict_types=1);

use Category;
use Product;

class Potion extends Product
{
    private string $effect;
    private int $duration;

    public function __construct(
        int $id,
        string $name,
        float $price,
        Category $category,
        int $stock,
        string $effect,
        int $duration
    ) {
        parent::__construct($id, $name, $price, $category, $stock);
        $this->effect = $effect;
        $this->duration = $duration;
    }

    public function getEffect(): string
    {
        return $this->effect;
    }

    public function setEffect(string $effect): void
    {
        $this->effect = $effect;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    public function __toString(): string
    {
        return parent::__toString() .
            " [Potion] Effet: {$this->effect}, Durée: {$this->duration}min";
    }
}
