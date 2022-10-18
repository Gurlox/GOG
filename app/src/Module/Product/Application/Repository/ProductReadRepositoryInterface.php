<?php

declare(strict_types=1);

namespace App\Module\Product\Application\Repository;

use App\Module\SharedKernel\DTO\ProductReadDTO;
use App\Module\SharedKernel\ValueObject\Paging;

interface ProductReadRepositoryInterface
{
    public function getById(int $id): ProductReadDTO;

    public function getPaginatedList(Paging $paging): array;

    public function countAll(): int;

    /**
     * @return ProductReadDTO[]
     */
    public function getAllByIds(array $ids): array;
}
