<?php

declare(strict_types=1);

namespace App\Module\Cart\Application\DTO;

use App\Module\SharedKernel\DTO\ProductReadDTO;

class CartReadDTO
{
    /**
     * @param ProductReadDTO[] $products
     */
    public function __construct(
        public readonly int $id,
        public readonly array $products,
    ) {
    }
}
