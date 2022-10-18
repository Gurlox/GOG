<?php

declare(strict_types=1);

namespace App\Module\Cart\Infrastructure\Persistance\Doctrine;

use App\Module\Cart\Application\DTO\CartReadDTO;
use App\Module\Cart\Application\Repository\CartReadRepositoryInterface;
use App\Module\Cart\Application\Repository\ProductReadRepositoryInterface;
use App\Module\Cart\Domain\Entity\Cart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CartDoctrineReadRepository extends ServiceEntityRepository implements CartReadRepositoryInterface
{
    public function __construct(
        ManagerRegistry $managerRegistry,
        private readonly ProductReadRepositoryInterface $productReadRepository,
    ) {
        parent::__construct($managerRegistry, Cart::class);
    }

    public function getById(int $id): CartReadDTO
    {
        /** @var ?Cart $cart */
        $cart = $this->getEntityManager()->getRepository(Cart::class)->find($id);

        if (null === $cart) {
            throw new NotFoundHttpException('Cart not found');
        }

        return new CartReadDTO(
            $cart->getId(),
            $this->productReadRepository->getProductsReadDTOByIds($cart->getProductIds()),
        );
    }
}
