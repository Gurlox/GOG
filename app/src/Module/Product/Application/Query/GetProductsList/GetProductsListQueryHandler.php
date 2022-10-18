<?php

declare(strict_types=1);

namespace App\Module\Product\Application\Query\GetProductsList;

use App\Core\Query\QueryHandler;
use App\Module\Product\Application\DTO\ProductsListReadDTO;
use App\Module\Product\Application\Repository\ProductReadRepositoryInterface;
use App\Module\SharedKernel\ValueObject\Paging;
use Assert\Assert;

class GetProductsListQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly ProductReadRepositoryInterface $productReadRepository,
    ) {
    }

    public function __invoke(GetProductsListQuery $query): ProductsListReadDTO
    {
        Assert::that($query->perPage)->max(3, 'maximum products per page is 3');

        return new ProductsListReadDTO(
            $this->productReadRepository->getPaginatedList(
                new Paging($query->page, $query->perPage),
            ),
            $this->productReadRepository->countAll(),
        );
    }
}
