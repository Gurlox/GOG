<?php

declare(strict_types=1);

namespace App\Module\Cart\Application\DTO;

use App\Module\SharedKernel\DTO\ProductReadDTO;

class CartProductReadDTO
{
    public function __construct(
        public readonly ProductReadDTO $product,
        public readonly int $quantity,
    ) {
    }
}
