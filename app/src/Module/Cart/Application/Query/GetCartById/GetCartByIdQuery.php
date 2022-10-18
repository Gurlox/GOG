<?php

declare(strict_types=1);

namespace App\Module\Cart\Application\Query\GetCartById;

use App\Core\Query\Query;

class GetCartByIdQuery extends Query
{
    public function __construct(
        public readonly int $cartId,
    ) {
    }
}
