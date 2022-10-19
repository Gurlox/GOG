<?php

declare(strict_types=1);

namespace App\Tests\unit\Module\Cart\Domain\Entity;

use App\Module\Cart\Domain\Entity\Cart;
use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    public function testAddProductWhenProductDoesNotExistInCartShouldAddProduct(): void
    {
        // given
        $productId = 1;
        $quantity = 2;
        $cart = new Cart();

        // when then
        $cart->addProduct($productId, $quantity);
        $this->assertCount(1, $cart->getProducts());
        $this->assertEquals($productId, $cart->getProducts()->first()->getProductId());
        $this->assertEquals($quantity, $cart->getProducts()->first()->getQuantity());
    }

    public function testAddProductWhenProductExistsShouldAddQuantityToIt(): void
    {
        // given
        $productId = 1;
        $quantity = 2;
        $cart = new Cart();
        $cart->addProduct($productId, $quantity);
        $cart->addProduct(2, 3);

        // when then
        $cart->addProduct($productId, 4);
        $this->assertCount(2, $cart->getProducts());
        $this->assertEquals($productId, $cart->getProducts()->first()->getProductId());
        $this->assertEquals(6, $cart->getProducts()->first()->getQuantity());
    }

    public function testAddProductWhenAlready3ProductsInCartShouldThrowException(): void
    {
        // given
        $cart = new Cart();
        $cart->addProduct(1, 2);
        $cart->addProduct(2, 3);
        $cart->addProduct(3, 3);

        // when then
        $this->expectException(InvalidArgumentException::class);
        $cart->addProduct(4, 1);
    }

    public function testGetProductIdsShouldReturnFlatArrayOfIds(): void
    {
        // given
        $cart = new Cart();
        $cart->addProduct(1, 2);
        $cart->addProduct(2, 3);
        $cart->addProduct(3, 3);

        // when then
        $result = $cart->getProductIds();
        $this->assertCount(3, $result);
        $this->assertEquals(1, $result[0]);
        $this->assertEquals(2, $result[1]);
        $this->assertEquals(3, $result[2]);
    }

    public function testRemoveProductWhenProductDoesntExistShouldThrowException(): void
    {
        // given
        $cart = new Cart();

        // when then
        $this->expectException(\InvalidArgumentException::class);
        $cart->removeProduct(10);
    }

    public function testRemoveProductFromCartShouldSucceed(): void
    {
        // given
        $cart = new Cart();
        $productId = 1;
        $cart->addProduct($productId, 2);

        // when then
        $cart->removeProduct($productId);
        $this->assertCount(0, $cart->getProducts());
    }
}
