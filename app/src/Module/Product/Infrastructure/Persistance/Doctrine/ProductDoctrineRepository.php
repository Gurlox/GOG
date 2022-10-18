<?php

declare(strict_types=1);

namespace App\Module\Product\Infrastructure\Persistance\Doctrine;

use App\Module\Product\Domain\Entity\Product;
use App\Module\Product\Domain\Repository\ProductRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductDoctrineRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(
        ManagerRegistry $managerRegistry,
    ) {
        parent::__construct($managerRegistry, Product::class);
    }

    public function save(Product $product): void
    {
        try {
            $this->getEntityManager()->persist($product);
            $this->getEntityManager()->flush();
        } catch (UniqueConstraintViolationException) {
            throw new BadRequestException('Title should be unique');
        }
    }

    public function delete(Product $product): void
    {
        $this->getEntityManager()->remove($product);
        $this->getEntityManager()->flush();
    }

    /**
     * @throws NotFoundHttpException
     */
    public function findById(int $id): Product
    {
        /** @var ?Product $product */
        $product = $this->getEntityManager()->getRepository(Product::class)->find($id);

        if (null === $product) {
            throw new NotFoundHttpException('Product not found');
        }

        return $product;
    }
}
