<?php 

declare(strict_types=1);

use Category;
use Product;

class Weapon extends Product {
    private int $damage;
    private string $material;

    public function __construct(int $id, string $name, float $price, Category $category, int $stock, int $damage, string $material)
    {
        return parent::__construct($id, $name, $price, $category, $stock);
        $this->damage = $damage;
        $this->material = $material;
    }
    //* getter/setter damage & material */
    public function getDamage(): int
    {
        return $this->damage;
    }
    public function setDamage(int $damage): void
    {
        $this->damage = $damage;
    }
    public function getMaterial(): string
    {
        return $this->material;
    }
    public function setMaterial(string $material): void
    {
        $this->material = $material;
    }

    public function __toString():string {
        return "[Arme] - Dégâts: {$this->damage} - Materiaux: {$this->material}";

    }
}