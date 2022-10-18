<?php

declare(strict_types=1);

namespace App\Module\Cart\Infrastructure\ACL;

use App\Core\Query\QueryBus;
use App\Module\Cart\Application\Repository\ProductReadRepositoryInterface;
use App\Module\Product\Application\Query\GetProductById\GetProductByIdQuery;
use App\Module\Product\Application\Query\GetProductsByIds\GetProductsByIdsQuery;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductReadRepository implements ProductReadRepositoryInterface
{
    public function __construct(
        private readonly QueryBus $queryBus,
    ) {
    }

    public function doesProductExist(int $id): bool
    {
        try {
            $this->queryBus->handle(new GetProductByIdQuery($id));

            return true;
        } catch (NotFoundHttpException) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function getProductsReadDTOByIds(array $ids): array
    {
        return $this->queryBus->handle(new GetProductsByIdsQuery($ids));
    }
}
