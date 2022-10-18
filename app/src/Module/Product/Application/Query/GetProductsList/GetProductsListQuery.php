<?php

declare(strict_types=1);

namespace App\Module\Product\Application\Query\GetProductsList;

use App\Core\Query\Query;

class GetProductsListQuery extends Query
{
    public function __construct(
        public readonly int $page,
        public readonly int $perPage,
    ) {
    }
}
