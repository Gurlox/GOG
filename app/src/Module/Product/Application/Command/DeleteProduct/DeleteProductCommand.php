<?php

declare(strict_types=1);

namespace App\Module\Product\Application\Command\DeleteProduct;

use App\Core\Command\Command;

class DeleteProductCommand extends Command
{
    public function __construct(
        public readonly int $productId,
    ) {
    }
}
