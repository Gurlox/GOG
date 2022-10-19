<?php

declare(strict_types=1);

namespace App\Tests\unit\Module\Cart\Infrastructure\Persistance\Doctrine;

use App\Module\Cart\Application\Repository\ProductReadRepositoryInterface;
use App\Module\Cart\Domain\Entity\Cart;
use App\Module\Cart\Domain\Entity\CartProduct;
use App\Module\Cart\Domain\Factory\CartPricesFactory;
use App\Module\Cart\Domain\ReadModel\CartPrices;
use App\Module\Cart\Infrastructure\Persistance\Doctrine\CartDoctrineReadRepository;
use App\Module\SharedKernel\DTO\PriceReadDTO;
use App\Module\SharedKernel\DTO\ProductReadDTO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use PHPUnit\Framework\MockObject\MockObject;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;

class CartDoctrineReadRepositoryTest extends TestCase
{
    private MockObject|ManagerRegistry $managerRegistry;
    private MockObject|EntityManagerInterface $entityManager;
    private MockObject|ProductReadRepositoryInterface $productReadRepository;
    private MockObject|CartPricesFactory $cartPricesFactory;
    private CartDoctrineReadRepository $cartDoctrineReadRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->managerRegistry = $this->createMock(ManagerRegistry::class);
        $this->managerRegistry
            ->method('getManagerForClass')
            ->willReturn($this->entityManager);
        $this->entityManager
            ->method('getClassMetaData')
            ->willReturn($this->createMock(ClassMetadata::class));

        $this->productReadRepository = $this->createMock(ProductReadRepositoryInterface::class);
        $this->cartPricesFactory = $this->createMock(CartPricesFactory::class);
        $this->cartDoctrineReadRepository = new CartDoctrineReadRepository(
            $this->managerRegistry,
            $this->productReadRepository,
            $this->cartPricesFactory,
        );
    }

    public function testGetByIdShouldBuildCartReadDTO(): void
    {
        // given
        $id = 10;
        $cart = $this->createMock(Cart::class);
        $product1 = new ProductReadDTO(
            1,
            'title',
            new PriceReadDTO(
                100,
                123,
                'USD',
                23,
            ),
        );
        $product2 = new ProductReadDTO(
            2,
            'title',
            new PriceReadDTO(
                100,
                123,
                'USD',
                23,
            ),
        );
        $productsRead = [
            $product1,
            $product2,
        ];
        $cartProduct1 = $this->createMock(CartProduct::class);
        $cartProduct2 = $this->createMock(CartProduct::class);
        $cartProducts = new ArrayCollection([
            $cartProduct1,
            $cartProduct2,
        ]);
        $repository = $this->createMock(EntityRepository::class);
        $cartPrices = new CartPrices(200, 246);

        // when
        $cart
            ->method('getProductIds')
            ->willReturn([1, 2]);
        $cart
            ->method('getProducts')
            ->willReturn($cartProducts);
        $cartProduct1
            ->method('getProductId')
            ->willReturn(1);
        $cartProduct1
            ->method('getQuantity')
            ->willReturn(2);
        $cartProduct2
            ->method('getProductId')
            ->willReturn(2);
        $cartProduct2
            ->method('getQuantity')
            ->willReturn(3);
        $this->entityManager
            ->method('getRepository')
            ->willReturn($repository);
        $repository
            ->method('find')
            ->with($id)
            ->willReturn($cart);
        $this->productReadRepository
            ->method('getProductsReadDTOByIds')
            ->willReturn($productsRead);
        $this->cartPricesFactory
            ->method('createFromProductPrices')
            ->willReturn($cartPrices);

        // then
        $result = $this->cartDoctrineReadRepository->getById($id);
        $this->assertEquals($id, $result->id);
        $this->assertCount(2, $result->products);
        $this->assertEquals($cartPrices, $result->prices);
        $this->assertEquals(2, $result->products[0]->quantity);
        $this->assertEquals(3, $result->products[1]->quantity);
    }
}
