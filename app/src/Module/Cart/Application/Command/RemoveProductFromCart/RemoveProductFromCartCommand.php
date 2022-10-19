<?php

declare(strict_types=1);

namespace App\Module\Cart\Application\Command\RemoveProductFromCart;

use App\Core\Command\Command;

class RemoveProductFromCartCommand extends Command
{
    public function __construct(
        public readonly int $cartId,
        public readonly int $productId,
    ) {
    }
}
