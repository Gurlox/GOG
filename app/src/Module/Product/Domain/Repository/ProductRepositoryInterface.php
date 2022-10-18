<?php

declare(strict_types=1);

namespace App\Module\Product\Domain\Repository;

use App\Module\Product\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    public function save(Product $product): void;

    public function delete(Product $product): void;

    public function findById(int $id): Product;
}
