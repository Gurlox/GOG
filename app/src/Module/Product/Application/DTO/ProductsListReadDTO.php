<?php

declare(strict_types=1);

namespace App\Module\Product\Application\DTO;

class ProductsListReadDTO
{
    /**
     * @param ProductReadDTO[] $products
     */
    public function __construct(
        public readonly array $products,
        public readonly int $totalCount,
    ) {
    }
}
