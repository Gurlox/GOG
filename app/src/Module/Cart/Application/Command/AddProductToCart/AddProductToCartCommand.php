<?php

declare(strict_types=1);

namespace App\Module\Cart\Application\Command\AddProductToCart;

use App\Core\Command\Command;

class AddProductToCartCommand extends Command
{
    public function __construct(
        public readonly int $cartId,
        public readonly int $productId,
        public readonly int $quantity,
    ) {
    }
}
