<?php

declare(strict_types=1);

namespace App\Tests\functional\Cart;

use App\Tests\functional\FunctionalTestInterface;
use App\Tests\functional\Product\ProductTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddProductToCartTest extends WebTestCase implements FunctionalTestInterface
{
    public function testAddProductToCartShouldSucceed(): void
    {
        // given
        $client = static::createClient();
        $price1 = 2000;
        $product1Id = ProductTestCase::createProductRequest($client, 'Title', $price1)['productId'];
        $price2 = 1500;
        $product2Id = ProductTestCase::createProductRequest($client, 'Title2', $price2)['productId'];
        $cartId = CartTestCase::createCartRequest($client)['cartId'];
        $quantity1 = 2;
        $quantity2 = 3;

        // when then
        CartTestCase::postCartProductRequest($client, $cartId, $product1Id, $quantity1);
        $result = CartTestCase::postCartProductRequest($client, $cartId, $product2Id, $quantity2);
        $this->assertEquals($cartId, $result['cart']['id']);
        $this->assertCount(2, $result['cart']['products']);
        $this->assertEquals($product1Id, $result['cart']['products'][0]['product']['id']);
        $this->assertEquals($product2Id, $result['cart']['products'][1]['product']['id']);
        $this->assertEquals($price1, $result['cart']['products'][0]['product']['price']['netPrice']);
        $this->assertEquals($price2, $result['cart']['products'][1]['product']['price']['netPrice']);
        $this->assertEquals($quantity1, $result['cart']['products'][0]['quantity']);
        $this->assertEquals($quantity2, $result['cart']['products'][1]['quantity']);
        $this->assertEquals(($price1 * $quantity1) + ($price2 * $quantity2), $result['cart']['prices']['totalPriceNet']);
    }
}
