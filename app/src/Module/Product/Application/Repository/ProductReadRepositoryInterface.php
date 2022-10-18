<?php

declare(strict_types=1);

namespace App\Module\Product\Application\Repository;

use App\Module\Product\Application\DTO\ProductReadDTO;

interface ProductReadRepositoryInterface
{
    public function getById(int $id): ProductReadDTO;
}
