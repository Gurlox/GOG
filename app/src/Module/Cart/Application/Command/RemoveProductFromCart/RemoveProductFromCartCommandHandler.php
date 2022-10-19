<?php

declare(strict_types=1);

namespace App\Module\Cart\Application\Command\RemoveProductFromCart;

use App\Core\Command\CommandHandler;
use App\Module\Cart\Domain\Repository\CartRepositoryInterface;

class RemoveProductFromCartCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
    ) {
    }

    public function __invoke(RemoveProductFromCartCommand $command): void
    {
        $cart = $this->cartRepository->getById($command->cartId);
        $cart->removeProduct($command->productId);

        $this->cartRepository->save($cart);
    }
}
