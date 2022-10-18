<?php

declare(strict_types=1);

namespace App\Module\Cart\Application\Query\GetCartById;

use App\Core\Query\QueryHandler;
use App\Module\Cart\Application\DTO\CartReadDTO;
use App\Module\Cart\Application\Repository\CartReadRepositoryInterface;

class GetCartByIdQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly CartReadRepositoryInterface $cartReadRepository,
    ) {
    }

    public function __invoke(GetCartByIdQuery $query): CartReadDTO
    {
        return $this->cartReadRepository->getById($query->cartId);
    }
}
