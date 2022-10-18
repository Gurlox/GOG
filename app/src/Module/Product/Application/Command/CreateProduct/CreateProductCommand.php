<?php

declare(strict_types=1);

namespace App\Module\Product\Application\Command\CreateProduct;

use App\Core\Command\Command;

class CreateProductCommand extends Command
{
    public function __construct(
        public readonly string $title,
        public readonly int $priceAmount,
    ) {
    }
}
