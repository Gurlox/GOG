<?php

declare(strict_types=1);

namespace App\Module\Cart\Domain\ReadModel;

class CartPrices
{
    public function __construct(
        public readonly int $totalPriceNet,
        public readonly int $totalPriceGross,
    ) {
    }
}
