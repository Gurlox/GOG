<?php

declare(strict_types=1);

namespace App\Module\Product\Infrastructure\Persistance\Doctrine;

use App\Module\Product\Application\DTO\ProductReadDTO;
use App\Module\Product\Application\Repository\ProductReadRepositoryInterface;
use App\Module\Product\Domain\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductDoctrineReadRepository extends ServiceEntityRepository implements ProductReadRepositoryInterface
{
    public function __construct(
        ManagerRegistry $managerRegistry,
    ) {
        parent::__construct($managerRegistry, Product::class);
    }

    public function getById(int $id): ProductReadDTO
    {
        /** @var ?Product $product */
        $product = $this->getEntityManager()->getRepository(Product::class)->find($id);

        if (null === $product) {
            throw new NotFoundHttpException('Product not found');
        }

        return ProductReadDTO::createFromProduct($product);
    }
}
