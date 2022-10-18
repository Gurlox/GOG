<?php

declare(strict_types=1);

namespace App\Module\Cart\Domain\Repository;

use App\Module\Cart\Domain\Entity\Cart;

interface CartRepositoryInterface
{
    public function save(Cart $cart): void;
}
