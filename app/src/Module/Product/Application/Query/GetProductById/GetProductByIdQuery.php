<?php

declare(strict_types=1);

namespace App\Module\Product\Application\Query\GetProductById;

use App\Core\Query\Query;

class GetProductByIdQuery extends Query
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
