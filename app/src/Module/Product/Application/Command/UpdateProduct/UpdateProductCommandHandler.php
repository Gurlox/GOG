<?php

declare(strict_types=1);

namespace App\Module\Product\Application\Command\UpdateProduct;

use App\Core\Command\CommandHandler;
use App\Module\Product\Domain\Repository\ProductRepositoryInterface;

class UpdateProductCommandHandler implements CommandHandler
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
    ) {
    }

    public function __invoke(UpdateProductCommand $command): void
    {
        $product = $this->productRepository->findById($command->id);
        $product->setTitle($command->title);

        if (null !== $command->priceAmount) {
            $product->updateNetAmount($command->priceAmount);
        }

        $this->productRepository->save($product);
    }
}
