<?php

declare(strict_types=1);

namespace App\Module\Product\Application\Query\GetProductsByIds;

use App\Core\Query\Query;

class GetProductsByIdsQuery extends Query
{
    public function __construct(
        public readonly array $ids,
    ) {
    }
}
