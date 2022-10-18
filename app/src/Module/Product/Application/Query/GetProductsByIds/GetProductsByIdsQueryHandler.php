<?php

declare(strict_types=1);

namespace App\Module\Product\Application\Query\GetProductsByIds;

use App\Core\Query\QueryHandler;
use App\Module\Product\Application\Repository\ProductReadRepositoryInterface;
use App\Module\SharedKernel\DTO\ProductReadDTO;
use Assert\Assert;

class GetProductsByIdsQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly ProductReadRepositoryInterface $productReadRepository,
    ) {
    }

    /**
     * @return ProductReadDTO[]
     */
    public function __invoke(GetProductsByIdsQuery $query): array
    {
        foreach ($query->ids as $id) {
            Assert::that($id)->integer('product id should be integer');
        }

        return $this->productReadRepository->getAllByIds($query->ids);
    }
}
