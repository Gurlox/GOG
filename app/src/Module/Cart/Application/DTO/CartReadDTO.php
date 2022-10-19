<?php

declare(strict_types=1);

namespace App\Module\Cart\Application\DTO;

use App\Module\Cart\Domain\ReadModel\CartPrices;

class CartReadDTO
{
    /**
     * @param CartProductReadDTO[] $products
     */
    public function __construct(
        public readonly int $id,
        public readonly array $products,
        public readonly CartPrices $prices,
    ) {
    }
}
