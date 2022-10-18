<?php

declare(strict_types=1);

namespace App\Module\Cart\Application\Command\CreateCartCommand;

use App\Core\Command\CommandHandler;
use App\Module\Cart\Domain\Entity\Cart;
use App\Module\Cart\Domain\Repository\CartRepositoryInterface;

class CreateCartCommandHandler implements CommandHandler
{
    public function __construct(
        private CartRepositoryInterface $cartRepository,
    ) {
    }

    public function __invoke(CreateCartCommand $command): int
    {
        $cart = new Cart();
        $this->cartRepository->save($cart);

        return $cart->getId();
    }
}
