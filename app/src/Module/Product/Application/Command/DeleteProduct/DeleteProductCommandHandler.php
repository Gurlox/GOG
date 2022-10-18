<?php

declare(strict_types=1);

namespace App\Module\Product\Application\Command\DeleteProduct;

use App\Core\Command\CommandHandler;
use App\Module\Product\Domain\Repository\ProductRepositoryInterface;

class DeleteProductCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
    ) {
    }

    public function __invoke(DeleteProductCommand $command): void
    {
        $this->productRepository->delete($this->productRepository->findById($command->productId));
    }
}
