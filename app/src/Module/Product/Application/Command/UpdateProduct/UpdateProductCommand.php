<?php

declare(strict_types=1);

namespace App\Module\Product\Application\Command\UpdateProduct;

use App\Core\Command\Command;

class UpdateProductCommand extends Command
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly ?int $priceAmount,
    ) {
    }
}
