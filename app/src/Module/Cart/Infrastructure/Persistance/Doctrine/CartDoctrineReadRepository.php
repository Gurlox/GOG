<?php

declare(strict_types=1);

namespace App\Module\Cart\Infrastructure\Persistance\Doctrine;

use App\Module\Cart\Application\DTO\CartProductReadDTO;
use App\Module\Cart\Application\DTO\CartReadDTO;
use App\Module\Cart\Application\Repository\CartReadRepositoryInterface;
use App\Module\Cart\Application\Repository\ProductReadRepositoryInterface;
use App\Module\Cart\Domain\Entity\Cart;
use App\Module\Cart\Domain\Factory\CartPricesFactory;
use App\Module\Cart\Domain\ReadModel\ProductCartPrice;
use App\Module\SharedKernel\ValueObject\Price;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Money\Currency;
use Money\Money;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CartDoctrineReadRepository extends ServiceEntityRepository implements CartReadRepositoryInterface
{
    public function __construct(
        ManagerRegistry $managerRegistry,
        private readonly ProductReadRepositoryInterface $productReadRepository,
        private readonly CartPricesFactory $cartPricesFactory,
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

        $products = $this->productReadRepository->getProductsReadDTOByIds($cart->getProductIds());
        $productsAssociative = [];
        /** @var CartProductReadDTO[] $cartProducts */
        $cartProducts = [];
        /** @var Price[] $productPrices */
        $productPrices = [];

        foreach ($products as $product) {
            $productsAssociative[$product->id] = $product;
        }

        foreach ($cart->getProducts() as $cartProduct) {
            $productRead = $productsAssociative[$cartProduct->getProductId()];
            $cartProducts[] = new CartProductReadDTO(
                $productRead,
                $cartProduct->getQuantity(),
            );
            $productPrices[] = new ProductCartPrice(
                new Price(
                    new Money($productRead->price->netPrice, new Currency($productRead->price->currency)),
                    $productRead->price->taxRate,
                ),
                $cartProduct->getQuantity(),
            );
        }

        return new CartReadDTO(
            $id,
            $cartProducts,
            $this->cartPricesFactory->createFromProductPrices($productPrices),
        );
    }
}
