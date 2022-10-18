<?php

declare(strict_types=1);

namespace App\Module\SharedKernel\DTO;

use App\Module\Product\Domain\Entity\Product;

class ProductReadDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly PriceReadDTO $price,
    ) {
    }

    public static function createFromProduct(Product $product): self
    {
        return new self(
            $product->getId(),
            $product->getTitle(),
            PriceReadDTO::createFromPrice($product->getPrice()),
        );
    }
}
