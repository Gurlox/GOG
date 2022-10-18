<?php

declare(strict_types=1);

namespace App\Module\Product\Application\Query\GetProductById;

use App\Core\Query\QueryHandler;
use App\Module\Product\Application\DTO\ProductReadDTO;
use App\Module\Product\Application\Repository\ProductReadRepositoryInterface;

class GetProductByIdQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly ProductReadRepositoryInterface $productReadRepository,
    ) {
    }

    public function __invoke(GetProductByIdQuery $query): ProductReadDTO
    {
        return $this->productReadRepository->getById($query->id);
    }
}
