<?php

declare(strict_types=1);

namespace App\Module\Cart\Application\Command\AddProductToCart;

use App\Core\Command\CommandHandler;
use App\Module\Cart\Application\Repository\ProductReadRepositoryInterface;
use App\Module\Cart\Domain\Repository\CartRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AddProductToCartCommandHandler implements CommandHandler
{
    public function __construct(
        private CartRepositoryInterface $cartRepository,
        private ProductReadRepositoryInterface $productReadRepository,
    ) {
    }

    public function __invoke(AddProductToCartCommand $command): void
    {
        if (false === $this->productReadRepository->doesProductExist($command->productId)) {
            throw new NotFoundHttpException(sprintf('Product with id %d does\'t exist', $command->productId));
        }

        $cart = $this->cartRepository->getById($command->cartId);
        $cart->addProduct($command->productId, $command->quantity);

        $this->cartRepository->save($cart);
    }
}
