<?php
declare(strict_types=1);

namespace App\Module\Cart\Domain\ReadModel;

use App\Module\SharedKernel\ValueObject\Price;

class ProductCartPrice
{
    public function __construct(
        public readonly Price $price,
        public readonly int $quantity,
    ) {
    }
}
