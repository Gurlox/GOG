<?php

declare(strict_types=1);

namespace App\Module\Cart\Infrastructure\Persistance\Doctrine;

use App\Module\Cart\Domain\Entity\Cart;
use App\Module\Cart\Domain\Repository\CartRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CartDoctrineRepository extends ServiceEntityRepository implements CartRepositoryInterface
{
    public function __construct(
        ManagerRegistry $managerRegistry,
    ) {
        parent::__construct($managerRegistry, Cart::class);
    }

    public function save(Cart $cart): void
    {
        $this->getEntityManager()->persist($cart);
        $this->getEntityManager()->flush();
    }
}
