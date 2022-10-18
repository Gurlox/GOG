<?php

declare(strict_types=1);

namespace App\Tests\unit\Module\Cart\Domain\Entity;

use App\Module\Cart\Domain\Entity\CartProduct;
use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CartProductTest extends TestCase
{
    public function testAddQuantityShouldThrowExceptionWithQuantityOver10(): void
    {
        // given
        $cartProduct = new CartProduct(1, 6);

        // when then
        $this->expectException(InvalidArgumentException::class);
        $cartProduct->addQuantity(5);
    }

    public function testAddQuantityShouldIncreaseQuantity(): void
    {
        // given
        $cartProduct = new CartProduct(1, 4);

        // when then
        $cartProduct->addQuantity(3);
        $this->assertEquals(7, $cartProduct->getQuantity());
    }
}
