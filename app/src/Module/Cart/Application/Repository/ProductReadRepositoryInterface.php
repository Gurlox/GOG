<?php

declare(strict_types=1);

namespace App\Module\Cart\Application\Repository;

use App\Module\SharedKernel\DTO\ProductReadDTO;

interface ProductReadRepositoryInterface
{
    public function doesProductExist(int $id): bool;

    /**
     * @param int[] $ids
     * @return ProductReadDTO[]
     */
    public function getProductsReadDTOByIds(array $ids): array;
}
