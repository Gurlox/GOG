<?php

declare(strict_types=1);

namespace App\Module\Cart\Application\Repository;

use App\Module\Cart\Application\DTO\CartReadDTO;

interface CartReadRepositoryInterface
{
    public function getById(int $id): CartReadDTO;
}
