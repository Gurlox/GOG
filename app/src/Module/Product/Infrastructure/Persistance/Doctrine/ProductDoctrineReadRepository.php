<?php

declare(strict_types=1);

namespace App\Module\Product\Infrastructure\Persistance\Doctrine;

use App\Module\Product\Application\Repository\ProductReadRepositoryInterface;
use App\Module\Product\Domain\Entity\Product;
use App\Module\SharedKernel\ValueObject\Paging;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Module\SharedKernel\DTO\ProductReadDTO;

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

    public function getPaginatedList(Paging $paging): array
    {
        $products = $this->getEntityManager()->getRepository(Product::class)
            ->createQueryBuilder('p')
            ->select('p')
            ->setFirstResult($paging->getOffset())
            ->setMaxResults($paging->getLimit())
            ->getQuery()
            ->getResult();

        $result = [];

        foreach ($products as $product) {
            $result[] = ProductReadDTO::createFromProduct($product);
        }

        return $result;
    }

    public function countAll(): int
    {
        return $this->getEntityManager()->getRepository(Product::class)
            ->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @inheritDoc
     */
    public function getAllByIds(array $ids): array
    {
        $products = $this->getEntityManager()->getRepository(Product::class)
            ->createQueryBuilder('p')
            ->select('p')
            ->where('p.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();

        $result = [];

        foreach ($products as $product) {
            $result[] = ProductReadDTO::createFromProduct($product);
        }

        return $result;
    }
}
