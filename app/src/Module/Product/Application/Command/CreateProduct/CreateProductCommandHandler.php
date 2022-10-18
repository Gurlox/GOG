<?php

declare(strict_types=1);

namespace App\Module\Product\Application\Command\CreateProduct;

use App\Core\Command\CommandHandler;
use App\Module\Product\Domain\Entity\Product;
use App\Module\Product\Domain\Repository\ProductRepositoryInterface;
use App\Module\SharedKernel\ValueObject\Price;
use Money\Currency;
use Money\Money;

class CreateProductCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
    ) {
    }

    public function __invoke(CreateProductCommand $command): int
    {
        $product = new Product(
            $command->title,
            new Price(
                new Money($command->priceAmount, new Currency($command->currency)),
                $command->taxRate,
            )
        );

        $this->productRepository->save($product);

        return $product->getId();
    }
}
